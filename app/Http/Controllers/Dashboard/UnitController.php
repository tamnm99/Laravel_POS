<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Unit;

use App\Http\Requests\Dashboard\UnitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $data = Unit::latest()->get();
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a href="'.route('admin.units.edit', $data->id).'" type="button" name="edit" id="'.$data->id.'"
                            class="edit btn btn-primary btn-sm">Edit</a>';
                $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit"
                            class="delete btn btn-danger btn-sm" id="'.$data->id.'" data="'.$data->id.'">Delete</button>';
               
                return $button;
            })
            
            ->make(true);
        }
        
        return view('dashboard.units.index');
    }
    
    public function anyData(){
        return Datatables::of(Unit::query())->make(true);
        
    }
    
    public function create(){
        $unit = new Unit();
        return view('dashboard.units.create')->with(compact('unit'));
    }
    
    public function store(UnitRequest $request)
    {
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        $unit = Unit::create($data);
        
        if ($unit)
        {
            return redirect(route('admin.units.index'))
            ->with('success', __('Create units\'s success!'));
        }
        return 'error!';
        
    }
    
    public function edit($id){
        $unit = Unit::find($id);
        if ($unit)
        {
            return view('dashboard.units.edit', compact('unit'));
        }
        
        abort(404);
        
    }
    public function update(UnitRequest $request, $id){
      
            $unit = Unit::find($id);
            if($unit){
                $unit->unit_code = $request ->input('unit_code');
                $unit->unit_name = $request ->input('unit_name');
                $unit->save();
                
            }
            return redirect(route('admin.units.index'))
            ->with('success', __('Update Unit\'s success!'));
        }
  
    public function destroy($id){ 
        $data= Unit::findOrFail($id);
        $data->delete();
     }
     
    
}
