<?php

namespace App\Http\Controllers\RelationshipDegree;

use App\Http\Controllers\Controller;
use App\Models\RelationshipDegree;
use App\Http\Requests\RelationshipDegreeRequest;
use DataTables;

class RelationshipDegreeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('relationships-degrees.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RelationshipDegreeRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        try {
            $relationship_degree = RelationshipDegree::create($request->all());
            return redirect()->route('relationships-degrees.show', ['id' => $relationship_degree->id_relationship_degree])->with('success', 'Registro cadastrado com sucesso');
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
        $data = RelationshipDegree::find($id);
        if ($data) {
            return view('relationships-degrees.index', compact('data'));
        } else {
            return redirect()->route('relationships-degrees')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RelationshipDegreeRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new RelationshipDegreeRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $relationship_degree = RelationshipDegree::find($id);
            if ($relationship_degree) {
                $relationship_degree->update($request->all());
                return redirect()->route('relationships-degrees.show', ['id' => $relationship_degree->id_relationship_degree])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('relationships-degrees')->with('error', 'Registro não encontrado!');
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
            $relationship_degree = RelationshipDegree::find($id);
            if ($relationship_degree) {
                $relationship_degree->delete();
                return redirect()->route('relationships-degrees')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('relationships-degrees')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $data = RelationshipDegree::latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'relationships-degrees.show', [$id_field => $row->id_relationship_degree]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
