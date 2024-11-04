<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="Keywords" content="book,learn,buy book,request book,read">

        <meta name="Description" content="Well organized and easy to read ,borrow,buy books .">

        <link rel="icon" href="{{asset('design_image/icon_kotob.PNG')}}" type="image/png">
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        <title>{{ config('app.name', 'guest') }}</title>
        <style media="screen">
          body{
            margin: 0;
            font-size: 28px;
            font-family: Arial, Helvetica, sans-serif;
            background: url("{{asset('design_image/book-863418_1920.jpg')}}")    no-repeat   !important;
            width: 100%;
          }
          #navbar  {
             overflow: hidden;
             background: rgba(0, 26, 0, 0.7);
             top: 0;
             margin: 0;
             margin-left: 0px;
             width:100%;
             z-index: 1000;
             position: fixed;
             padding: 5px;
             height: 150px;;
           }
           #navbar button {
             float: right;
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
        </style>
    </head>
    <body class="font-sans antialiased">
      <nav class="navbar navbar-expand-sm  fixed-top" style="background: rgba(0, 26, 0, 0.3);">
        <a class="navbar-brand" href="#">
          <!-- <img src="{{asset('design_image/logo_side5.PNG')}}" alt="Logo" style="width:200px; height:100px;" > -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->


      </nav>

      <div class="card mx-auto" style="background:rgba(96, 128, 0, 0.3);width:600px; margin-top:150px;" >
        <div class="" >

          <div class=" mx-auto p-3">
            <h4 class="card-title text-white">LOGIN</h4>
          </div>

          <!-- Modal body -->
          <div class="card-body ">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="row mb-2">
                    <label for="email" class="col-md-6  text-md-start text-white">{{ __('Email Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="password" class="col-md-6  text-md-start text-white">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label text-white" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 mx-auto d-grid">
                        <button type="submit" class="btn btn-success btn-block">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>




        </div>
      </div>
    </div>




      </div>

    </body>
</html>
