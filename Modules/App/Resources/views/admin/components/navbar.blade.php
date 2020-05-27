@php
$route = explode('.', Route::current()->getName()); 
$text = $route[array_key_last($route)];
$title = trans(\Route::getCurrentRoute()->action['module'].'::'.$resource.'.module')
@endphp
<div class="page-header page-header-light" id="page-header-light" style="position: fixed;z-index: 1;width: calc(80%);">
{{-- 	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4>
				<i class="icon-arrow-left52 mr-2"></i> 
				<span class="font-weight-semibold">{{ $title }}</span>
			</h4>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
		<div class="header-elements d-none">
			<div class="d-flex justify-content-center">
				@if (isset($buttons))
				@foreach($buttons as $view)
				<a href="{{ route('admin.'.$resource.'.'.$view) }}" class="btn {{ config('core.btn_class.'.$view.'.class') }} btn-sm btn-actions btn-{{ $view }}" style="margin-left: 5px;">
					<span class="{{ config('core.btn_class.'.$view.'.icon') }}"></span> {{ trans("resource.{$view}") }}
				</a>
				@endforeach
				@endif
			</div>
		</div>
	</div> --}}

	<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
		<div class="d-flex">
			<div class="breadcrumb">
				<a href="{{ route('admin.dashboard.index') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> {{ trans('resource.home') }}</a>
				@if($text != 'index')
				<a href="{{ route('admin.'.$resource.'.index') }}" class="breadcrumb-item">{{ $title }}</a>
				<span class="breadcrumb-item active">{{ trans('resource.'.$text) }}</span>
				@else
				{{-- <span class="breadcrumb-item active">{{ trans('resource.'.$text) }}</span> --}}
				<span class="breadcrumb-item active">{{ $title }}</span>
				@endif
				
			</div>

			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
		<div class="header-elements d-none">
			<div class="breadcrumb justify-content-center">
				@if (isset($buttons))
				@php($edit = !empty($id) ? ['id' => $id] : [] )
				@foreach($buttons as $view)
				
				<a href="{{ route('admin.'.$resource.'.'.$view, $edit) }}" class="btn {{ config('erp.btn_class.'.$view.'.class') }} btn-sm btn-actions btn-{{ $view }}" style="margin-left: 5px;">
					<b><span class="{{ config('erp.btn_class.'.$view.'.icon') }}"></span> </b> 
					 {{ trans("resource.{$view}") }}
				</a>
				@endforeach
				@endif
			</div>
		</div>
	</div>
</div>