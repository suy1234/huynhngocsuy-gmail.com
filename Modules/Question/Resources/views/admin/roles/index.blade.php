@extends('app::admin.layouts.master')

@section('navbar')
@component('app::admin.components.navbar')
@slot('buttons', ['create'])
@slot('resource', 'roles')
@endcomponent

@endsection

@section('content')

@endsection
