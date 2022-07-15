@extends('admin.layouts.master')

@section('content_header')
    {{__('Edit apartment ":name"', [
        'name' => $model->name,
    ])}}
@endsection

@section('content')
    @include('admin.apartment._form', [
        'action' => route('admin.apartments.update', ['apartment' => $model->id, 'return_url' => $return_url]),
        'method' => 'PATCH',
    ])
@endsection
