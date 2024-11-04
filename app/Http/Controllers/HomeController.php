<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\{BookRequest,BorrowedCopy,ReaderStatus};
use Carbon\Carbon;
use App\Models\{Book,Section,Shelf};
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = Book::paginate(16);
      //  dd(auth()->user()->roles());
        return view('books',compact('books'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = auth()->id();
        $rejected = BookRequest::where('book_id',$id)->where('user_id',$user)->where('status',"rejected")->get();
        $book =  Book::with(['requests' => function ($query) use($user) {
                   $query->where('user_id', '=', $user)->where('status','!=','rejected');
                 }])->findOrFail($id);
                // dd($book->requests->all());
        return view('book-show',compact('book','rejected'));
    }
    /**
     * make requests the specified book.
     */
    public function makeRequest($id)
    {
        $req =  new BookRequest;
        $req->book_id = $id ;
        $req->user_id = auth()->id();
        $req->status = "pending";
        $req->days = 7;
        $req->requested_date = now();
        $req ->save();
        session()->flash('success',' request successfully');
        return redirect()->route('user-books.show',$id);
    }
    /*
    *
    */
    public function requestedBook(){
      $user_id= auth()->id();
      $requests = BookRequest::with('book','reader')
      ->where('user_id',$user_id)
      ->where('status',"pending")->paginate(8);
      return view('requests',compact('requests'));
    }
    /////////////////////////////////////////////////////////////////
    public function borrowed_book(){
      $user_id= auth()->id();
      $borrow = BorrowedCopy::with('book','reader')
      ->where('status',"borrowed")
      ->where('user_id',$user_id)
      ->first();
      $borrow_end =null;
      $until =null;
      if($borrow != null){
        $today = Carbon::now();
        $borrow_day =  Carbon::create($borrow->created_at);
        $allowed_days = $borrow->book->allowed_days;
        $borrow_end = Carbon::parse($borrow_day->addDays($allowed_days))->format('Y-m-d');
        $until = $today->until($borrow_day,$allowed_days);
      }

      $returns = BorrowedCopy::with('book','reader','reader.reader_status')
      ->where('status',"returned")
      ->where('user_id',$user_id)
      ->paginate(5);
      return view('borrowes',compact('borrow','borrow_end','until','returns'));
    }
    //////////////////////////////////////////////////////////
    public function get_shelf($id){
      $books = Book::where('shelf_id',$id)->paginate(16);
      $title = Shelf::findOrFail($id)->sh_name;
      return view('books',compact('books','title'));
    }
    //////////////////////////////////////////////////////////
    public function get_section($id){
      $books = Book::where('section_id',$id)->paginate(16);
      $title = Section::findOrFail($id)->s_name;
      return view('books',compact('books','title'));
    }
    //////////////////////////////////////////////////
    public function search(Request $request){
      $search = $request->search;
      if ($request->routeIs('admin.requested_books')) {

        $results = BookRequest::with('book','reader')
        ->where('status',"pending")
        ->whereHas('book', function (Builder $query) {
              $query->where('title', 'like', '%'.$search."%")->orWhere('auther', 'like', '%'.$search."%");
          })
        ->paginate(5);;

      }
      elseif ($request->routeIs('admin.borrowed_books')) {
        $results = BorrowedCopy::with('book','reader')
        ->where('status',"borrowed")
        ->whereHas('book', function (Builder $query) {
              $query->where('title', 'like', '%'.$search."%")->orWhere('auther', 'like', '%'.$search."%");
          })
        ->paginate(5);
      }
      elseif ($request->routeIs('admin.approved_books')) {
        $results = BookRequest::with('book','reader')
        ->where('status',"approved")
        ->whereHas('book', function (Builder $query) {
              $query->where('title', 'like', '%'.$search."%")->orWhere('auther', 'like', '%'.$search."%");
          })
        ->paginate(5);;

      }
      else{
        $results = Book::where('title', 'like', '%'.$search."%")->orWhere('auther', 'like', '%'.$search."%")->paginate(5);
      }
      //$route = Route::current();
      // return redirect()->route($route)->with('results',$results);;
    return back()->with('results',$results);


    }


}
