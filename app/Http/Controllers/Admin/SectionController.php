<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\SectionsDataTable;
use App\DataTables\SectionShowDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     use ValidatesRequests;
      protected   $validate = [
       's_name' =>  'required|string|max:100|unique:sections'
      ];
    public function index(SectionsDataTable $dataTable)
    {
       $title = " Section";
       return $dataTable->render('admin.index',compact('title'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $section = new Section;
        if($request->section_id!=""){
          $section = Section::findOrFail($request->section_id);
          $this->validate['s_name'] ='required|string|max:100';
          $samename = Section::where('s_name',$request->s_name)->count();
          if($samename > 0 && $section->s_name != $request->s_name){
            $this->validate['s_name'] =  'required|string|max:100|unique:sections';
          }

        }
        $this->validate($request,$this->validate);

        $section->s_name = $request->s_name;
        $section->save();
        session()->flash('success','Section added successfully');
        return redirect()->route('admin.sections.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SectionShowDataTable $dataTable ,$id)
    {
        $section =  Section::findOrFail($id);
        $title = $section ->s_name ."  Section";
        return $dataTable->render('admin.index',compact('title'));

    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy( $id)
    {
        $section =  Section::findOrFail($id)->delete();
        session()->flash('success','Section deleted successfuly');
        return redirect()->route('admin.sections.index');
    }
}
