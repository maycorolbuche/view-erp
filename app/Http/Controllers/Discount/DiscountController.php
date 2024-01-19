<?php

namespace App\Http\Controllers\Discount;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\DiscountCategory;
use App\Models\Category;
use App\Http\Requests\DiscountRequest;
use App\Helpers\DataTableHelper;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name')->with('category_type')
            ->whereHas('category_type', function ($query) {
                $query->where('categories_types.slug', 'expense');
            })->get();
        return view('discounts.index', compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        try {
            $discount = Discount::create($request->all());
            $this->discountCategory($discount->id_discount, $request->id_category ?? []);

            return redirect()->route('discounts.show', ['id' => $discount->id_discount])->with('success', 'Registro cadastrado com sucesso');
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
        $data = Discount::with('discounts_categories')->find($id);
        if ($data) {
            $data->id_category = $data->discounts_categories->pluck('id_category')->toArray();

            $categories = Category::orderBy('name')->with('category_type')
                ->whereHas('category_type', function ($query) {
                    $query->where('categories_types.slug', 'expense');
                })->get();

            return view('discounts.index', compact("data", "categories"));
        } else {
            return redirect()->route('discounts')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new DiscountRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $discount = Discount::find($id);
            if ($discount) {
                $discount->update($request->all());
                $this->discountCategory($discount->id_discount, $request->id_category ?? []);

                return redirect()->route('discounts.show', ['id' => $discount->id_discount])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('discounts')->with('error', 'Registro não encontrado!');
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
            $discount = Discount::find($id);
            if ($discount) {
                $discount->delete();
                return redirect()->route('discounts')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('discounts')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        return DataTableHelper::discounts();
    }

    public function discountCategory($id_discount, $categories)
    {
        DiscountCategory::where('id_discount', $id_discount)->delete();
        if ($categories && count($categories) > 0) {
            foreach ($categories as $id_category) {
                DiscountCategory::create(['id_discount' => $id_discount, 'id_category' => $id_category]);
            }
        }
    }
}
