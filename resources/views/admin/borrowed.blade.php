@extends('admin.dashboard')

@section('title', ' Admin Requested Books')

@section('content')
<div class="row  mt-3 mb-2 mx-auto ">
  @php
  $borroweds = session('results')??$borroweds;
  @endphp
  @if($borroweds->count() !=0)

      @foreach($borroweds as $borrow)
      <div class="card shadow-lg book_st ">
        <div class=" " style="height:300px;">
          <img class="card-img-top h-100" src="{{asset($borrow->book->b_photo_path) }}" alt="Book image"  >
        </div>
        <!-- card-body -->
        <div class="card-body h-75" style="height:75%;">
          <div class="h" style="height:60%;  overflow-y:scroll;">

            <h5 class="card-text">Date Requested: {{$borrow->created_at}}</h5>
            <h5 class="card-text">Date Approved: {{$borrow->updated_at}}</h5>
            <h5 class="card-text">Status: {{$borrow->status}}</h5>
            <h5 class="card-text">Reader Email: {{$borrow->reader->email}}</h5>
          </div>
            <form class="" action="{{route('admin.return_request',$borrow->book_id)}}" method="post">
              @csrf
              <input type="hidden" name="user_id" value="{{$borrow->reader->id}}">
              <div class=" d-grid  mx-auto ps-2" style="height:40%; ">
                 <button type="submit" class="btn  btn-outline-danger btn-sm btn-block ">Returned  </button>
              </div>
            </form>





        </div>
        <!-- end card-body -->
      </div>
      @endforeach

      {{ $borroweds->links() }}
  @else
  <p class="display-3 m-5 p-5  text-success"> No Books Borrowed Yet !</p>
  @endif
</div>
@endsection
