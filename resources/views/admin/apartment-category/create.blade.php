@extends('admin.layouts.master')

@section('content_header')
    {{ __('Create apartment category') }}
@endsection

@section('content')
    @include('admin.apartment-category._form', [
        'action' => route('admin.apartment-categories.store', ['parent_id' => $model->parent_id, 'return_url' => $return_url]),
        'method' => 'POST',
    ])
@endsection
