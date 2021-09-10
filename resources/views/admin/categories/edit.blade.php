@extends('layouts.dashboard')
@section('title', 'Edit Category')
@section('content')
<form action="{{ route('admin.categories.update', $id )}}" method="post" enctype="multipart/form-data">
    @CSRF
    @method('put')

    @include('admin.categories._form', [
        'button_label' => 'Update',
    ])
    
</form>
        @endsection
