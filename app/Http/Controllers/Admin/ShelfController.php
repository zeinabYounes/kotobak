<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shelf;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\{ShelvesDataTable,ShelfShowDataTable};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     use ValidatesRequests;
      protected   $validate = [
       'sh_name' =>  'required|string|max:100|unique:shelves',
       'section_id' =>  'required'


      ];
     public function index(ShelvesDataTable $dataTable)
     {
        $title = "Shelves";
        return $dataTable->render('admin.index',compact('title'));
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $shelf = new Shelf;
      if($request->shelf_id!=""){
        $this->validate['sh_name'] ='required|string|max:100';

        $shelf = Shelf::findOrFail($request->shelf_id);
        $samename = Shelf::where('s_name',$request->sh_name)->count();
        if($samename > 0 && $shelf->sh_name != $request->sh_name){
          $this->validate['sh_name'] =  'required|string|max:100|unique:shelves';
        }

      }
      $this->validate($request,$this->validate);

      $shelf->sh_name = $request->sh_name;
      $shelf->section_id = $request->section_id;

      $shelf->save();
      session()->flash('success','Shelf added successfully');
      return redirect()->route('admin.shelves.index');

    }
    /**
     * Display the specified resource.
     */
    public function show(ShelfShowDataTable $dataTable ,$id)
    {
        $shelf =  Shelf::findOrFail($id);
        $title = $shelf ->sh_name ."  Shelf";
        return $dataTable->render('admin.index',compact('title'));

    }







    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
      $shelf =  Shelf::findOrFail($id)->delete();
      session()->flash('success','Shelf deleted successfuly');
      return redirect()->route('admin.shelves.index');
    }
}
