@extends('app::admin.layouts.master')

@section('navbar')
	@component('app::admin.components.navbar')
		@slot('buttons', ['store'])
		@slot('resource', 'users')
	@endcomponent
@endsection

@section('content')
@php($data = ['sds' => '1'])
@component('app::admin.components.form')
	@slot('form', 'create')
	@slot('data', $data)
@endcomponent
@endsection