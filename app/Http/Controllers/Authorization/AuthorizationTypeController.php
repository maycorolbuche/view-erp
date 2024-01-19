<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Models\AuthorizationType;
use App\Http\Requests\AuthorizationTypeRequest;
use App\Helpers\DataTableHelper;

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

    public function datatable()
    {
        return DataTableHelper::authorizations_types();
    }
}
