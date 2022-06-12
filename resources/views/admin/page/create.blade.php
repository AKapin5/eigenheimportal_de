@extends('admin.layouts.master')

@section('content_header')
    {{__('Create a page') }}
@endsection

@section('content')
    @include('admin.page._form', [
        'action' => route('admin.pages.store', ['return_url' => $return_url]),
        'method' => 'POST',
    ])
@endsection
