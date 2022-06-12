@extends('admin.layouts.master')

@section('content_header')
    {{__('Edit user ":name"', ['name' => $model->email])}}
@endsection

@section('content')
    @include('admin.user._form', [
        'action' => route('admin.users.update', ['user' => $model->id, 'return_url' => $return_url]),
        'method' => 'PATCH',
    ])
@endsection

