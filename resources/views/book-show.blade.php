@extends('admin.dashboard')

@section('title', $book->title .'-Book')

@section('content')
<div class="row pe-5 m-3  ">
  <div class="card col-4" >
    <img class="card-img-top" src="{{asset($book->b_photo_path)}}" alt="Book image">
    <!-- card-body -->

    <!-- end card-body -->
  </div>
  <div class="card col-7" >
    <!-- card-body -->
    <div class="card-body dash-color dash-bg-color" >
      <p class="card-title ">Name : {{$book->title}}</p>
      <h3 class="card-text">Auther :{{$book->auther}}</h3>
      <h3 class="card-text">Edition :{{$book->edition}}</h3>
      <h3 class="card-text">Genre :{{$book->genre}}</h3>
      <h3 class="card-text">ISBN :{{$book->ISBN}}</h3>
      <h3 class="card-text"> Publish Year :{{$book->published_year}}</h3>
      <h3 class="card-text"> Hard Copies : {{$book->copies_all}}</h3>
      <h3 class="card-text"> Borrowed Copies :{{$book->copies_borrowed	}}</h3>
      <h3 class="card-text"> Available Copies :{{ $available = $book->copies_all - $book->copies_borrowed	}}</h3>
      @if($rejected != null || $rejected !=[])
      <div class="bg-warring">
        @foreach($rejected as $rej)
        <h5 class="card-text">  your request is rejected in {{$rej->requested_date}} because don't return another book or make other book request before librarian accepts </h5>

        @endforeach
      </div>
      @endif
      <div class="d-grid ">
       @if($available >=1  )
          @if( $book->requests->all() !=[] )
            <a href="#" class="btn btn-warring btn-block rounded-pill disabled">{{$book->requests[0]->status}} </a>
          @else
            <a href="{{route('request-book',$book->id)}}" class="btn btn-success btn-block rounded-pill">Borrow Book </a>
          @endif
        @else
          <a href="{{route('request-book',$book->id)}}" class="btn btn-warring btn-block rounded-pill disabled"> NOT Available </a>
=       @endif
       </div>

    </div>
    <!-- end card-body -->
  </div>



</div>
@endsection
