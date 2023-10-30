<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
use App\Helpers\Root;
use DataTables;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profiles.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        unset($request["root"]);
        $request->merge(['id_system' => request('__id_system')]);

        try {
            $system = Profile::create($request->all());
            Root::run();
            return redirect()->route('profiles.show', ['id' => $system->id_profile])->with('success', 'Registro cadastrado com sucesso');
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
        $data = Profile::find($id);
        if ($data) {
            return view('profiles.index', compact("data"));
        } else {
            return redirect()->route('profiles')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        unset($request["root"]);

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new ProfileRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $system = Profile::find($id);
            if ($system) {
                $system->update($request->all());
                Root::run();
                return redirect()->route('profiles.show', ['id' => $system->id_profile])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('profiles')->with('error', 'Registro não encontrado!');
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
            $system = Profile::find($id);
            if ($system) {
                if ($system->root == true) {
                    return redirect()->back()->with('error', 'Este perfil não pode ser apagado, pois é o perfil raiz.')->withInput();
                }
                $system->delete();
                return redirect()->route('profiles')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('profiles')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $id_system = request('__id_system');
        $data = Profile::where('id_system', $id_system)->latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'profiles.show', [$id_field => $row->id_profile]);
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
