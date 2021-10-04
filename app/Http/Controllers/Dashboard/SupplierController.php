<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SupplierRequest;
use App\Imports\SupplierImport;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    // public function index(){
    //     return view('dashboard.supplier.list');
    // }

    private $supplierModel;

    /**
     * SupplierController constructor.
     * @param Supplier $supplier
     */
    public function __construct(Supplier $supplier)
    {
        $this->supplierModel = $supplier;
    }

    public function index(Request $request){
        $data = Supplier::get();
        if($request->ajax()){
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.route('admin.suppliers.edit', $data->id).'" type="button" name="edit" id="'.$data->id.'"
                            class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Sửa</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit"
                            class="delete btn btn-danger btn-sm" id="'.$data->id.'" data="'.$data->id.'"><i class="fa fa-trash"> Xóa</button>';
                    return $button;
                })
                ->make(true);
        }
        return view('dashboard.supplier.list');
    }

    public function anyData(){
        return DataTables::of(Supplier::query())->make(true);
    }

    public function create(){
        return view('dashboard.supplier.create');
    }

    public function store(SupplierRequest $request){
        $data=$request->except('_token');
        $data=array_filter($data,'strlen');
        $supplier = Supplier::create($data);
        if($supplier){
            return redirect(route('admin.suppliers.index'))
                ->with('success', __('Create supplier is success!'));
        }
        return 'error!';
    }

    public function edit($id)
    {
        $supplier = $this->supplierModel->find($id);

        if ($supplier)
        {
            return view('dashboard.supplier.edit', compact('supplier'));
        }

        abort(404);
    }

    public function update(SupplierRequest $request, $id)
    {
        $supplier = $this->supplierModel->find($id);
        if ($supplier)
        {
            $supplier->name = $request->input('name');
            $supplier->address = $request->input('address');
            $supplier->phone = $request->input('phone');
            $supplier->email = $request->input('email');
            $supplier->save();
        }
        return redirect(route('admin.suppliers.index'))
            ->with('update success', __('Update supplier\'s success!'));
    }

    public function destroy($id){
        $data = Supplier::findOrFail($id);
        $data->delete();
    }

    public function importForm()
    {
        return view('dashboard.supplier.import-form');
    }

    public function import(Request $request)
    {
        Excel::import(new SupplierImport, $request->file);
        return redirect(route('admin.suppliers.index'))
            ->with('update success', __('Import supplier\'s success!'));
    }
}
