@extends('admin.dashboard')

@section('title', 'Requested Books')

@section('content')
<div class="row  mt-3 mb-2 mx-auto ">
  @foreach($requests as $req)
   <div class="card shadow-lg book_st">
      <div class=" " style="height:300px;">
      <img class="card-img-top h-100" src="{{asset($req->book->b_photo_path) }}" alt="Book image"  >
    </div>    <!-- card-body -->
    <div class="card-body h-50 mb-2">
      <div class="h-75" style="height:60%;  overflow-y:scroll;">
        <h5 class="card-text">Date Requested: {{$req->created_at}}</h5>
        <h5 class="card-text">Date Response: {{$req->updated_at}}</h5>
        <h5 class="card-text">Status: {{$req->status}}</h5>
      </div>

      <div class=" d-grid h-25 " >
        <a href="#" class="btn btn-sm  btn-outline-warning btn-block rounded-pill disabled">{{$req->status}}</a>
      </div>


    </div>
    <!-- end card-body -->
  </div>
  @endforeach
{{ $requests->links() }}

</div>
@endsection
