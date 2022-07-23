@extends('admin.layouts.master')

@section('content_header')
    {{ __('Create blog') }}
@endsection

@section('content')
    @include('admin.blog._form', [
        'action' => route('admin.blogs.store', ['category_id' => $model->category_id, 'return_url' => $return_url]),
        'method' => 'POST',
    ])
@endsection
