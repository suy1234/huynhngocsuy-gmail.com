@extends('app::admin.layouts.master')

@section('navbar')
@component('app::admin.components.navbar')
@slot('buttons', ['update'])
@slot('id', $department->id)
@slot('resource', 'departments')
@endcomponent
@endsection

@section('content')
<div class="row">
	<div class="col-md-6 offset-md-3">
		@component('app::admin.components.card')
		@slot('buttons', ['update'])
		@slot('id', $department->id)
		@slot('resource', 'departments')
		@push('form')
		@include('user::admin.departments.form')
		@endpush
		@endcomponent
	</div>
</div>
@endsection