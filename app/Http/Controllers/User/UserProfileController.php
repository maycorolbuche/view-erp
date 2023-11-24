<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\UserProfile;
use App\Models\UserSystem;
use Illuminate\Http\Request;
use App\Helpers\RootHelper as Root;

class UserProfileController extends Controller
{
    public function parent()
    {
        return view('users.profiles.parent');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $pid = $id;
        $id_system = request('__id_system');

        try {
            $user = User::find($id);
            if ($user) {
                $profiles = Profile::where('id_system', $id_system)->orderBy('name')->get();
                $users_profiles = UserProfile::where('id_user', $id)->get()->keyBy('id_profile');
                $has_access = UserSystem::where('id_system', $id_system)->where('id_user', $id)->exists();

                return view('users.profiles.index', compact('pid', 'user', 'profiles', 'users_profiles', 'has_access'));
            } else {
                return redirect()->route('users-profiles')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        try {
            $user = User::find($id);
            if ($user) {

                if ($user->root) {
                    return redirect()->back()->with('error', 'Não é possível alterar os perfis do usuário raiz!');
                } else {
                    UserProfile::where('id_user', $id)->delete();
                    if (isset($request->profile)) {
                        foreach (array_keys($request->profile) as $id_profile) {
                            UserProfile::create(['id_user' => $id, 'id_profile' => $id_profile]);
                        }
                    }
                }
                Root::run();
                return redirect()->route('users-profiles.index', ['pid' => $id])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('users-profiles')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
