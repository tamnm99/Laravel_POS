<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaxRequest;
use App\Models\Admin\Tax;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaxController extends Controller
{
    private $taxModel;

    public function __construct(Tax $tax)
    {
        $this->taxModel = $tax;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tax::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('admin.taxes.edit',
                            $data->id) . '" type="button" name="edit" id="' . $data->id . '"
                            class="edit btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit"
                            class="delete btn btn-danger btn-sm" id="' . $data->id . '" data="' . $data->id . '">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.admin.taxes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tax = new Tax();
        return view('dashboard.admin.taxes.create', compact('tax'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaxRequest $request)
    {
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        $tax = Tax::create($data);
        if ($request->ajax()) {
            return ['success' => 'done'];
        }
        if ($tax) {
            return redirect(route('admin.taxes.index'))
                ->with('success', __('Crete tax\'s successful!'));
        }
        return 'error!';
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax = $this->taxModel->find($id);
        if ($tax) {
            return view('dashboard\admin\taxes\edit', compact('tax'));
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaxRequest $request, $id)
    {
        $tax = $this->taxModel->find($id);
        if ($tax) {
            $tax->name = $request->input('name');
            $tax->rate = $request->input('rate');
            $tax->save();
        }
        return redirect(route('admin.taxes.index'))
            ->with('success', __('Update tax\'s successful!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tax = $this->taxModel->find($id);
        if ($tax) {
            $tax->delete();
            return redirect(route('admin.taxes.index'))
                ->with('success', __('Delete tax\'s successful!'));
        }
        return redirect(route('admin.taxes.index'))
            ->with('success', __('tax not found!'));
    }
}
