@extends('admin.layouts.master')

@section('content_header')
    {{ __('Create menu') }}
@endsection

@section('content')
    @include('admin.menu._form', [
        'action' => route('admin.menus.store', ['parent_id' => $model->parent_id, 'return_url' => $return_url]),
        'method' => 'POST',
    ])
@endsection
