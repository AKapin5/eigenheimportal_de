@extends('admin.layouts.master')

@section('content_header')
    {{__('Edit menu ":name"', [
        'name' => $model->title,
    ])}}
@endsection

@section('content')
    @include('admin.menu._form', [
        'action' => route('admin.menus.update', ['menu' => $model->id, 'return_url' => $return_url]),
        'method' => 'PATCH',
    ])
@endsection
