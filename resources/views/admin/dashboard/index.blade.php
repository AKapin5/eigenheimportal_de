@extends('admin.layouts.master')

@section('content_header')
    {{ __('Admin panel') }}
@endsection

@section('content')
    {{ __('Welcome to admin panel of :name!', ['name' => config('app.name')]) }}
@endsection
