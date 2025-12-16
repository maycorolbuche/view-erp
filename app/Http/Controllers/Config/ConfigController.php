<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigRequest;
use App\Helpers\ConfigHelper as Configs;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configs = Configs::all();
        return view('configs.index', compact('configs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigRequest $request)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        $inputs = $request->only(
            'authorizationsActiveDays_to_close',
            'batchesActiveDays_to_close_without_refund',
            'batchesStandard_payment_days',
            'authorizationsCash_advanceAgreement_terms',
        );

        try {
            foreach ($inputs as $key => $value) {
                $key = preg_replace('/([A-Z])/', '.$1', $key);
                $key = strtolower($key);
                Configs::set($key, $value);
            }
            return redirect()->route('configs')->with('success', 'Configurações salvas com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
