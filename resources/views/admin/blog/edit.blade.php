@extends('admin.layouts.master')

@section('content_header')
    {{__('Edit blog ":name"', [
        'name' => $model->name,
    ])}}
@endsection

@section('content')
    @include('admin.blog._form', [
        'action' => route('admin.blogs.update', ['blog' => $model->id, 'return_url' => $return_url]),
        'method' => 'PATCH',
    ])
@endsection
