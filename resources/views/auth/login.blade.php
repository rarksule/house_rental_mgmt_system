<x-app-layout>
    <div id="headless-wrapper">
        <section class="sign-up-page bg-white">
            <div class="container-fluid p-0">
                <div class="row sign-up-page-wrap-row">
                    <div class="col-md-6">
                        <div class="sign-up-right-content bg-white mx-4">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <h1 class="mb-4">{{ __('message.Sign In') }}</h1>
                                <p class="font-16 mb-5">{{ __('message.New User?') }} <a href="{{ route('register') }}"
                                        class="text-primary font-medium">{{ __('message.Sign Up') }}</a></p>

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.Email') }}</label>
                                        <input type="text" name="email" class="form-control email"
                                            value="{{ old('email') }}" placeholder="{{ __('message.Email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.Password') }}</label>
                                        <div class="form-group mb-0 position-relative">
                                            <input class="form-control password" name="password"
                                                value="{{ old('Password') }}"
                                                placeholder="{{ __('message.Password') }}" type="password">
                                            <span class="toggle fas fa-eye pass-icon" style="cursor: pointer;"></span>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6"><a href="#" id="forgotPassword"
                                            class="text-primary d-block text-start text-md-end"
                                            title="{{ __('message.Forgot Password?') }}">{{ __('message.Forgot Password?') }}</a>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <button type="submit" class=" btn btn-primary font-15 fw-bold w-100"
                                            title="{{ __('message.Sign In') }}">{{ __('message.Sign In') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <div class="sign-up-left-content position-relative text-center">
                            <div class="sign-up-bottom-img mb-4">
                                <img src="{{ getSettingImage() }}" alt="{{ 'app_logo' }}" class="img-fluid">
                            </div>
                            <h1 class="text-white">{{ __('message.sign_in_text_title') }}</h1>
                            <p class="mt-4 w-75 mx-auto">{{ __('message.sign_in_text_subtitle') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h4 class="modal-title" id="forgotPasswordModalLabel">{{ __('message.Forgot Password?') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="iconify" data-icon="akar-icons:cross"></span>
                    </button>
                </div>
                <form action="{{ route('resetpassword') }}" method="POST" id="resetPasswordForm">
                    <div class="modal-body">
                        @csrf
                        <div class="modal-inner-form-box">
                            <div class="row justify-content-start">
                                <div class="mb-4 col-12">
                                    <p>{{ __('message.reset_password_note') }}</p>
                                </div>

                                <div class="col-md-12 input-group mb-4 ">
                                    <span class="input-group-text fs-6 bg-light border-dark">+251</span>
                                    <input type="text" class="form-control" name="phone" autocomplete="off"
                                        id="phone" placeholder="{{ __('message.contact_number') }}" required>
                                    <button class="btn btn-primary" id="getCode"
                                        type="button">{{ __('message.get_code') }}</button>
                                </div>

                                <div id="OTP-field" style="display: none;">
                                    <div class="col-md-12 mb-4">
                                        <div class="mb-4 d-flex justify-content-between">
                                            @for ($i = 0; $i < 6; $i++)
                                                <input type="text" name="otp[]" maxlength="1"
                                                    class="form-control text-center me-1"
                                                    style="width: 3rem; height: 3rem; font-size: 1.5rem;" required>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.new_password') }}</label>
                                        <input type="password" name="password" class="form-control" id="new_password"
                                            placeholder="********" required>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.confirm_password') }}</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="confirm_password" placeholder="********" required>
                                        <div id="confirm_password_error" class="text-danger" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-outline-dark me-3" data-bs-dismiss="modal"
                            title="{{ __('message.back') }}">{{ __('message.back') }}</button>
                        <button type="submit" class="btn btn-primary me-3" id="verify" style="display:none"
                            title="Verify OTP">{{ __('message.verify_otp') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
                const errorElement = document.getElementById('confirm_password_error');

                if (new_password.value !== confirm_password.value) {
                    e.preventDefault(); // Prevent form submission
                    errorElement.style.display = 'block';
                    errorElement.textContent = 'Passwords do not match';
                } else {
                    errorElement.style.display = 'none';
                }
            });
            $('#forgotPassword').on('click', function() {
                var selector = $('#forgotPasswordModal');
                selector.find('.is-invalid').removeClass('is-invalid');
                selector.find('.error-message').remove();
                selector.find('form').trigger('reset');
                selector.modal('show')
            })
        </script>
        <script>
            let timerDuration = 60;
            let currentTimer = timerDuration;
            const new_password = document.getElementById('new_password');
            const confirm_password = document.getElementById('confirm_password');
            const getCodeBtn = document.getElementById('getCode'); // Fixed variable name (was 'getCode')
            const phoneInput = document.getElementById('phone'); // Get phone input field
            const verifyBtn = document.getElementById('verify');
            const OTPField = document.getElementById('OTP-field');

            function startTimer() {
                timerInterval = setInterval(() => {
                    currentTimer--;
                    if (currentTimer <= 0) {
                        clearInterval(timerInterval);
                        getCodeBtn.disabled = false;
                    }
                }, 1000);
            }

            // Function to send OTP request
            function sendOtpRequest() {
                const phoneNumber = phoneInput.value.trim();
                if (!phoneNumber) {
                    toastr.error("@lang('message.invalid_phone')");
                    return;
                }
                if (phoneNumber.length != 9) {
                    toastr.error("@lang('message.phone')");
                    return;
                }

                currentTimer = timerDuration;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                $.ajax({
                    url: "{{ route('sendotp') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        phone: phoneNumber,
                        _token: csrfToken
                    },
                    success: function(response) {
                        toastr.success(response);
                        console.log('OTP code sent to the user.');
                        getCodeBtn.disabled = true;
                        new_password.style.display = 'inline-block';
                        confirm_password.style.display = 'inline-block';
                        OTPField.style.display = 'inline-block';
                        verifyBtn.style.display = 'inline-block';
                        startTimer();
                    },
                    error: function(xhr, status, error) {
                        toastr.error(error);
                        console.error('Failed to send OTP code.');
                    }
                });
            }



            // Original button click event (optional, keep if you still want manual trigger)
            getCodeBtn.addEventListener('click', function() {
                sendOtpRequest();
            });


            const otpInputs = document.querySelectorAll('input[name="otp[]"]');
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
