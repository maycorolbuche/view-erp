<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPhone;
use App\Models\Carrier;
use App\Models\PhoneType;
use App\Http\Requests\UserPhoneRequest;
use DataTables;

class UserPhoneController extends Controller
{
    public function parent()
    {
        return view('users.phones.parent');
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
            $user = User::find($id);
            if ($user) {
                $carriers = Carrier::orderBy('name')->get();
                $phones_types = PhoneType::orderBy('description')->get();
                return view('users.phones.index', compact('pid', 'user', 'carriers', 'phones_types'));
            } else {
                return redirect()->route('users-phones')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserPhoneRequest $request, $pid)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        $request->merge(['id_user' => $pid]);

        try {
            $user = User::find($pid);
            if (!$user) {
                return redirect()->route('users')->with('error', 'Registro não encontrado!');
            }

            $user_phone = UserPhone::create($request->all());
            return redirect()->route('users-phones.show', ['pid' => $pid, 'id' => $user_phone->id_user_phone])->with('success', 'Registro cadastrado com sucesso');
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
    public function show($pid, $id)
    {
        $user = User::find($pid);
        if ($user) {
            $data = UserPhone::find($id);
            if ($data) {
                $carriers = Carrier::orderBy('name')->get();
                $phones_types = PhoneType::orderBy('description')->get();
                return view('users.phones.index', compact('pid', 'data', 'user', 'carriers', 'phones_types'));
            } else {
                return redirect()->route('users')->with('error', 'Registro não encontrado!');
            }
        } else {
            return redirect()->route('users')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserPhoneRequest $request, $pid, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        $request->merge(['id_user' => $pid]);

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new UserPhoneRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest, $pid);
        }

        try {
            $user = User::find($pid);
            if ($user) {
                $user_phone = UserPhone::find($id);
                if ($user_phone) {
                    $user_phone->update($request->all());
                    return redirect()->route('users-phones.show', compact('pid', 'id'))->with('success', 'Registro salvo com sucesso');
                } else {
                    return redirect()->route('users-phones')->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-phones')->with('error', 'Registro não encontrado!');
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
    public function destroy($pid, $id)
    {
        if (!in_array('destroy', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para excluir nessa página!')->withInput();
        }

        try {
            $user = User::find($pid);
            if ($user) {
                $user_phone = UserPhone::find($id);
                if ($user_phone) {
                    $user_phone->delete();
                    return redirect()->route('users-phones.index', compact('pid'))->with('success', 'Registro apagado com sucesso');
                } else {
                    return redirect()->route('users-phones.index', compact('pid'))->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('users-phones.index', compact('pid'))->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $data = UserPhone::latest()->where('id_user', request('pid'))->with(['carrier', 'phone_type'])->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $edit_route = route('users-phones.show', ['pid' => request('pid'), 'id' => $row->id_user_phone]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('carrier', function ($row) {
                return $row->carrier->name ?? '';
            })
            ->addColumn('phone_type', function ($row) {
                return $row->phone_type->description ?? '';
            })
            ->addColumn('phone', function ($row) {
                return $row->phone
                    . ($row->has_whatsapp ? " <span class='fab fa-whatsapp text-success'></span>" : "")
                    . ($row->is_business ? " <span class='fas fa-building text-info'></span>" : "")
                    ?? '';
            })
            ->rawColumns(['actions', 'phone'])
            ->make(true);
    }
}
