@extends('admin.layouts.master')

@section('content_header')
    {{__('Create user') }}
@endsection

@section('content')
    @include('admin.user._form', [
        'action' => route('admin.users.store', ['return_url' => $return_url]),
        'method' => 'POST',
    ])
@endsection
