@extends('admin.layouts.master')

@section('content_header')
    {{__('Edit blog category ":name"', [
        'name' => $model->name,
    ])}}
@endsection

@section('content')
    @include('admin.blog-category._form', [
        'action' => route('admin.blog-categories.update', ['blog_category' => $model->id, 'return_url' => $return_url]),
        'method' => 'PATCH',
    ])
@endsection
