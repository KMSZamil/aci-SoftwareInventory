<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('assets/images/z-white.png')}}" />
    <title>Registration Page</title>
    <link rel="stylesheet" href="{{ asset('')}}assets/vendors/core/core.css">
    <link rel="stylesheet" href="{{ asset('')}}assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="{{ asset('')}}assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{ asset('')}}assets/css/demo_1/style.css">
	<link rel="stylesheet" href="{{ asset('css/custom.css')}}">
</head>
<body class="sidebar-dark">
<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4 pr-md-0">
                                <div class="auth-left-wrapper" style="background-image: url('{{asset('assets/images/z-black.png')}}');  max-width: 100%;max-height: 45%;">

                                </div>
                            </div>
                            <div class="col-md-8 pl-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <a href="#" class="noble-ui-logo d-block mb-2">Laravel<span>8 MSSQL</span></a>
                                    <h5 class="text-muted font-weight-normal mb-4">Create account</h5>
                                    <form method="POST" action="{{ route('authenticate.make_register') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="UserID">User ID</label>
                                            <input type="text" placeholder="UserID" class="form-control @error('UserID') is-invalid @enderror" name="UserID" value="{{ old('UserID') }}" required autocomplete="UserID" autofocus">
                                            @error('UserID')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="UserName">User Name</label>
                                            <input type="text" placeholder="UserName" class="form-control @error('UserName') is-invalid @enderror" name="UserName" value="{{ old('UserName') }}" required autocomplete="UserName" autofocus">
                                            @error('UserName')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="Designation">Designation</label>
                                            <input type="text" placeholder="Designation" class="form-control @error('Designation') is-invalid @enderror" name="Designation" value="{{ old('Designation') }}" required autocomplete="Designation" autofocus">
                                            @error('Designation')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="Email">Email address</label>
                                            <input type="email" placeholder="Email" class="form-control @error('Email') is-invalid @enderror" name="Email" value="{{ old('Email') }}" required autocomplete="Email">
                                            @error('Email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="Password">Password</label>
                                            <input type="password" placeholder="Password" class="form-control  @error('Password') is-invalid @enderror" name="Password" required autocomplete="new-password">
                                            @error('Password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="Password_Confirm">Confirm Password</label>
                                            <input id="Password_Confirm" type="password" class="form-control" name="Password_Confirm" required autocomplete="new-password">
                                        </div>
{{--                                        <div class="form-check form-check-flat form-check-primary">--}}
{{--                                            <label class="form-check-label">--}}
{{--                                                <input type="checkbox" class="form-check-input">--}}
{{--                                                Remember me--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary text-white mr-2 mb-2 mb-md-0">Sing up</button>
                                        </div>
                                        <a href="{{ route('authenticate.login') }}" class="d-block mt-3 text-muted">Already a user? Sign in</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('')}}assets/vendors/core/core.js"></script>
<script src="{{ asset('')}}assets/vendors/feather-icons/feather.min.js"></script>
<script src="{{ asset('')}}assets/js/template.js"></script>
</body>
</html>
