@extends('admin.layouts.master')

@section('content_header')
    {{__('Edit page ":title"', ['title' => $model->title])}}
@endsection

@section('content')
    @include('admin.page._form', [
        'action' => route('admin.pages.update', ['page' => $model->id, 'return_url' => $return_url]),
        'method' => 'PATCH',
    ])
@endsection
