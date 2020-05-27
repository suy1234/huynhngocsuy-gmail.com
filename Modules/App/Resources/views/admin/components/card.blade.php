@php
$route = explode('.', Route::current()->getName());
$text = $route[array_key_last($route)];
$title = trans(\Route::getCurrentRoute()->action['module'].'::'.$resource.'.module')
@endphp
<template v-if="alert.success">
    <div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        @{{ alert.title }}
    </div>
</template>
<template v-if="alert.danger">
    <div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        @{{ alert.title }}
    </div>
</template>

<div class="card">
    <div class="card-heading">
        <strong>
            {{ trans('resource.'.$text) }} <span>{{ $title }}</span>
        </strong>
    </div>
    <div class="card-body">
        @stack('form')
    </div>
    <div class="card-footer text-right">
        <a onclick="history.back();" style="cursor: pointer;" class="btn btn-warning btn-sm">
            <b><span class="icon-reply"></span></b>
            {{ trans("resource.back") }}
        </a>
        @if (isset($buttons))
        @php($edit = !empty($id) ? ['id' => $id] : [] )
        @foreach($buttons as $view)
        <button v-on:click="{{ $view }}('{{ route('admin.'.$resource.'.'.$view, $edit) }}')" class="btn {{ config('erp.btn_class.'.$view.'.class') }} btn-sm btn-actions btn-{{ $view }}" style="margin-left: 5px;">
            <b><span class="{{ config('erp.btn_class.'.$view.'.icon') }}"></span> </b> 
            {{ trans("resource.{$view}") }}
        </button>
        @endforeach
        @endif
    </div>
</div>