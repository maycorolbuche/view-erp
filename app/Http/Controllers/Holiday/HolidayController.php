<?php

namespace App\Http\Controllers\Holiday;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use App\Models\HolidayBranch;
use App\Models\Branch;
use App\Http\Requests\HolidayRequest;
use DataTables;

class HolidayController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::orderBy('name')->get();
        return view('holidays.index', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidayRequest $request)
    {
        if (!in_array('store', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para cadastrar nessa página!')->withInput();
        }

        try {
            $holiday = Holiday::create($request->all());
            $this->holidaysBranches($holiday->id_holiday, $request->id_branch ?? []);

            return redirect()->route('holidays.show', ['id' => $holiday->id_holiday])->with('success', 'Registro cadastrado com sucesso');
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
        $data = Holiday::with('holidays_branches')->find($id);
        if ($data) {
            $branches = Branch::orderBy('name')->get();

            return view('holidays.index', compact('data', 'branches'));
        } else {
            return redirect()->route('holidays')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HolidayRequest $request, $id)
    {
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        if ($request->_action == "store") {
            $id = null;
            $storeRequest = new HolidayRequest();
            $request->validate($storeRequest->rules());
            $storeRequest->merge($request->all());
            return $this->store($storeRequest);
        }
        try {
            $holiday = Holiday::find($id);
            if ($holiday) {
                $holiday->update($request->all());
                $this->holidaysBranches($holiday->id_holiday, $request->id_branch ?? []);
                return redirect()->route('holidays.show', ['id' => $holiday->id_holiday])->with('success', 'Registro salvo com sucesso');
            } else {
                return redirect()->route('holidays')->with('error', 'Registro não encontrado!');
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
            $holiday = Holiday::find($id);
            if ($holiday) {
                $holiday->delete();
                return redirect()->route('holidays')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('holidays')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $data = Holiday::latest()->with('branches')->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'holidays.show', [$id_field => $row->id_holiday]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('date', function ($row) {
                $date = strtotime(($row->year ?? date("Y")) . "-" . $row->month . "-" . $row->day);

                if ($row->easter || $row->easter == "0") {
                    $easterTimestamp = easter_date();
                    $date = $easterTimestamp + ($row->easter * 24 * 60 * 60);
                    return '<span style="display:none">' . $date . '</span>' . "<span class='text-warning'>" . date("d/m/Y", $date) . "</span>";
                } elseif ($row->year) {
                    return '<span style="display:none">' . $date . '</span>' . date("d/m/Y", $date);
                } else {
                    return '<span style="display:none">' . $date . '</span>' . date("d/m/", $date) .  "<span class='text-warning'>" . date("Y", $date) . "</span>";
                }
            })
            ->addColumn('type', function ($row) {
                $type = $row->easter !== null ? "easter" : ($row->year == null ? "repeat" : "unique");
                $items = [
                    'unique' => ['Único', 'info'],
                    'repeat' => ['Recorrente', 'success'],
                    'easter' => ['Dinâmico', 'warning']
                ];

                return "<span class='badge badge-" . $items[$type][1] . "'>" . $items[$type][0] . "<span>";
            })
            ->addColumn('branches', function ($row) {
                $branches = '';
                foreach ($row->branches as $branch) {
                    $branches .= "<span class='badge badge-info'>" . $branch->short_name . "</span> ";
                }
                return $branches;
            })
            ->rawColumns(['actions', 'date', 'type', 'branches'])
            ->make(true);
    }


    public function holidaysBranches($id_holiday, $branches)
    {
        HolidayBranch::where('id_holiday', $id_holiday)->delete();
        if ($branches && count($branches) > 0) {
            foreach (array_keys($branches) as $id_branch) {
                HolidayBranch::create(['id_holiday' => $id_holiday, 'id_branch' => $id_branch]);
            }
        }
    }
}
