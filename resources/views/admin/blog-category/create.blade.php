@extends('admin.layouts.master')

@section('content_header')
    {{ __('Create blog category') }}
@endsection

@section('content')
    @include('admin.blog-category._form', [
        'action' => route('admin.blog-categories.store', ['parent_id' => $model->parent_id, 'return_url' => $return_url]),
        'method' => 'POST',
    ])
@endsection
