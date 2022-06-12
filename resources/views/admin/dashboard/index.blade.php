@extends('admin.layouts.master')

@section('content_header')
    {{ __('Админ панель') }}
@endsection

@section('content')
    {{ __('Добро пожаловать в админ панель :name!', ['name' => config('app.name')]) }}
@endsection
