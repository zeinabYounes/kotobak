<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\DataTables\{BooksDataTable,CopyDataTable};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use File;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     use ValidatesRequests;
      protected   $validate = [
       'title' =>  'required|string|max:250',
       'auther'=>  'required|string|max:250',
       'b_photo_path'=>  'required|image|max:3000',
       'edition'=>  'nullable|string|max:100',
       'genre'=>  'nullable|string|max:100',
       'ISBN'=>  'required|string',
       'published_year'=>  'nullable|numeric|min:1|max:2100',
       'copies_all'=>  'numeric|min:1',
       'allowed_days'=>  'numeric|min:1|max:30',
       'section'=>  'required',
       'shelf'=>  'required'



      ];
    public function index(BooksDataTable $dataTable)
    {
      $title="Books";
      return $dataTable->render('admin.index',compact('title'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $book = new Book;
      if($request->book!=""){
        $this->validate['b_photo_path']=  'nullable|image|max:3000';

        $book = Book::findOrFail($request->book);
      }
      $this->validate($request,$this->validate);

      if($request->hasFile('b_photo_path')){
          $destinationPath = public_path('books/images');
          $extension = $request->file('b_photo_path')->getClientOriginalExtension();
          $fileName = "books/images/".uniqid().'_book'.$extension;
          $request->file('b_photo_path')->move($destinationPath, $fileName);
          $book->b_photo_path=$fileName;
        }
      $book->title = $request->title ;
      $book->auther = $request->auther ;
      $book->edition = $request->edition ;
      $book->genre = $request->genre ;
      $book->ISBN = $request->ISBN ;
      $book->published_year = $request->published_year ;
      $book->copies_all = $request->copies_all ;
      $book->allowed_days = $request->allowed_days ;

      $book->section_id = $request->section ;
      $book->shelf_id = $request->shelf;
      $book->save();
      session()->flash('success','Book added successfully');
      return redirect()->route('admin.books.index');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
      $book = Book::findOrFail($id)->delete();
      session()->flash('success','Role deleted successfuly');
      return redirect()->route('admin.roles.index');

    }
}
