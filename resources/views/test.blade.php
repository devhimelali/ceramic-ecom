@extends('frontend.layouts.app')
@section('title', 'Test Page')
@section('content')
    <div class="tabs-box">
        <ul class="tab-buttons">
            <li data-tab="#login" class="tab-btn wow animated fadeInUp animated active-btn" data-wow-delay="0.1s" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0.1s; animation-name: fadeInUp;"><span>log in</span></li>
            <li data-tab="#register" class="tab-btn wow animated fadeInUp animated" data-wow-delay="0.3s" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0.3s; animation-name: fadeInUp;"><span>register</span></li>
        </ul>
        <div class="tabs-content">
            <div class="tab fadeInUp animated active-tab" data-wow-delay="200ms" id="login" style="display: block;">
                <span class="login-page__tab-title">sign in your account</span>
                <form class="login-page__form">
                    <div class="login-page__form__input-box">
                        <input type="email" placeholder="Email address">
                        <span class="icon-email"></span>
                    </div><!-- /.login-page__form__input-box -->
                    <div class="login-page__form__input-box">
                        <input type="password" placeholder="Password" class="login-page__password">
                        <i class="toggle-password pass-field-icon fa fa-fw fa-eye-slash"></i>
                        <span class="icon-padlock"></span>
                    </div><!-- /.login-page__form__input-box -->
                    <div class="login-page__form__input-box login-page__form__input-box--bottom">
                        <div class="login-page__form__checked-box">
                            <input type="checkbox" name="remember-policy" id="remember-policy">
                            <label for="remember-policy"><span></span>remember me</label>
                        </div>
                        <a href="" class="login-page__form__forgot">forgot password?</a><!-- /.login-page__form__forgot -->
                    </div><!-- /.login-page__form__input-box -->
                    <div class="login-page__form__input-box login-page__form__input-box--button">
                        <button type="submit" class="floens-btn login-page__form__btn">log in</button>
                    </div><!-- /.login-page__form__button -->
                </form><!-- /.login-page__form -->
                <div class="login-page__signin">
                    <h4 class="login-page__signin__title">don’t have an account? <a href="#">register</a></h4><!-- /.login-page__signin__title -->
                    <span class="login-page__signin__text">or sign in with</span><!-- /.login-page__signin__text -->
                    <div class="login-page__signin__buttons">
                        <button type="button" class="login-page__signin__btn"><img src="assets/images/resources/google.png" alt="google"></button>
                        <button type="button" class="login-page__signin__btn"><img src="assets/images/resources/apple.png" alt="apple"></button>
                        <button type="button" class="login-page__signin__btn"><img src="assets/images/resources/facebook.png" alt="facebook"></button>
                    </div><!-- /.login-page__signin__buttons -->
                </div><!-- /.login-page__signin -->
            </div><!-- /.login-tab -->

            <div class="tab fadeInUp animated" data-wow-delay="200ms" id="register" style="display: none;">
                <span class="login-page__tab-title">sign up your account</span>
                <form class="login-page__form">
                    <div class="login-page__form__input-box">
                        <input type="email" placeholder="Email address">
                        <span class="icon-email"></span>
                    </div><!-- /.login-page__form__input-box -->
                    <div class="login-page__form__input-box">
                        <input type="password" placeholder="Password" class="login-page__password">
                        <i class="toggle-password pass-field-icon fa fa-fw fa-eye-slash"></i>
                        <span class="icon-padlock"></span>
                    </div><!-- /.login-page__form__input-box -->
                    <div class="login-page__form__input-box login-page__form__input-box--bottom">
                        <div class="login-page__form__checked-box">
                            <input type="checkbox" name="accept-policy" id="accept-policy">
                            <label for="accept-policy"><span></span>I accept company privacy policy.</label>
                        </div>
                    </div><!-- /.login-page__form__input-box -->
                    <div class="login-page__form__input-box login-page__form__input-box--button">
                        <button type="submit" class="floens-btn login-page__form__btn">Register</button>
                    </div><!-- /.login-page__form__button -->
                </form><!-- /.login-page__form -->
                <div class="login-page__signin">
                    <h4 class="login-page__signin__title">Already have an account? <a href="#">Sign In</a></h4><!-- /.login-page__signin__title -->
                    <span class="login-page__signin__text">or sign in with</span><!-- /.login-page__signin__text -->
                    <div class="login-page__signin__buttons">
                        <button type="button" class="login-page__signin__btn"><img src="assets/images/resources/google.png" alt="google"></button>
                        <button type="button" class="login-page__signin__btn"><img src="assets/images/resources/apple.png" alt="apple"></button>
                        <button type="button" class="login-page__signin__btn"><img src="assets/images/resources/facebook.png" alt="facebook"></button>
                    </div><!-- /.login-page__signin__buttons -->
                </div><!-- /.login-page__signin -->
            </div><!-- /.register-tab -->
        </div>
    </div>

@endsection