@extends('admin.layouts.master')

@section('content_header')
    {{__('Edit menu ":name"', [
        'name' => $model->title,
    ])}}
@endsection

@section('content')
    @include('admin.apartment-category._form', [
        'action' => route('admin.apartment-categories.update', ['apartmentCategory' => $model->id, 'return_url' => $return_url]),
        'method' => 'PATCH',
    ])
@endsection
