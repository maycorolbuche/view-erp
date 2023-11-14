<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Models\AuthorizationType;
use App\Http\Requests\AuthorizationTypeRequest;
use DataTables;

class AuthorizationTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('authorizations-types.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorizationTypeRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        try {
            $authorizations_type = AuthorizationType::create($request->all());
            return redirect()->route('authorizations-types.show', ['id' => $authorizations_type->id_authorization_type])->with('success', 'Registro cadastrado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = AuthorizationType::find($id);
        if ($data) {
            return view('authorizations-types.index', compact('data'));
        } else {
            return redirect()->route('authorizations-types')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorizationTypeRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new AuthorizationTypeRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $authorizations_type = AuthorizationType::find($id);
            if ($authorizations_type) {
                $authorizations_type->update($request->all());
                return redirect()->route('authorizations-types.show', ['id' => $authorizations_type->id_authorization_type])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('authorizations-types')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!in_array('destroy', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para excluir nessa página!')->withInput();
        }

        try {
            $authorizations_type = AuthorizationType::find($id);
            if ($authorizations_type) {
                $authorizations_type->delete();
                return redirect()->route('authorizations-types')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('authorizations-types')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $data = AuthorizationType::latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'authorizations-types.show', [$id_field => $row->id_authorization_type]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('approval', function ($row) {
                $items = [
                    'one' => '<span class="badge badge-info"><i class="fas fa-user"></i> Um Responsável</span>',
                    'all' => '<span class="badge badge-success"><i class="fas fa-users"></i> Todos os Responsáveis</span>',
                ];
                return $items[$row->approval];
            })
            ->rawColumns(['actions', 'approval'])
            ->make(true);
    }
}
