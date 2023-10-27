<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Http\Requests\SystemRequest;
use App\Helpers\Root;
use DataTables;

class SystemPermissionController extends Controller
{
    public function parent()
    {
        return view('systems.permissions.parent');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "INDEX";
        return view('systems.permissions.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SystemRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new SystemRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $system = System::find($id);
            if ($system) {
                $system->update($request->all());
                Root::run();
                return redirect()->route('systems.permissions.show', ['id' => $system->id_system])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('systems')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

}
