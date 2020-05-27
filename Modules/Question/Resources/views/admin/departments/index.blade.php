@extends('app::admin.layouts.master')

@section('navbar')
@component('app::admin.components.navbar')
@slot('buttons', ['create'])
@slot('resource', 'departments')
@endcomponent
@endsection

@section('content')
@component('app::admin.components.table')
@slot('title', trans('user::departments.table.list'))
@slot('route', route('admin.departments.index'))
@slot('resource', 'departments')
@slot('checkbox', true)
@slot('thead', [
	trans('user::departments.table.title'),
])

@push('tbody')
	<td>@{{ item.title }}</td>
@endpush
@endcomponent
@endsection
