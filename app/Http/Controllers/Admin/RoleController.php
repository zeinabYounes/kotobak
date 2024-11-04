<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     use ValidatesRequests;
      protected   $validate = [
       'name' =>  'required|string|max:100|unique:roles',
       'display_name' =>  'required|string|max:100',
       'description' => 'nullable|string|max:1000',
       'permissions'=>'required|array',
       'permissions.*'=>'integer|exists:permissions,id',

      ];
    public function index(RoleDataTable $dataTable)
    {
      $title = " Role";
      return $dataTable->render('admin.index',compact('title'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $role = new Role;
      if($request->role_id!=""){
        $role = Role::findOrFail($request->role_id);
        $this->validate['name'] =  'required|string|max:100';
        if($role->name =="admin" || $role->name =="librarian" || $role->name == "reader"){
          $this->validate($request,$this->validate);
          $role->syncPermissions($request->permissions);
          session()->flash('success','Role added successfully');
          return redirect()->route('admin.roles.index');
        }
        else{
              $samename = Role::where('name',$request->name)->count();
              if($samename > 0 && $role->name != $request->name){
                $this->validate['name'] =  'required|string|max:100|unique:roles';
              }
        }
      }
      $this->validate($request,$this->validate);

      $role->name = $request->name;
      $role->display_name = $request->display_name;
      $role->description = $request->description;

      $role->save();
      $role->syncPermissions($request->permissions);
      session()->flash('success','Role added successfully');
      return redirect()->route('admin.roles.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      $role = Role::findOrFail($id);
      if($role->name =="admin" || $role->name =="librarian" || $role->name == "reader"){
        session()->flash('fail','Not Allow To Delete This Role');
        return redirect()->route('admin.roles.index');
      }
      $role->removePermissions();
      $role->delete();
      session()->flash('success','Role deleted successfuly');
      return redirect()->route('admin.roles.index');
    }
}
