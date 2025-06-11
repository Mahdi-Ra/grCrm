@extends('layout.wrapperplain') @section('content')
<!--signup-->
<div class="login-logo m-t-30 p-b-5">
    <a href="javascript:void(0)" class="text-center db">
        <img src="{{ runtimeLogoLarge() }}" alt="Home">
    </a>
</div>

<div class="login-box m-t-20">
    <form class="form-horizontal form-material" id="loginForm">
        <div class="title">
            <h4 class="box-title m-t-10 text-center">ورود به حساب کاربری</h4>
            <div class="text-center  m-b-20 ">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control text-right" type="text" name="email" id="email"
                    placeholder="ایمیل">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control text-right" type="password" name="password" id="password"
                    placeholder="رمز عبور">
            </div>
        </div>
        <div class="form-group">
            <label class="custom-control custom-checkbox cursor-pointer">
                <input type="checkbox" class="custom-control-input" name="remember_me" checked="checked">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">به خاطر بسپارید</span>
            </label>
        </div>
        <div class="form-group row p-t-10 p-b-10">
            <div class="col-md-12">
                <a href="{{ url('forgotpassword') }}" id="to-recover" class="text-dark pull-right js-toggle-login-forms"
                    data-target="login-forms-forgot">
                    <i class="fa fa-lock m-r-5"></i> فراموشی رمزعبور</a>
            </div>
        </div>

        <!--DYANMIC TRUSTED CONTENT - No sanitizing required] for this trusted content (Google reCAPTCHA)-->
        @if(@config('system.settings2_captcha_status') == 'enabled')
        <div class="m-b-20">
            {!! htmlFormSnippet([]) !!}
        </div>
        @endif

        <div class="form-group text-center p-b-10">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block" id="loginSubmitButton"
                    data-button-loading-annimation="yes" data-button-disable-on-click="yes"
                    data-url="{{ url('login?action=initial&redirect_url='.request('redirect_url')) }}"
                    data-ajax-type="POST" type="submit">ادامه</button>
            </div>
        </div>
        @if(config('system.settings_clients_registration') == 'enabled')
        <div class="form-group m-b-0">
            <div class="col-sm-12 text-center">
                حساب کاربری ندارید؟
                <a href="{{ url('signup') }}" class="text-info m-l-5 js-toggle-login-forms"
                    data-target="login-forms-signup">
                    <b>ثبت نام</b>
                </a>
                </p>
            </div>
        </div>
        @endif
    </form>
</div>

<div class="login-background">
    <div class="x-left">
        <img src="{{ url('/') }}/public/images/login-1.png" class="login-images" />
    </div>
    <div class="x-right hidden">
        <img src="{{ url('/') }}/public/images/login-2.png" alt="404 - Not found" />
    </div>
</div>
<!--signup-->
@endsection