@extends('app::admin.layouts.master')

@section('navbar')
@component('app::admin.components.navbar')
@slot('buttons', ['store'])
@slot('resource', 'roles')
@endcomponent
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		@component('app::admin.components.card')
		@slot('buttons', ['store'])
		@slot('resource', 'roles')
		@push('form')
			@include('user::admin.roles.tabs.general')
		@endpush
		@endcomponent
	</div>
</div>
@endsection