@extends('admin.dashboard')

@section('title', ' Admin Home')



@section('content')

<div class="row pe-5 ">
  <div class="card shadow-lg col-md-5 col-12 m-4 " style="  z-index:500; background-color:#99ccff; border:none;">
    <div class="card-body" style="color:#00264d;"> Books </div>
    <span class="text-white small"> <kbd style="background-color: #00264d;">  {{$books_counts}} books </kbd></span>

  </div>
  <div class="card shadow-lg col-md-5 col-12 m-4" style="  z-index:500; background-color:#ccccff; border:none;">
    <div class="card-body" style="color:#000033;">Borrowed Books</div>
    <span class="text-white small"> <kbd style="background-color: #000033;">  {{$borrowed_books}} Borroweds </kbd> </span>
  </div>
  <div class="card shadow-lg col-md-5 col-12 m-4" style=" z-index:500; background-color: #ccff99; border:none;">
    <div class="card-body display-6" style="color:#1a3300;">Requested books</div>
    <span class="text-white   small"> <kbd style="background-color: #1a3300;">   {{$requested_books}} Requests </kbd> </span>

  </div>
  <div class="card shadow-lg col-md-5 col-12 m-4" style="z-index:500; background-color:#ffbb99; border:none;">
    <div class="card-body" style="color:#4d1a00;"> Readers</div>
    <span class="text-white small"><kbd style="background-color: #4d1a00;">  {{$readers }} Readers </kbd></span>

  </div>
</div>
@endsection
