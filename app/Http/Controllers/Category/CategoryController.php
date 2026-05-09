<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\CategoryType;
use App\Models\CategoryUser;
use App\Http\Requests\CategoryRequest;
use App\Helpers\DataTableHelper;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories_types = CategoryType::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('categories.index', compact('categories_types', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        try {
            $category = Category::create($request->all());
            if ($request->filled('users') && is_array($request->users)) {
                foreach ($request->users as $idUser) {
                    CategoryUser::create([
                        'id_category' => $category->id_category,
                        'id_user'     => $idUser,
                        'created_by'  => auth()->user()->id_user ?? null,
                        'updated_by'  => auth()->user()->id_user ?? null,
                    ]);
                }
            }
            return redirect()->route('categories.show', ['id' => $category->id_category])->with('success', 'Registro cadastrado com sucesso');
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
        $data = Category::find($id);
        $users = User::orderBy('name')->get();
        if ($data) {
            $categories_types = CategoryType::orderBy('name')->get();
            $data->users = $data->users()->pluck('id_user')->toArray();
            return view('categories.index', compact('data', 'categories_types', 'users'));
        } else {
            return redirect()->route('categories')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new CategoryRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $category = Category::find($id);
            if ($category) {

                $category->update($request->all());

                CategoryUser::where('id_category', $category->id_category)->delete();
                if ($request->filled('users') && is_array($request->users)) {
                    foreach ($request->users as $idUser) {
                        CategoryUser::create([
                            'id_category' => $category->id_category,
                            'id_user'     => $idUser,
                            'created_by'  => auth()->user()->id_user ?? null,
                            'updated_by'  => auth()->user()->id_user ?? null,
                        ]);
                    }
                }

                return redirect()->route('categories.show', ['id' => $category->id_category])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('categories')->with('error', 'Registro não encontrado!');
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
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                return redirect()->route('categories')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('categories')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        return DataTableHelper::categories();
    }
}
