@extends('admin.dashboard')

@section('title', ' Admin '.$title)
@section('content')

@section('content')
    <div class=" m-2 mt-4">
        <div class="card shadow-lg border-0 ">
            <div class="card-header m-2 " style="background:#ccff99; color:#1a3300">Manage {{$title}}</div>
            <div class="card-body table-responsive">
                {{ $dataTable->table(['class'=>'table-sm table-responsive dt-responsive nowrap','style'=>'width:10%']) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
