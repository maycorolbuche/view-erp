<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Discount;
use App\Models\UserDiscount;
use App\Http\Requests\UserDiscountRequest;

class UserDiscountController extends Controller
{

    public function parent()
    {
        return view('users.discounts.parent');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $pid = $id;
        try {
            $user = User::with('users_discounts')->find($id);
            if ($user) {
                $user->id_discount = $user->users_discounts->pluck('id_discount')->toArray();
                $discounts = Discount::orderBy('name')->get();
                return view('users.discounts.index', compact('pid', 'user', 'discounts'));
            } else {
                return redirect()->route('users-discounts')->with('error', 'Registro não encontrado!');
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
    public function update(UserDiscountRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        try {
            $user = User::find($id);
            if ($user) {
                UserDiscount::where('id_user', $user->id_user)->delete();
                if ($request->id_discount && count($request->id_discount) > 0) {
                    foreach ($request->id_discount as $id_discount) {
                        UserDiscount::create(['id_user' => $user->id_user, 'id_discount' => $id_discount]);
                    }
                }
                return redirect()->route('users-discounts.index', ['pid' => $id])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('users-discounts')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
