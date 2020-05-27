@extends('app::admin.layouts.master')

@section('navbar')
@component('app::admin.components.navbar')
@slot('buttons', ['create'])
@slot('resource', 'positions')
@endcomponent
@endsection

@section('content')
@component('app::admin.components.table')
@slot('title', trans('user::positions.table.list'))
@slot('route', route('admin.positions.index'))
@slot('resource', 'positions')
@slot('checkbox', true)
@slot('thead', [
	trans('user::positions.table.title'),
])

@push('tbody')
	<td>@{{ item.title }}</td>
@endpush
@endcomponent
@endsection
