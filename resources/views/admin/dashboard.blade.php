<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="book,learn,buy book,request book,read">
    <meta name="Description" content="Well organized and easy to read ,borrow,buy books .">
    <link rel="icon" href="{{asset('design_image/icon_kotob.PNG')}}" type="image/png">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> -->
    <title>KOTOBAK  - @yield('title')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script>
    document.body.onscroll = function() {myFunction()};

    function myFunction() {
      document.getElementById("side_bar").style.paddingTop = "50px;";
    }
    </script>
  <style media="screen">
    body{
       margin: 0;
       font-size: 28px;
       font-family: Arial, Helvetica, sans-serif;
       background-color: rgb(238, 255, 204);
       width: 100%;
       height: 100%;

     }
     /* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px rgba(0, 26, 0, 0.5);;
  border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #394d00;;
  border-radius: 50px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #394d00;
}
     .footer{
       width: 100%;
       bottom: 0;
       background-color:#e6ff99;
       left: 0;
       color: #194d19;
     }
     .header{
         background: rgba(0, 26, 0, 0.5);
         background-size: cover;
         background: url("{{asset('design_image/narrative-794978_1920.jpg')}}") center center  no-repeat   !important;
width: 100%;
         background-repeat: no-repeat;
         padding: 30px;
         text-align: center;
         height: 100px;
     }
     #navbar  {
        overflow: hidden;
        background: rgba(0, 26, 0, 0.8);
        bottom: 0;
        margin: 0;
        margin-left: 0px;
        width:100%;
        z-index: 1000;

        padding: 5px;
        height: 50px;;
      }
      #navbar a {
        float: left;
        display: block;
        color: rgb(0,26,0);
        text-align: center;
        padding: 10px 12px;
        text-decoration: none;
        font-size: 3.5ew;
      }

      #navbar a:hover {
        background-color: #ddd;
        color: black;
      }

      #navbar a.active {
        background-color: #4CAF50;
        color: white;
      }
      #side_bar {
        margin: 0;
        margin-top: -0px;;
        padding: 0;
        width: 250px;
        padding-top: 20px;
        background-color:rgb(96, 128, 0);
        position: absolute;

        height: 500% ;
        overflow: auto;
        min-height: 150vh;
        max-height: 1000vh;
        z-index:1;
        display: block;;
      }
      .side_color{
        background-color:rgb(96, 128, 0);
      }

      .content {
        padding: 16px;
      }

      .sticky {
        position: fixed;
        top: 0;
        width: 100%;
      }

      .sticky + .content {
        padding-top: 60px;
      }
      /* .sticky + #side_bar {
        padding-top: 60px;
      } */

      /*
      */

      .head-text{
        color: white;
      }
      .side_inside{
        z-index:1000;
        position: relative;
        height: 490px;
        overflow-y: auto;
      }

  /* Sidebar links */
    #side_bar a {
      display: block;
      color: white;
      padding: 12px;
      font-size: 20px;;
      text-decoration: none;
    }
    .accordion a{
      color: white;

      padding: 12px;

      font-size: 20px;;

    }
    .accordion {
      background-color:rgb(96, 128, 0);
      color: #fff;
      cursor: pointer;
      width: 100%;
      transition: 0.4s;
    }
    .accordion  a.active {
      background-color: rgb(153, 204, 0);
      color: white;
    }
    .panel {
      padding: 18px;
      background-color:rgb(96, 128, 0);
      height: 200px;
      display: none;
      /* overflow: hidden; */
      overflow-y: auto;
    }

    /* Active/current link */
    #side_bar  a.active {
      background-color: rgb(153, 204, 0);
      color: white;
    }
    .panel  a.active {
      background-color: rgb(153, 204, 0);
      color: white;
    }
    #img a.active {
      background-color: rgb(96, 128, 0);
    }
    #img a {
      display: block;
      padding: 5px;
      text-decoration: none;
       }


    /* Links on mouse-over */
    #side_bar  a:hover:not(.active) {
      background-color: #fff;
      color: rgb(0,51,0);
    }
    #img  a:hover:not(.active) {
      background-color: rgb(96, 128, 0);;
    }
    .head-text {
      font-size:5vw;
      text-shadow: 2px 2px 5px red;

    }

    /* Page content. The value of the margin-left property should match the value of the sidebar's width property */
    div.containter {
      margin-left: 250px;
      padding: 1px 16px;
      height: 100vh;
    }
    .side-icon-div{
      display:none;

    }
    .side_icon{
      display:none;

    }
    #form{
      width:60%;
      margin-left: 5px;
      margin-right: 5px;
    }
    .dash-color{
      color:#1a3300;
    }
    .dash-bg-color{
      background-color:#ccff99;
    }
    .book_st{
      z-index:500;
      width:30%;
      margin:auto;
      margin-bottom: 15px;
      margin-top: 15px;
      height:500px;
      border:none;
    }
