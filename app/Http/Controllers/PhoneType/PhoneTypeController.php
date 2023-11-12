<?php

namespace App\Http\Controllers\PhoneType;

use App\Http\Controllers\Controller;
use App\Models\PhoneType;
use App\Http\Requests\PhoneTypeRequest;
use DataTables;

class PhoneTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('phones-types.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhoneTypeRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        try {
            $phone_type = PhoneType::create($request->all());
            return redirect()->route('phones-types.show', ['id' => $phone_type->id_phone_type])->with('success', 'Registro cadastrado com sucesso');
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
        $data = PhoneType::find($id);
        if ($data) {
            return view('phones-types.index', compact('data'));
        } else {
            return redirect()->route('phones-types')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PhoneTypeRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new PhoneTypeRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $phone_type = PhoneType::find($id);
            if ($phone_type) {
                $phone_type->update($request->all());
                return redirect()->route('phones-types.show', ['id' => $phone_type->id_phone_type])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('phones-types')->with('error', 'Registro não encontrado!');
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
            $phone_type = PhoneType::find($id);
            if ($phone_type) {
                $phone_type->delete();
                return redirect()->route('phones-types')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('phones-types')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $id_system = request('__id_system');
        $data = PhoneType::latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'phones-types.show', [$id_field => $row->id_phone_type]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
