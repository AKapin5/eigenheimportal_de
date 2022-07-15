@extends('admin.layouts.master')

@section('content_header')
    {{ __('Create apartment') }}
@endsection

@section('content')
    @include('admin.apartment._form', [
        'action' => route('admin.apartments.store', ['category_id' => $model->category_id, 'return_url' => $return_url]),
        'method' => 'POST',
    ])
@endsection