@media screen and (max-width: 1000px) {
  .book_st{
    width:45%;
  }
  .side-icon-div{
    display:block;

  }
  #side_bar {

    display: none;
  }
  div.containter {
    margin-left: 10px;
    padding: 1px 16px;
    height: 100vh;
  }
  .head-text  h1{
    font-size:4.5vw;
    text-shadow: 2px 2px 5px red;

  }

  div.content {margin-left: 10;}
}
@media screen and (max-width: 600px) {
  .book_st{
    width:100%;
  }
}



  </style>
  <script type="text/javascript">
  function open_accordion(id,acc){
    // acc.classList.toggle("active");

    var panel = document.getElementById(id);

      if (panel.style.display === "block") {
        panel.style.display = "none";
      }
      else {
        panel.style.display = "block";

        if(id=="shelves"){
          document.getElementById("sections").style.display ="none";
        }
        else{
          document.getElementById("shelves").style.display ="none";
        }
      }
    }
    ////////////////////////////////////////////
    function activate_link(){
    var   myUrl = window.location.href;
      var pos = myUrl.includes("shelf-show");
      var pos2 = myUrl.includes("section-show");
      var panel = document.getElementById("shelves");
      var panel2 = document.getElementById("sections");
      if(pos==true){
        panel.style.display = "block";
      }
      if(pos2 == true){
        panel2.style.display = "block";
      }



    }

  </script>
  </head>
  <body onload="activate_link()">

    <div class="header">
      <div class="head-text">
        <h1 >WELCOME  {{\Illuminate\Support\Str::of(auth()->user()->name)->upper()}} TO YOUR LIBRARY </h1>
      </div>

    </div>

    <div id="navbar" class="clearfix d-flex  " >

      <!-- <button onclick="side_func()">X</button> -->

    @if(auth()->user()->hasRole(['reader']))

      <form class="d-flex w-50 " action="{{route('search')}}" role="search" id="form" method="post">
        @csrf
            <input type="search" class="form-control me-2" placeholder="search..." aria-label="search" name="search" value="{{old('search')}}">
            <!-- <button type="button" class="btn btn-outline-success text-white" type="submit"> &#128269;</button> -->
      </form>
    @else
    <div class="w-50">

    </div>
    @endif
      <div class="w-50" style="float:right; ">
        <div class=" float-end  me-0" >
          <button  type="button" class="btn btn-outline-success text-white" onclick="side_func()"> &#9776;  </button>
          <!-- <a  href="" class="side_icon" >  </a> -->
        </div>
        <div class=" float-end me-0 " style="margin-right:0px;">

            <form class="" action="{{ route('logout') }}" method="post">
              @csrf
            <button class="btn btn-outline-success text-white" type="submit"> Logout</button>

            </form>
        </div>

      </div>

    </div>
    <div class="sidebar  " id="side_bar">
      <div class="mb-2" id="img">
        <a href="#"  style=""><img src="{{asset('design_image/logo_side5.PNG')}}" alt="" width="250px" height="90px">
    </a>
      </div>
      <div class="side_inside">


       @if(auth()->user()->hasRole(['admin','librarian']))
        <a class="{{request()->routeIs('admin.dashboard') ?'active':''}} " href="{{route('admin.dashboard')}}"> Dashboard</a>
        <a href="{{route('admin.books.index')}}" class="{{request()->routeIs('admin.books.*') ?'active':''}}">  Books</a>
        <a href="{{route('admin.sections.index')}}" class="{{request()->routeIs('admin.sections.*') ?'active':''}}">Sections</a>
        <a href="{{route('admin.shelves.index')}}" class="{{request()->routeIs('admin.shelves.*') ?'active':''}}">Shelves</a>
      @endif
      @if(auth()->user()->hasRole('reader'))
       <a href="{{route('home')}}" class="{{request()->routeIs('home') ?'active':''}}">  Home</a>
       <a href="{{route('requests')}}" class="{{request()->routeIs('requests') ?'active':''}}">  Requested Books</a>

       <a href="{{route('borrowed_book')}}" class="{{request()->routeIs('borrowed_book') ?'active':''}}">  Book Borrowed</a>
       <div class="dropdown">
          <a   class="accordion {{request()->routeIs('shelf_show.*') ?'active':''}}" onclick="open_accordion('shelves',this)" id="shelf-show">  Shelves</a>
          <ul class="panel" id="shelves" >
             @if(count($shelves) !=0)
               @foreach($shelves as $id => $shelf)
                 <li><a class="dropdown-item {{request()->is('shelf-show/'.$id) ?'active':''}}" href="{{route('shelf_show',$id)}}" id="shelf-show/{{$id}}">{{$shelf}}  </a></li>
               @endforeach
             @endif
          </ul>
        </div>
        <div class="dropdown">
           <a   class="accordion {{request()->routeIs('section_show.*') ?'active':''}}" onclick="open_accordion('sections',this)" id="section-show">  Sections</a>
           <ul class="panel" id="sections" >

             @if(count($sections) !=0)
               @foreach($sections as $id => $section)
                 <li><a class="dropdown-item {{request()->is('section-show/'.$id) ?'active':''}}" href="{{route('section_show',$id)}}" id="section-show/{{$id}}">{{$section}}</a></li>
               @endforeach
             @endif
           </ul>
         </div>
      @endif
      @if(auth()->user()->hasRole('librarian'))
       <a href="{{route('admin.requested_books')}}" class="{{request()->routeIs('admin.requested_books') ?'active':''}}">  Books Requested</a>
       <a href="{{route('admin.borrowed_books')}}" class="{{request()->routeIs('admin.borrowed_books') ?'active':''}}">  Books Borrowed</a>
       <a href="{{route('admin.approved_books')}}" class="{{request()->routeIs('admin.approved_books') ?'active':''}}">  Books Approved</a>

       <a href="{{route('admin.readers.index')}}" class="{{request()->routeIs('admin.readers.*') ?'active':''}}">Readers</a>
      @endif
      @if(auth()->user()->hasRole('admin'))
       <a href="{{route('admin.librarians.index')}}" class="{{request()->routeIs('admin.librarians.*') ?'active':''}}">Librarians</a>
       <a href="{{route('admin.roles.index')}}" class="{{request()->routeIs('admin.roles.*') ?'active':''}}">Roles</a>
      @endif
       <!-- user links -->



     </div>
    </div>

    <div class="containter " id="content">
      @include('session')
      @yield('content')


    <script>
      window.onscroll = function() {myFunction()};

      var navbar = document.getElementById("navbar");
      var sticky = navbar.offsetTop;

      function myFunction() {
        if (window.pageYOffset >= sticky) {
          navbar.classList.add("sticky")
        } else {
          navbar.classList.remove("sticky");
        }
      }
  function side_func() {
    var x = document.getElementById("side_bar");
    var y = document.getElementById("content");

    if (x.style.display === "none") {
      x.style.display = "block";
      y.style.marginLeft ="250px" ;

    } else {
      x.style.display = "none";
      y.style.marginLeft ="10px" ;

    }
  }
  /////////////////////////////
  function showDrop() {
    var x = document.getElementById("dropList");

    if (x.style.display === "none") {
      x.style.display = "block";

    } else {
      x.style.display = "none";

    }
  }
    </script>
     @stack('scripts')
  </body>
</html>
