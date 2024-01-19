<?php

namespace App\Http\Controllers\CivilStatus;

use App\Http\Controllers\Controller;
use App\Models\CivilStatus;
use App\Http\Requests\CivilStatusRequest;
use App\Helpers\DataTableHelper;

class CivilStatusController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('civil-statuses.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CivilStatusRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        try {
            $civil_status = CivilStatus::create($request->all());
            return redirect()->route('civil-statuses.show', ['id' => $civil_status->id_civil_status])->with('success', 'Registro cadastrado com sucesso');
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
        $data = CivilStatus::find($id);
        if ($data) {
            return view('civil-statuses.index', compact('data'));
        } else {
            return redirect()->route('civil-statuses')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CivilStatusRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new CivilStatusRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $civil_status = CivilStatus::find($id);
            if ($civil_status) {
                $civil_status->update($request->all());
                return redirect()->route('civil-statuses.show', ['id' => $civil_status->id_civil_status])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('civil-statuses')->with('error', 'Registro não encontrado!');
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
            $civil_status = CivilStatus::find($id);
            if ($civil_status) {
                $civil_status->delete();
                return redirect()->route('civil-statuses')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('civil-statuses')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
       return DataTableHelper::civil_statuses();
    }
}
