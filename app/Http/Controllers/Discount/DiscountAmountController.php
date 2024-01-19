<?php

namespace App\Http\Controllers\Discount;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\DiscountAmount;
use App\Http\Requests\DiscountAmountRequest;
use App\Helpers\DataTableHelper;

class DiscountAmountController extends Controller
{
    public function parent()
    {
        return view('discounts.amounts.parent');
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
            $discount = Discount::find($id);
            if ($discount) {
                return view('discounts.amounts.index', compact('pid', 'discount'));
            } else {
                return redirect()->route('discounts-amounts')->with('error', 'Registro não encontrado!');
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
    public function store(DiscountAmountRequest $request, $pid)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        $request->merge(['id_discount' => $pid]);

        try {
            $discount = Discount::find($pid);
            if (!$discount) {
                return redirect()->route('discounts')->with('error', 'Registro não encontrado!');
            }

            $discount_amount = DiscountAmount::create($request->all());
            return redirect()->route('discounts-amounts.show', ['pid' => $pid, 'id' => $discount_amount->id_discount_amount])->with('success', 'Registro cadastrado com sucesso');
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
        $discount = Discount::find($pid);
        if ($discount) {
            $data = DiscountAmount::find($id);
            if ($data) {
                return view('discounts.amounts.index', compact('pid', 'data', 'discount'));
            } else {
                return redirect()->route('discounts')->with('error', 'Registro não encontrado!');
            }
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
    public function update(DiscountAmountRequest $request, $pid, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        $request->merge(['id_discount' => $pid]);

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new DiscountAmountRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest, $pid);
        }

        try {
            $discount = Discount::find($pid);
            if ($discount) {
                $discount_amount = DiscountAmount::find($id);
                if ($discount_amount) {
                    $discount_amount->update($request->all());
                    return redirect()->route('discounts-amounts.show', compact('pid', 'id'))->with('success', 'Registro salvo com sucesso');
                } else {
                    return redirect()->route('discounts-amounts')->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('discounts-amounts')->with('error', 'Registro não encontrado!');
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
            $discount = Discount::find($pid);
            if ($discount) {
                $discount_amount = DiscountAmount::find($id);
                if ($discount_amount) {
                    $discount_amount->delete();
                    return redirect()->route('discounts-amounts.index', compact('pid'))->with('success', 'Registro apagado com sucesso');
                } else {
                    return redirect()->route('discounts-amounts.index', compact('pid'))->with('error', 'Registro não encontrado!');
                }
            } else {
                return redirect()->route('discounts-amounts.index', compact('pid'))->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable()
    {
        return DataTableHelper::discounts_amounts();
    }
}
