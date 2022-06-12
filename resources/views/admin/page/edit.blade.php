@extends('admin.layouts.master')

@section('content_header')
    {{__('Редактировать страницу ":name"', ['name' => $model->name])}}
@endsection

@section('content')
    @include('admin.page._form', [
        'action' => route('admin.pages.update', ['page' => $model->id, 'return_url' => $return_url]),
        'method' => 'PATCH',
    ])
@endsection
