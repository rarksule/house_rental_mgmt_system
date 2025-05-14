<x-app-layout>

    <div id="headless-wrapper">
        <div class="sign-up-page bg-white">
            <div class="container-fluid p-0">
                <div class="row sign-up-page-wrap-row">
                    <div class="col-md-6">
                        <div class="sign-up-right-content bg-white mx-4 card">
                            <form action="register" method="post">
                                @csrf
                                <h1 class="my-5">{{ __('message.sign_up') }}</h1>
                                <p class="font-16 mb-5">{{ __('message.already_have_account') }} <a
                                        href="{{ route('login') }}"
                                        class="secondary-color font-medium">{{ __('message.sign_in') }}</a></p>
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.first_name') }}
                                            <su style="color: red;"> *</su>
                                        </label>
                                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                                            class="form-control" required placeholder="{{ __('message.first_name') }}">
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.last_name') }}
                                            <su style="color: red;"> *</su>
                                        </label>
                                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                                            class="form-control" required placeholder="{{ __('message.last_name') }}">
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-md-8">

                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.contact_number') }}
                                            <su style="color: red;"> *</su>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text fs-6 bg-light border-dark">+251</span>
                                            <input type="text" class="form-control" required
                                                placeholder="{{ __('message.contact_number') }}" name="contact_number"
                                                value="{{ old('contact_number') }}">
                                        </div>
                                        @error('contact_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.register_as') }}
                                            <su style="color: red;"> *</su>
                                        </label>
                                        <select id="role" name="role" required class="form-control border-dark">
                                            <option value="{{ USER_ROLE_TENANT }}" {{ old('role') == USER_ROLE_TENANT ? 'selected' : '' }}>
                                                {{ __('message.tenant') }}
                                            </option>
                                            <option value="{{ USER_ROLE_OWNER }}" {{ old('role') == USER_ROLE_OWNER ? 'selected' : '' }}>
                                                {{ __('message.owner.0') }}
                                            </option>
                                        </select>
                                        @error('role')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-12">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.email') }}
                                            <su style="color: red;"> *</su>
                                        </label>
                                        <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                            required placeholder="{{ __('message.email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-md-12 mb-5">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.password') }}
                                            <su style="color: red;"> *</su>
                                        </label>
                                        <div class="form-group mb-0 position-relative">
                                            <input class="form-control" name="password" value="{{ old('password') }}"
                                                required placeholder="{{ __('message.password') }}" type="password">
                                        </div>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.confirm_password') }}
                                            <su style="color: red;"> *</su>
                                        </label>
                                        <div class="form-group mb-0 position-relative">
                                            <input class="form-control" name="password_confirmation"
                                                value="{{ old('password_confirmation') }}" required
                                                placeholder="{{ __('message.confirmation_password') }}" type="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary font-15 fw-bold w-100"
                                            title="{{ __('message.sign_up') }}">{{ __('message.sign_up') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <div class="sign-up-left-content position-relative text-center">
                            <div class="sign-up-bottom-img mb-5">
                                <img src="{{ getSettingImage('sign_in_image') }}" alt="app_name" class="img-fluid">
                            </div>
                            <h1 class="text-white">{{ __('message.sign_up_text_title') }}</h1>
                            <p class="mt-4 w-75 mx-auto">{{ __('message.sign_up_text_subtitle') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>