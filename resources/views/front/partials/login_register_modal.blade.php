@php
    $urlToUse = url()->current();
@endphp
<!-- Login Modal -->
<div class="modal fade login-register" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollabl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Log In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ec-login-wrapper">
                    <div class="ec-login-container">
                        <div class="ec-login-form">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                @if($urlToUse === route('basket.index'))
                                    <input type="hidden" name="redirect_url" value="{{ $urlToUse }}">
                                @endif
                                <span class="ec-login-wrap">
                                    <label>Email Address <span class="text-danger">*</span></label>
                                    <input type="text" name="email" placeholder="Enter your email add..."
                                           class="@error('email') is-invalid @enderror" required/>
                                    @error('email')
                                        <span class="invalid-feedback text-danger text-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-login-wrap">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" placeholder="Enter your password"
                                           class="@error('password') is-invalid @enderror" required/>
                                    @error('password')
                                        <span class="invalid-feedback text-danger text-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-login-wrap ec-login-fp">
                                    <label><a href="{{ route('password.request') }}">Forgot Password?</a></label>
                                </span>
                                <span class="ec-login-wrap ec-login-btn">
                                    <button class="btn btn-primary">Login</button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <p>New to YansPrint?</p>
                <button id="createAccountBtn" class="btn btn-outline-primary w-100 mb-4">CREATE A NEW ACCOUNT</button>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade login-register" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">First Time Here?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Create an account to get updates on your order.</p>
                <div class="ec-register-wrapper">
                    <div class="ec-register-container">
                        <div class="ec-register-form">
                            <form action="{{ route('register') }}" method="post" id="register_form">
                                @csrf
                                <span class="ec-register-wrap ec-register-wrap">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" placeholder="Enter your first name"
                                           class="@error('first_name') is-invalid @enderror" required/>
                                    @error('first_name')
                                        <span class="invalid-feedback text-danger text-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-register-wrap ec-register-wrap">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" placeholder="Enter your last name"
                                           class="@error('last_name') is-invalid @enderror" required/>
                                    @error('last_name')
                                        <span class="invalid-feedback text-danger text-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-register-wrap">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="@error('phone') is-invalid @enderror"
                                           id="phone" required/>
                                     <div class="invalid-feedback error-msg">
                                        Please enter valid phone number.
                                    </div>
                                    @error('phone')
                                        <span class="invalid-feedback text-danger text-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-register-wrap">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" placeholder="Enter your email address"
                                           class="@error('email') is-invalid @enderror" required/>
                                    @error('email')
                                        <span class="invalid-feedback text-danger text-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" placeholder="Password"
                                           class="@error('password') is-invalid @enderror" required/>
                                    @error('password')
                                       <span class="invalid-feedback text-danger text-bold" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Password confirmation <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation"
                                           placeholder="Password confirmation" required/>
                                </span>
                                @error('password')
                                    <span class="invalid-feedback text-danger text-bold" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                                <span class="ec-register-wrap ec-register-btn">
                                    <button class="btn btn-primary">Register</button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <p class="text-muted">
                    Already have an account? <a id="loginBtn" class="font-italic text-reset text-decoration-underline"
                                                href="#">Log In</a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#createAccountBtn').on('click', function () {
                $('#loginModal').modal('hide');
                $('#registerModal').modal('show');
            });
            $('#loginBtn').on('click', function () {
                $('#loginModal').modal('show');
                $('#registerModal').modal('hide');
            });
        });
    </script>
@endpush
