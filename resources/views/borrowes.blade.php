@extends('admin.dashboard')

@section('title', ' Admin Borrowed Books')

@section('content')
<div class="row  mt-3 mb-2 mx-auto ">
  @if($borrow!= null)
  <p class="display-6"> Book You Borrowed</p>

    <div class="card col-4" >
      <img class="card-img-top" src="{{asset($borrow->book->b_photo_path)}}" alt="Book image">
    </div>
    <div class="card col-7 " >
      <!-- card-body -->
      <div class="card-body dash-color dash-bg-color" >
        <p class="card-title ">Name : {{$borrow->book->title}}</p>
        <h3 class="card-text">Auther :{{$borrow->book->auther}}</h3>
        <h3 class="card-text">Edition :{{$borrow->book->edition}}</h3>
        <h3 class="card-text">Genre :{{$borrow->book->genre}}</h3>
        <h3 class="card-text">ISBN :{{$borrow->book->ISBN}}</h3>
        <h3 class="card-text"> Publish Year :{{$borrow->book->published_year}}</h3>
        <h3 class="card-text"> Date Borrowed: {{$borrow->updated_at}}</h3>
        <h3 class="card-text"> Days Allowed: {{$borrow->book->allowed_days}} days</h3>
        <h3 class="card-text bg-warning"> Remain Days: {{$until}}</h3>
        <h3 class="card-text"> Status: {{$borrow->status}}</h3>
      </div>
    </div>
  @else
  <p class="display-5 m-5 p-5  text-success"> No Books Borrowed Yet !</p>
  @endif
</div>

<div class="row  mt-3 mb-2 mx-auto ">
  <p class="display-6"> Books You Returned</p>

  @if($returns->count() !=0)

      @foreach($returns as $return)
      <div class="card shadow-lg book_st">
        <div class=" " style="height:300px;">
          <img class="card-img-top h-100" src="{{asset($return->book->b_photo_path) }}" alt="Book image"  >
        </div>
        <!-- card-body -->
        <div class="card-body h-75" style="height:75%;">
          <div class="h" style="height:60%;  overflow-y:scroll;">

            <h5 class="card-text">Date Borrowed: {{$return->created_at}}</h5>
            <h5 class="card-text">Date Return : {{$return->updated_at}}</h5>
            <h5 class="card-text">Status: {{$return->status}}</h5>
            @if($return->reader->reader_status->count() !=0)
              @foreach($return->reader->reader_status as $status)
                <h6 class="card-text bg-warning">Return Status: {{$status->status}}</h6>
                <h6 class="card-text bg-warning"> Description: {{$status->description}}</h6>
              @endforeach
            @endif
          </div>

        </div>
        <!-- end card-body -->
      </div>
      @endforeach

      {{ $returns->links() }}
  @else
  <p class="display-3 m-5 p-5  text-success"> No Books returns Yet !</p>
  @endif
</div>
@endsection
