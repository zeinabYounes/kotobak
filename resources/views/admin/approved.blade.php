@extends('admin.dashboard')

@section('title', ' Admin Approved Books')

@section('content')
<div class="row  mt-3 mb-2 mx-auto ">
  @php
  $approves = session('results')??$approves;
  @endphp
  @if($approves->count() !=0)
    @foreach($approves as $approve)
    <div class="card shadow-lg book_st">
      <div class=" " style="height:300px;">
        <img class="card-img-top h-100" src="{{asset($approve->book->b_photo_path) }}" alt="Book image"  >
      </div>
      <!-- card-body -->
      <div class="card-body h-75" style="height:75%;">
        <div class="h" style="height:60%;  overflow-y:scroll;">

          <h5 class="card-text">Date Requested: {{$approve->created_at}}</h5>
          <h5 class="card-text">Date Approved: {{$approve->updated_at}}</h5>

          <h5 class="card-text">Status: {{$approve->status}}</h5>
          <h5 class="card-text">Reader Email: {{$approve->reader->email}}</h5>

        </div>



        <div class="btn-group  mx-auto ps-2" style="height:40%; ">
          <form class="" action="{{route('admin.borrow_request',$approve->book_id)}}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{$approve->reader->id}}">
            <button type="submit" class="btn  btn-outline-danger btn-sm ms-3 ">Borrowed  </button>

          </form>
          <form class="" action="{{route('admin.reject',$approve->book_id)}}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{$approve->reader->id}}">

            <button type="submit" class="btn  btn-outline-info btn-sm ms-3  ">Reject  </button>

          </form>
        </div>
      </div>
      <!-- end card-body -->
    </div>
    @endforeach

   {{ $approves->links() }}
 @else
 <p class="display-3"> No Books Approved Yet !</p>
 @endif
</div>
@endsection
