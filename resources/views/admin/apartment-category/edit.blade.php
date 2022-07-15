@extends('admin.layouts.master')

@section('content_header')
    {{__('Edit apartment category ":name"', [
        'name' => $model->name,
    ])}}
@endsection

@section('content')
    @include('admin.apartment-category._form', [
        'action' => route('admin.apartment-categories.update', ['apartment_category' => $model->id, 'return_url' => $return_url]),
        'method' => 'PATCH',
    ])
@endsection
