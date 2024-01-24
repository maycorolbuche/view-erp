<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
use App\Helpers\RootHelper as Root;
use App\Helpers\DataTableHelper;

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
            $profile = Profile::create($request->all());
            Root::run();
            return redirect()->route('profiles.show', ['id' => $profile->id_profile])->with('success', 'Registro cadastrado com sucesso');
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
            $profile = Profile::find($id);
            if ($profile) {
                $profile->update($request->all());
                Root::run();
                return redirect()->route('profiles.show', ['id' => $profile->id_profile])->with('success', 'Registro salvo com sucesso');
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
            $profile = Profile::find($id);
            if ($profile) {
                if ($profile->root == true) {
                    return redirect()->back()->with('error', 'Este perfil não pode ser apagado, pois é o perfil raiz.')->withInput();
                }
                $profile->delete();
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
        return DataTableHelper::profiles(['id_system' => $id_system]);
    }
}
