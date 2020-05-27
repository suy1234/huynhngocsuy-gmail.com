<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Admin 4.0</title>
    <link href="/public/admin/app/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/public/admin/app/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/admin/app/js/plugins/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/colors.min.css" rel="stylesheet" type="text/css">

    <link href="/public/admin/app/css/icons/icomoon/styles.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/bootstrap.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/bootstrap_limitless.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/layout.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/components.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/colors.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/erp.css?v={{ rand() }}" media="all" rel="stylesheet" type="text/css">
    <style type="text/css">
        table .form-group label{
            margin: 0;
            padding: 0;
        }
        input[type="checkbox"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"] {
            position: relative;
            border: none;
            outline: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            cursor: pointer;
            box-sizing: border-box;
            padding: 0;
        }
        input[type="checkbox"]:checked:before, .checkbox input[type="checkbox"]:checked:before, .checkbox-inline input[type="checkbox"]:checked:before {
            content: "";
            position: absolute;
            top: 2px;
            left: 6px;
            display: table;
            width: 6px;
            height: 12px;
            border: 2px solid #fff;
            border-top-width: 0;
            border-left-width: 0;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }
        input[type="checkbox"]:after, .checkbox input[type="checkbox"]:after, .checkbox-inline input[type="checkbox"]:after {
            content: "";
            display: block;
            width: 20px;
            height: 20px;
            border: 2px solid #bbb;
            border-radius: 2px;
            -webkit-transition: 240ms;
            transition: 240ms;
        }
        input[type="checkbox"]:checked:after, .checkbox input[type="checkbox"]:checked:after, .checkbox-inline input[type="checkbox"]:checked:after {
            background-color: #51bea8;
            border-color: #51bea8;
        }
    </style>
    <script src="/public/admin/app/js/main/jquery.min.js"></script>
    <script src="/public/admin/app/js/main/bootstrap.bundle.min.js"></script>
    <script src="/public/admin/app/js/plugins/loaders/blockui.min.js"></script>

    <script src="/public/admin/app/js/plugins/forms/styling/uniform.min.js"></script>
    <script src="/public/admin/app/js/plugins/forms/styling/switchery.min.js"></script>
    <script src="/public/admin/app/js/plugins/ui/moment/moment.min.js"></script>
    <script src="/public/admin/app/js/plugins/pickers/daterangepicker.js"></script>
    <script src="/public/admin/app/js/plugins/forms/selects/select2.min.js"></script>
    <script src="/public/admin/app/js/plugins/forms/selects/bootstrap_multiselect.js"></script>

    <script src="/public/admin/assets/js/app.js"></script>

