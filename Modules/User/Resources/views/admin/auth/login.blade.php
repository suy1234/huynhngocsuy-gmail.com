<!DOCTYPE html>
<html lang="en">
<head>
    <meta rel="noffoloe">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin 4.0</title>
    <link href="/public/admin/assets/css/erp.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/app/css/icons/icomoon/styles.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/bootstrap.min.css"  media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/bootstrap_limitless.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/layout.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/components.min.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/admin/assets/css/colors.min.css" media="all" rel="stylesheet" type="text/css">

    <script src="/public/admin/app/js/main/jquery.min.js"></script>
    <script src="/public/admin/app/js/main/bootstrap.bundle.min.js"></script>
    <script src="/public/admin/app/js/plugins/loaders/blockui.min.js"></script>
    <script src="/public/admin/app/js/plugins/forms/styling/uniform.min.js"></script>

    <script src="/public/admin/assets/js/app.js"></script>
    <script src="/public/admin/app/js/demo_pages/login.js"></script>
</head>
<body>
    <div class="page-content">
        <div class="content-wrapper">
            <div class="content d-flex justify-content-center align-items-center">
                <form class="login-form" action="{{ route('admin.login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                                <h5 class="mb-0">{{ trans('user::users.login.title') }}</h5>
                                <span class="d-block text-muted">{{ trans('user::users.login.description') }}</span>
                            </div>
                            @if($errors->has(0))
                                    <span class="error ">
                                        <i class="icon-cancel-circle2 mr-2"></i> {{$errors->first(0)}}
                                    </span>
                                @endif
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" name="email" required placeholder="{{ trans('user::users.login.user_placeholder') }}" value="{{ old('email') }}">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                @if($errors->has('email'))
                                    <span class="error ">
                                        <i class="icon-cancel-circle2 mr-2"></i> {{$errors->first('email')}}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="password" name="password" class="form-control" required placeholder="{{ trans('user::users.login.pass_placeholder') }}">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                                @if($errors->has('password'))
                                    <span class="error">
                                        <i class="icon-cancel-circle2 mr-2"></i> {{$errors->first('password')}}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group d-flex align-items-center">
                                <div class="form-check mb-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="remember" class="form-input-styled" checked data-fouc>
                                        {{ trans('user::users.login.remember') }}
                                    </label>
                                </div>

                                <a href="" class="ml-auto">{{ trans('user::users.login.password_recover') }}</a>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ trans('user::users.login.sign_in') }} 
                                    <i class="icon-circle-right2 ml-2"></i>
                                </button>
                            </div>

                            <div class="form-group text-center text-muted content-divider">
                                <span class="px-2">{{ trans('user::users.login.sign_in_with') }}</span>
                            </div>

                            <div class="form-group text-center">
                                <a class="btn btn-outline bg-danger border-danger text-danger btn-icon rounded-round border-2">
                                    <i class="icon-google"></i>
                                </a>
                                <a class="btn btn-outline bg-indigo border-indigo text-indigo btn-icon rounded-round border-2">
                                    <i class="icon-facebook"></i>
                                </a>
                                <a class="btn btn-outline bg-info border-info text-info btn-icon rounded-round border-2">
                                    <i class="icon-twitter"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
