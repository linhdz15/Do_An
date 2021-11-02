<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="login-box">
                    <div class="container-login100">
                        <div class="wrap-login100">
                            <form class="login100-form validate-form flex-sb flex-w">
                                <span class="login100-form-title p-b-30">
                                    Đăng nhập
                                </span>

                                @if (JoelButcher\Socialstream\Socialstream::show())
                                    @if (JoelButcher\Socialstream\Socialstream::hasFacebookSupport())
                                        <a href="{{ route('oauth.redirect', ['provider' => JoelButcher\Socialstream\Providers::facebook()]) }}" class="btn-face m-b-20">
                                            <i class="fa fa-facebook-official"></i>
                                            Facebook
                                        </a>
                                    @endif

                                    @if (JoelButcher\Socialstream\Socialstream::hasGoogleSupport())
                                        <a href="{{ route('oauth.redirect', ['provider' => JoelButcher\Socialstream\Providers::google()]) }}" class="btn-google m-b-20">
                                            <img src="{{ asset('images/icon-google.png') }}" alt="GOOGLE">
                                            Google
                                        </a>
                                    @endif
                                @endif

                                <div class="login100-pic m-auto">
                                    <img src="{{ asset('images/img-01.png') }}" alt="IMG">
                                </div>

                                <!-- <div class="p-t-31 p-b-9">
                                    <span class="txt1">
                                        Username
                                    </span>
                                </div>
                                <div class="wrap-input100 validate-input" data-validate = "Username is required">
                                    <input class="input100" type="text" name="username" >
                                    <span class="focus-input100"></span>
                                </div>

                                <div class="p-t-13 p-b-9">
                                    <span class="txt1">
                                        Password
                                    </span>

                                    <a href="#" class="txt2 bo1 m-l-5">
                                        Forgot?
                                    </a>
                                </div>
                                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                                    <input class="input100" type="password" name="pass" >
                                    <span class="focus-input100"></span>
                                </div>

                                <div class="container-login100-form-btn m-t-17">
                                    <button class="login100-form-btn">
                                        Sign In
                                    </button>
                                </div>

                                <div class="w-full text-center p-t-55">
                                    <span class="txt2">
                                        Not a member?
                                    </span>

                                    <a href="#" class="txt2 bo1">
                                        Sign up now
                                    </a>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
