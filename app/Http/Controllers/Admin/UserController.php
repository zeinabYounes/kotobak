<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\DataTables\ReaderDataTable;
use App\DataTables\LibrarianDataTable;

class UserController extends Controller
{
  use ValidatesRequests;
   protected   $validate = [
    'name' =>  'required|string|max:255',
    'email' =>  'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:8|confirmed',
   ];
   protected $type ;
   protected $datatable ;
   protected $routes ;
   public function __construct()
   {
       // $this->middleware('auth');
       $this->type();
   }
   public function type(){
     if(request()->routeIs('admin.librarians.*')){
       $this->type = " Librarian";
       $this->routes = "librarians";
       $this->datatable = new LibrarianDataTable;
     }

     else{
       $this->type = "Reader";
       $this->datatable = new ReaderDataTable;
       $this->routes = "readers";

     }
   }
   public function index()
   {
     $title = $this->type;
     return $this->datatable->render('admin.index',compact('title'));
   }
   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
       $user = new User;
       if($request->user_id!="" ||$request->user_id!=null){
         $this->update($request);

       }
       $this->validate($request,$this->validate);

       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = Hash::make($request->password) ;
      // $user->role_id = $request->role;
       $user->save();
       $user->addRole($request->role);
       session()->flash('success',$this->type.' added successfully');
       return redirect()->route('admin.'.$this->routes.'.index');
   }

   // /**
   //  * Display the specified resource.
   //  */
   // public function show(SectionShowDataTable $dataTable ,$id)
   // {
   //     $user =  User::findOrFail($id);
   //     $title = $user ->name ."  User";
   //     //return $dataTable->render('admin.shelves.index',compact('title'));
   //
   // }
   /**
    * update the specified resource from storage.
    */

   public function update(Request $request){
     $user = User::findOrFail($request->user_id);
     $validate['name'] ='nullable|string|max:255';
     $this->validate($request,$this->validate);

     $user->name = $request->name;
     $user->save();
     session()->flash('success',$this->type.' updated successfully');
     return redirect()->route('admin.'.$this->routes.'.index');

   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy( $id)
   {
       $user =  User::findOrFail($id);
       $user->removeRole();
       $user->delete();
       session()->flash('success',$this->type.' deleted successfuly');
       return redirect()->route('admin.'.$this->routes.'.index');
   }
}
