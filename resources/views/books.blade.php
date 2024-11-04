@extends('admin.dashboard')

@section('title', ($title??'LIBRARY').' BOOKS')

@section('content')
<div class="row  mt-3 mb-2 mx-auto " >
  @php
  $books = session('results')??$books;

  @endphp
  @if($books->count()!=0)
    <p class="display-6 text-dark">{{$title??'LIBRARY'}} Books</p>
    @foreach($books as $book)
    <div class="card shadow-lg book_st "  >
      <img class="card-img-top h-75 " src="{{asset($book->b_photo_path) }}" alt="Book image" >
      <!-- card-body -->
      <div class="card-body h-50">
        <!-- <p class="card-title">{{$book->title}} -->
        <div class="h" style="height:65%;">
          <h5 class="card-text">{{$book->auther}}</h5>
        </div>



        <div class=" d-grid h-25" >
          <a href="{{route('user-books.show',$book->id)}}" class="btn btn-sm btn-outline-info btn-block rounded-pill">Show Book </a>
        </div>
      </div>
      <!-- end card-body -->
    </div>
    @endforeach
  @endif
{{ $books->links() }}

</div>
@endsection