</head>
<body>
    <div id="app">
        @include('app::admin.layouts.header')
        <div class="page-content">
            @include('app::admin.layouts.sidebar')
            <div class="content-wrapper">
                @yield('navbar')
                <div class="content" id="content-master" style="padding-top: 4em;">
                    @if(!empty(session()->get('error')))
                    <div class="alert alert-danger alert-styled-left alert-dismissible" style="margin: 0;">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                        <span class="font-weight-semibold">Oh no!</span> {!! session()->get('error') !!}.
                    </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(window).scroll(function() {
            if ($(this).scrollTop() > 20) {
                $('#page-header-light').css('top', '0');
            } else {
                $('#page-header-light').css('top', '');
            }
        });
    </script>

    <script type="text/javascript" src="{{ asset('public/admin/vue/vue.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/app/js/plugins/notifications/bootstrap-notify.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/app/js/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/vue/components.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/vue/helper.js') }}"></script>
    @stack('script')
    <script type="text/javascript">
        var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

        var app = new Vue ({
            el: '#app',
            mixins: [mix],
            data: {
                calculating: false,
                isLoading: false,
                alert: {
                    success: false,
                    danger: false,
                    title: '',
                },
                form: {}
            },
            methods: {
                store: function (url) {
                    var vm = this;
                    vm.isLoading = false;
                    var formdata = new FormData;
                    $.each(vm.form, function(index, val) {
                        formdata.append(index , val)
                    });
                    helper.post( url , formdata ,15000)
                    .done( function(res , status , xhr){
                        vm.isLoading = false;
                        if(res.success){
                            vm.alert.success = true;
                            vm.alert.title = res.resource;
                            helper.showNotification("{{ trans('validation.attributes.success') }}", 'success', 1000);
                            window.location.href = res.url;
                            return true;
                        }else{
                            vm.alert.danger = true;
                            vm.alert.title = res.resource;
                            if(jQuery.type( res.msg ) === "string"){
                                helper.showNotification(res.msg, 'danger', 1000);
                            }
                            else{
                                $.each( res.msg, function( key, value ) {
                                    $("input[name="+key+"]").addClass('red-border').focus();
                                    helper.showNotification(value, 'danger', 1000);
                                    setTimeout(function(){ $("input[name="+key+"]").removeClass('red-border'); }, 3000);
                                });
                            }
                        }
                        return false;
                    }).fail(function(err){
                        // console.log(err);
                        if (typeof err.responseJSON.errors != 'undefined'){
                            $.each( err.responseJSON.errors, function( key, value ) {
                                $("input[name="+key+"]").addClass('red-border').focus();
                                helper.showNotification(value, 'danger', 1000);
                                setTimeout(function(){ $("input[name="+key+"]").removeClass('red-border'); }, 3000);
                            });
                        }
                        vm.alert.danger = true;
                        vm.alert.title = '{{ trans('validation.attributes.error') }}';
                        helper.showNotification("{{ trans('validation.attributes.error') }}", 'danger', 1000);
                        vm.isLoading = false;
                    })
                },
                update: function (url) {
                    var vm = this;
                    vm.isLoading = false;
                    var formdata = new FormData;
                    $.each(vm.form, function(index, val) {
                        formdata.append(index , val)
                    });
                    helper.post( url , formdata ,15000)
                    .done( function(res , status , xhr){
                        vm.isLoading = false;
                        if(res.success){
                            vm.alert.success = true;
                            vm.alert.title = res.resource;
                            helper.showNotification("{{ trans('validation.attributes.success') }}", 'success', 1000);
                            return true;
                        }else{
                            vm.alert.danger = true;
                            vm.alert.title = res.resource;
                            if(jQuery.type( res.msg ) === "string"){
                                helper.showNotification(res.msg, 'danger', 1000);
                            }
                            else{
                                $.each( res.msg, function( key, value ) {
                                    $("input[name="+key+"]").addClass('red-border').focus();
                                    helper.showNotification(value, 'danger', 1000);
                                    setTimeout(function(){ $("input[name="+key+"]").removeClass('red-border'); }, 3000);
                                });
                            }
                        }
                        return false;
                    }).fail(function(err){
                        console.log(err);
                        vm.alert.danger = true;
                        vm.alert.title = '{{ trans('validation.attributes.error') }}';
                        if (typeof err.responseJSON.errors != 'undefined'){
                            $.each( err.responseJSON.errors, function( key, value ) {
                                $("input[name="+key+"]").addClass('red-border').focus();
                                helper.showNotification(value, 'danger', 1000);
                                setTimeout(function(){ $("input[name="+key+"]").removeClass('red-border'); }, 3000);
                            });
                        }
                        helper.showNotification("{{ trans('validation.attributes.error') }}", 'danger', 1000);
                        vm.isLoading = false;
                    })
                },
            },
            mounted() {
                var vm = this;
                $( "body" ).on( "click", "a.btn-store", function(event) {
                    event.preventDefault();
                    vm.store($(this).attr('href'));
                });
                $( "body" ).on( "click", "a.btn-update", function(event) {
                    event.preventDefault();
                    vm.update($(this).attr('href'));
                });
            },
            created: function () {
                $('#content-master').css('display', 'block');
            },
        });
    </script>
</body>
</html>
