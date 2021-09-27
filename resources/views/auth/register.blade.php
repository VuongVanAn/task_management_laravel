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
<div class="container sign-up-mode">
    <div class="forms-container">
        <div class="signin-signup">
            <form method="POST" action="{{ route('register') }}" class="sign-up-form">
                {{ csrf_field() }}
                <h2 class="title">Đăng ký</h2>

                <div class="input-field form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <i class="fas fa-user"></i>
                    <input id="name" type="text" placeholder="Tên tài khoản" name="name" value="{{ old('name') }}"
                           required autofocus/>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="input-field form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <input id="email" type="email" placeholder="Nhập email" name="email" value="{{ old('email') }}"
                           required/>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
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

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input id="password-confirm" type="password" placeholder="Nhập lại mật khẩu"
                           name="password_confirmation" required/>
                </div>

                <input type="submit" class="btn" value="Đăng ký"/>
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

                <p class="social-text" style="color: #0052CC">Bạn đã có tài khoản?
                    <a class="text-signin-signup" href="/login">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel"></div>
        <div class="panel right-panel">
            <div class="content">
            </div>
            <img src="auth/img/register.svg" class="image" alt=""/>
        </div>
    </div>
</div>

<script src="{{ asset('auth/app.js') }}"></script>
</body>
</html>