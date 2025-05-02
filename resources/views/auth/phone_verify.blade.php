<x-app-layout>
    <div id="headless-wrapper">
        <section class="sign-up-page bg-white">
            <div class="container-fluid p-0">
                <div class="row sign-up-page-wrap-row">
                    <div class="col-md-8">
                        <div class="sign-up-right-content bg-white mx-4">
                            <div class="container py-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">

                                        <div class="card p-4 shadow-sm d-flex justify-content-between">
                                            <h2 class="mb-3 text-center h2">Verify Your Phone Number</h2>
                                            <p class="text-center text-muted mb-4">Please enter the OTP sent to your
                                                phone number.</p>

                                            <form method="POST" action="{{ route('otpverify') }}" id="otpForm">
                                                @csrf

                                                <!-- Phone Number Field -->
                                                <div class="mb-4">
                                                    <label class="form-label">Phone Number</label>

                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-dark">+251</span>
                                                        <input type="text" class="form-control" id="phone" name="phone"
                                                            value="{{ $phone }}" readonly>
                                                    </div>
                                                </div>


                                                <!-- OTP Input Fields -->
                                                <div class="mb-4 d-flex justify-content-between">
                                                    @for ($i = 0; $i < 6; $i++)
                                                        <input type="text" name="otp[]" maxlength="1"
                                                            class="form-control text-center me-1"
                                                            style="width: 3rem; height: 3rem; font-size: 1.5rem;" required>
                                                    @endfor
                                                </div>

                                                <div class="d-grid mb-3">
                                                    <button type="submit" class="btn btn-success">Verify OTP</button>
                                                </div>

                                                <!-- Timer and Resend -->
                                                <div class="text-center mt-3">
                                                    <p class="text-muted" id="timerText">Didn't receive code? Wait <span
                                                            id="timer">60</span>s</p>
                                                    <button type="button" class="btn btn-link p-0" id="resendBtn"
                                                        style="display: none;">Resend Code</button>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-block">
                        <div class="sign-up-left-content position-relative text-center">
                            <div class="sign-up-bottom-img mb-25">
                                <img src="{{ getSettingImage('sign_in_image') }}" alt="{{ 'app_name' }}"
                                    class="img-fluid">
                            </div>
                            <h1 class="text-white">{{ __('message.sign_in_text_title') }}</h1>
                            <p class="mt-25 w-75 mx-auto">{{ __('message.sign_in_text_subtitle') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('script')

        <script>
            let timerDuration = 60;
            let currentTimer = timerDuration;
            let timerInterval = null;

            const timerElement = document.getElementById('timer');
            const timerText = document.getElementById('timerText');
            const resendBtn = document.getElementById('resendBtn');
            startTimer();
            function startTimer() {
                timerElement.textContent = currentTimer;
                timerInterval = setInterval(() => {
                    currentTimer--;
                    timerElement.textContent = currentTimer;

                    if (currentTimer <= 0) {
                        clearInterval(timerInterval);
                        timerText.style.display = 'none';
                        resendBtn.style.display = 'inline-block';
                    }
                }, 1000);
            }

            resendBtn.addEventListener('click', function () {

                resendBtn.style.display = 'none';
                timerText.style.display = 'block';
                currentTimer = timerDuration;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                // Simulate sending OTP code to the user
                $.ajax({
                    url: "{{ route('sendotp') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        phone: $('#phone').val(),
                        _token: csrfToken // You can include it in data too for compatibility
                    },
                    success: function (response) {
                        toastr.success(response);
                        console.log('OTP code sent to the user.');
                        getCodeBtn.style.display = 'none';
                    },
                    error: function (xhr, status, error) {
                        console.error('Failed to send OTP code.');
                    }
                });
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