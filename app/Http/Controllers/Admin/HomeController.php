<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{BookRequest,BorrowedCopy,ReaderStatus,Book,User};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
class HomeController extends Controller
{
    /*
    * get all counts data dashboard
    */
    public function  index(){
      $books_counts = Book::count();
      $borrowed_books = BorrowedCopy::where('status','borrowed')->count();
      $requested_books = BookRequest::where('status','pending')->count();
      $readers = User::whereHas('roles', function (Builder $query) {
        $query->where('name', '=', 'reader');
      })->count();
      //dd($books_counts);
      return  view('admin.home',compact('books_counts','borrowed_books','requested_books','readers'));
    }
    /*
    * get all requests books made by readers
    */

    public function requested_books(){
      $requests = BookRequest::with('book','reader')->where('status',"pending")->paginate(5);;
      return view('admin.requested',compact('requests'));
    }
    /////////////////////////////////////////////////////////////////
    public function approveRequest(Request $req ,$id){

      $user_id = $req->user_id;
    //  dd($user_id);
      $book_req = BookRequest::where('book_id',$id)
      ->where('user_id',$user_id)
      ->where('status',"pending")->first();
      $check_other = BookRequest::where('user_id',$user_id)
      ->where('status',"approved")->get();
      $check_user = BorrowedCopy::where('user_id',$user_id)
      ->where('status',"borrowed")->get();
      $check_last_return = BorrowedCopy::where('user_id',$user_id)
      ->where('status',"returned")->get()->last();

      if($check_other->count()!=0 || $check_user->count()!=0){
        $book_req->status = "rejected";
        session()->flash('fail','rejected because you with borrow other or have borrowed yet');
      }
      elseif($check_last_return != null &&($check_last_return->status =="bad" || $check_last_return->status =="unsafe" )){
        $book_req->status = "rejected";
        session()->flash('fail','rejected because last return was late');
      }

      else{
        $book_req->status = "approved";
        $book_req->save();
        session()->flash('success','Approved successfully');
        return redirect()->route('admin.requested_books');
      }
      $book_req->save();

      return redirect()->route('admin.requested_books');
    }
    ////////////////////////////////////////////////////////////////
    public function rejectRequest($id){
      $user_id = $req->user_id;
      $book_req = BookRequest::where('book_id',$id)
      ->where('user_id',$user_id)->where('status',"pending")->first();
      $book_req->status = "rejected";
      $book_req->save();
      session()->flash('success','Rejected successfully');
      return redirect()->route('admin.requested_books');
    }
    /////////////////////////////////////////////////////////////////
    public function borrowed_books(){
      $borroweds = BorrowedCopy::with('book','reader')
      ->where('status',"borrowed")->paginate(5);
      return view('admin.borrowed',compact('borroweds'));
    }
    /////////////////////////////////////////////////////////////////
    public function borrowRequest(Request $req ,$id){
      $user_id = $req->user_id;
      $book_req = BookRequest::where('book_id',$id)
      ->where('user_id',$user_id)
      ->where('status',"approved")->first();
      $book_req->delete();
      $borrow_req = new BorrowedCopy;
      $borrow_req->book_id = $id ;
      $borrow_req->user_id = $user_id ;
      $borrow_req->status = "borrowed" ;
      $borrow_req->save();
      session()->flash('success','Approved successfully');
      return redirect()->route('admin.requested_books');
    }
    ////////////////////////////////////////////////////////////////////////////
    public function approved_books(){
      $approves = BookRequest::with('book','reader')
      ->where('status',"approved")->paginate(5);
      return view('admin.approved',compact('approves'));
    }
    ///////////////////////////////////////////////////////////////////////////
    public function returnRequest(Request $req ,$id){
      $user_id = $req->user_id;
      $borrow_req = BorrowedCopy::where('book_id',$id)
      ->where('user_id',$user_id)
      ->where('status',"borrowed")->first();
      if($borrow_req != null){
        $allowed_days = Book::findOrFail($id)->allowed_days;
        $borrow_req->status = "returned";
        $borrow_req->save();
        $today = Carbon::now();
        $borrow_day =  Carbon::create($borrow_req->created_at);
        $return_date =  Carbon::create($borrow_req->updated_at);
        $borrow_end = $borrow_day->addDays($allowed_days);
        $return_after_week = $borrow_end->addDays(7);
        $reader_status = new ReaderStatus;
        $reader_status->user_id = $user_id;

        if($borrow_end >= $return_date){
          $reader_status->status ="good";
          $reader_status->description ="reader return book in time";
        }
        elseif($borrow_end < $return_date && $return_date <= $return_after_week){
          $reader_status->status ="bad";
          $reader_status->description ="reader return book after time by week or less";
        }
        else{
          $reader_status->status ="unsafe";
          $reader_status->description ="reader return book after time more than week ";
        }
        $reader_status->save();
       }
      session()->flash('success','Returned successfully');
      return redirect()->route('admin.requested_books');
    }

}
