@extends('admin.dashboard')

@section('title', ' Admin Requested Books')

@section('content')
@php
$requests = session('results')??$requests;
@endphp

<div class="row  mt-3 mb-2 mx-auto ">
  @php
  $requests = session('results')??$requests;
  @endphp
  @if($requests->count() !=0)
    @foreach($requests as $req)
    <div class="card shadow-lg   book_st" >
      <div class=" " style="height:300px;">
        <img class="card-img-top h-100" src="{{asset($req->book->b_photo_path) }}" alt="Book image"  >
      </div>
      <!-- card-body -->
      <div class="card-body h-75" style="height:75%;">
        <div class="h" style="height:60%;  overflow-y:scroll;">

          <h5 class="card-text">Date Requested: {{$req->created_at}}</h5>
          <h5 class="card-text">Status: {{$req->status}}</h5>
          <h5 class="card-text">Reader Email: {{$req->reader->email}}</h5>

        </div>



        <div class="btn-group mt-3 mx-auto ps-2" style="height:20%; ">
          <form class="" action="{{route('admin.approve',$req->book_id)}}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{$req->reader->id}}">
            <button type="submit" class="btn  btn-outline-danger btn-sm ms-3 ">Approve  </button>

          </form>
          <form class="" action="{{route('admin.reject',$req->book_id)}}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{$req->reader->id}}">

            <button type="submit" class="btn  btn-outline-info btn-sm ms-3  ">Reject  </button>

          </form>
        </div>
      </div>
      <!-- end card-body -->
    </div>
    @endforeach

   {{ $requests->links() }}
 @else
 <p class="display-3"> No Books Requested Yet !</p>
</div>
@endif
@endsection
