@if(session('success'))

<div class="alert alert-success alert-dismissible fade show small " id="alerdS">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
   <strong>{{session('success')}} </strong>
 </div>
@endif
@if(session('fail'))

<div class="alert alert-danger alert-dismissible fade show small" id="alerdS">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
   <strong> {{session('fail')}}</strong>
 </div>
@endif
@if ($errors->any())
@foreach ($errors->all() as $error)

<div class="alert alert-danger  alert-dismissible fade show  small col-9 mx-auto" id="alerdS">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong> {{ $error }} </strong>
</div>

@endforeach


@endif
