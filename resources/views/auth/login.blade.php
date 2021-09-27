<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name', 'Login') }}</title>
    <link href="{{ asset('auth/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="forms-container">
        <div class="signin-signup">
            <form class="sign-in-form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <h2 class="title">Đăng nhập</h2>

                <div class="input-field form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <input id="email" type="email" placeholder="Nhập email" name="email" value="{{ old('email') }}"
                           required autofocus/>
                </div>

                <div class="input-field form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <i class="fas fa-lock"></i>
                    <input id="password" type="password" placeholder="Nhập mật khẩu" name="password" required/>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                    @endif
                </div>

                <input type="submit" value="Đăng nhập" class="btn solid"/>

                <p class="social-text">Hoặc đăng nhập với các nền tảng</p>
                <div class="social-media">
                    <a href="#" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div><br/>

                <p class="social-text" style="color: #0052CC">Không thể đăng nhập?
                    <a class="text-signin-signup" href="/register">Đăng ký tài khoản</a>
                </p>
            </form>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
            </div>
            <img src="/auth/img/log.svg" class="image" alt=""/>
        </div>
    </div>
</div>

<script src="{{ asset('auth/app.js') }}"></script>
</body>
</html>