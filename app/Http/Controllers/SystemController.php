<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Http\Requests\SystemRequest;
use App\Helpers\Root;
use DataTables;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('systems.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SystemRequest $request)
    {
        unset($request["root"]);

        try {
            $system = System::create($request->all());
            Root::run();
            return redirect()->route('systems.show', ['id' => $system->id_system])->with('success', 'Registro cadastrado com sucesso');
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
        $data = System::find($id);
        if ($data) {
            return view('systems.index', compact("data"));
        } else {
            return redirect()->route('systems')->with('error', 'Registro não encontrado!');
        }
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
        unset($request["root"]);

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
                return redirect()->route('systems.show', ['id' => $system->id_system])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('systems')->with('error', 'Registro não encontrado!');
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
        try {
            $system = System::find($id);
            if ($system) {
                if ($system->root == true) {
                    return redirect()->back()->with('error', 'Este sistema não pode ser apagado, pois é o sistema raiz.')->withInput();
                }
                $system->delete();
                return redirect()->route('systems')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('systems')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {

        $data = System::latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('systems.show', ['id' => $row->id_system]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('icon', function ($row) {
                return "<i style='font-size:20px' class='" . $row->icon . "'></i>";
            })
            ->rawColumns(['actions', 'icon'])
            ->make(true);
    }
}
