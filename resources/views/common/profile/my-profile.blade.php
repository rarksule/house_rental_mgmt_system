<x-app-layout>
    <!-- Right Content Start -->
    <div class="main-content">
        <div class="page-content">
            <div class="container">
                <!-- Page Content Wrapper Start -->
                <div class="page-content-wrapper bg-white p-4 radius-20">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div
                                class="page-title-box d-sm-flex align-items-center justify-content-between border-bottom mb-3">
                                <div class="page-title-left">
                                    <h3 class="mb-sm-0">{{ $pageTitle }}</h3>
                                </div>
                                <div class="page-title-right">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"
                                                title="{{ __('message.dashboard') }}">{{ __('message.dashboard') }}</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            {{ isAdmin() ? __('message.admin') : __('message.profile') }}</li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings-page-layout-wrap position-relative">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                <div class="account-settings-rightside bg-off-white theme-border rounded-3 p-4">
                                    <div class="language-settings-page-area">
                                        <div class="profile-page-content-area">
                                            @if (isset($user))
                                                <form action="{{ route('profile.update', $user->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @method('PATCH')
                                                @else
                                                    <form action="{{ route('admin.adduser') }}" method="POST"
                                                        enctype="multipart/form-data">
                                            @endif
                                            @csrf
                                            <div class="settings-inner-box bg-white theme-border rounded-3 mb-4">
                                                <div class="settings-inner-box-fields pb-0">
                                                    <div class="settings-inner-box-title border-bottom p-3">
                                                        <h4>{{ __('message.personal_information') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="settings-inner-box-fields p-3 pb-0">
                                                    <div class="row justify-content-between">
                                                        <div class="col-md-6 mb-4">
                                                            <!-- Upload Profile Photo Box Start -->
                                                            <div
                                                                class="upload-profile-photo-box upload-profile-photo-with-delete-btn mb-4">
                                                                <div
                                                                    class="profile-user position-relative d-inline-block">

                                                                    <img src="{{ isset($user) ? getSingleImage($user, 'profile_image') : asset('assets/images/user.png') }}"
                                                                        class="rounded-circle avatar-xl default-user-profile-image">

                                                                    <div
                                                                        class="avatar-xs p-0 rounded-circle default-profile-photo-edit">
                                                                        <input id="default-profile-img-file-input"
                                                                            type="file" name="profile_image"
                                                                            class="default-profile-img-file-input">
                                                                        <label for="default-profile-img-file-input"
                                                                            class="default-profile-photo-edit avatar-xs">
                                                                            <span class="avatar-title rounded-circle"
                                                                                title="Change Image">
                                                                                <i class="ri-camera-fill"></i>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        @if (!isAdmin())
                                                            <div class="col-md-3">
                                                                <button type="button"
                                                                    class="btn btn-outline-dark text-danger text-nowrap"
                                                                    id="deleteMyAccountBtn"
                                                                    title="{{ __('message.delete_account') }}">{{ __('message.delete_account') }}</button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-3"></div>
                                                        @endif
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.first_name') }}
                                                                <su style="color: red;"> *</su>
                                                            </label>
                                                            <input type="text" class="form-control" name="first_name"
                                                                placeholder="{{ __('message.first_name') }}" required
                                                                value="{{ old('first_name', isset($user) ? $user->first_name : '') }}">
                                                            @error('first_name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.last_name') }}
                                                                <su style="color: red;"> *</su>
                                                            </label>
                                                            <input type="text" class="form-control" name="last_name"
                                                                placeholder="{{ __('message.last_name') }}" required
                                                                value="{{ old('last_name', isset($user) ? $user->last_name : '') }}">
                                                            @error('last_name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.email') }}
                                                                <su style="color: red;"> *</su>
                                                            </label>
                                                            <input type="email" class="form-control" name="email"
                                                                placeholder="{{ __('message.email') }}" required
                                                                value="{{ old('email', isset($user) ? $user->email : '') }}"
                                                                {{ isAdmin() ? '' : 'readonly' }}>
                                                            @error('email')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.contact_number') }}
                                                                <su style="color: red;"> *</su>
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="contact_number"
                                                                placeholder="{{ __('message.contact_number') }}"
                                                                required
                                                                value="{{ old('contact_number', isset($user) ? $user->contact_number : '') }}">
                                                            @error('contact_number')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.greetings') }}</label>
                                                            <input type="text" class="form-control" name="greetings"
                                                                placeholder="{{ __('message.greetings') }}"
                                                                value="{{ old('greetings', isset($user) ? $user->greetings : '') }}">
                                                            @error('greetings')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.nid_number') }}</label>
                                                            <input type="text" class="form-control"
                                                                name="nid_number"
                                                                placeholder="{{ __('message.nid_number') }}"
                                                                value="{{ old('nid_number', isset($user) ? $user->nid_number : '') }}">
                                                            @error('nid_number')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        @if (isAdmin() && isset($role))
                                                            <div class="col-md-4 mb-4">
                                                                <label
                                                                    class="label-text-title color-heading font-medium mb-2">{{ __('message.new_password') }}</label>
                                                                <input type="password" name="password"
                                                                    class="form-control"
                                                                    value="{{ old('password') }}" id="new_password"
                                                                    placeholder="********" required>
                                                                @error('password')
                                                                    <span class="text-danger">{{ $message ?? '' }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-4 mb-4">
                                                                <label
                                                                    class="label-text-title color-heading font-medium mb-2">{{ __('message.confirm_password') }}</label>
                                                                <input type="password" name="password_confirmation"
                                                                    value="{{ old('password_confirmation') }}"
                                                                    class="form-control" id="confirm_password"
                                                                    placeholder="********" required>
                                                                <div id="confirm_password_error" class="text-danger"
                                                                    style="display: none;"></div>
                                                            </div>
                                                            <div class="col-md-4 mb-4">
                                                                <label
                                                                    class="label-text-title color-heading font-medium mb-2">{{ __('message.status') }}</label>
                                                                <select id="status" name="status"
                                                                    class="form-control border-dark">
                                                                    <option value={{ USER_STATUS_ACTIVE }}>
                                                                        {{ __('message.active') }}</option>
                                                                    <option value={{ USER_STATUS_INACTIVE }}>
                                                                        {{ __('message.inactive') }}</option>
                                                                </select>
                                                            </div>
                                                            <input type="hidden" name="role" class="form-control"
                                                                value="{{ $role }}" required>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="settings-inner-box bg-white theme-border rounded-3 mb-4">
                                                <div class="settings-inner-box-fields pb-0">
                                                    <div class="settings-inner-box-title border-bottom p-3">
                                                        <h4>{{ isOwner($user ?? null, $role ?? null) ? __('message.permanent_address') : __('message.previous_address') }}
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="settings-inner-box-fields p-3 pb-0">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.address') }}
                                                                <su style="color: red;"> *</su>
                                                            </label>
                                                            <input type="text" class="form-control" name="address"
                                                                placeholder="{{ __('message.address') }}"
                                                                {{ !isAdmin($user ?? null, $role ?? null) ? 'required' : '' }}
                                                                value="{{ old('address', isset($user) ? $user->address : '') }}">
                                                            @error('address')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.city') }}
                                                                <su style="color: red;"> *</su>
                                                            </label>
                                                            <input type="text" class="form-control" name="city"
                                                                placeholder="{{ __('message.city') }}"
                                                                {{ !isAdmin($user ?? null, $role ?? null) ? 'required' : '' }}
                                                                value="{{ old('city', isset($user) ? $user->city : '') }}">
                                                            @error('city')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.house_number') }}</label>
                                                            <input type="text" class="form-control"
                                                                name="house_number"
                                                                placeholder="{{ __('message.house_number') }}"
                                                                {{ !isAdmin($user ?? null, $role ?? null) ? 'required' : '' }}
                                                                value="{{ old('house_number', isset($user) ? $user->house_number : '') }}">
                                                            @error('house_number')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="settings-inner-box bg-white theme-border rounded-3 mb-4">
                                                <div class="settings-inner-box-fields pb-0">
                                                    <div class="settings-inner-box-title border-bottom p-3">
                                                        <h4>{{ __('message.other_information') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="settings-inner-box-fields p-3 pb-0">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.employment') }}
                                                                <su style="color: red;"> *</su>
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="employment"
                                                                placeholder="{{ __('message.employment') }}"
                                                                {{ isTenant($user ?? null, $role ?? null) ? 'required' : '' }}
                                                                value="{{ old('employment', isset($user) ? $user->employment : '') }}">
                                                            @error('employment')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.family_member') }}
                                                                <su style="color: red;"> *</su>
                                                            </label>
                                                            <input type="number" class="form-control"
                                                                name="family_member"
                                                                placeholder="{{ __('message.family_member') }}"
                                                                {{ isTenant($user ?? null, $role ?? null) ? 'required' : '' }}
                                                                value="{{ old('family_member', isset($user) ? $user->family_member : '') }}">
                                                            @error('family_member')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <label
                                                                class="label-text-title color-heading font-medium mb-2">{{ __('message.kids') }}
                                                                <su style="color: red;"> *</su>
                                                            </label>
                                                            <input type="number" class="form-control" name="kids"
                                                                placeholder="{{ __('message.kids') }}"
                                                                {{ isTenant($user ?? null, $role ?? null) ? 'required' : '' }}
                                                                value="{{ old('kids', isset($user) ? $user->kids : '') }}">
                                                            @error('kids')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-4 d-flex justify-content-end">
                                                    <button type="submit" class="theme-btn"
                                                        title="{{ isset($user) ? __('message.update') : __('message.save') }}">{{ isset($user) ? __('message.update') : __('message.save') }}</button>
                                                </div>
                                            </div>
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
    </div>

    @if (isset($user))
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header">
                        <h4 class="modal-title" id="deleteModalLabel">{{ __('message.information') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="iconify" data-icon="akar-icons:cross"></span>
                        </button>
                    </div>
                    <form action="{{ route('delete-my-account') }}" method="POST" autocomplete="off"
                        data-handler="getShowMessage">
                        <div class="modal-body">
                            @csrf
                            <div class="modal-inner-form-box">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <p>Please type your email of this account <span
                                                class="fw-bold">({{ $user->email }})</span> to confirm its deletion
                                            from this application. After successful deletion, you can't recover this
                                            account.</p>
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.email') }}
                                            <strong class="text-danger">*</strong></label>
                                        <input type="text" class="form-control" name="email" autocomplete="off"
                                            placeholder="{{ __('message.email') }}">
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label
                                            class="label-text-title color-heading font-medium mb-2">{{ __('message.password') }}
                                            <strong class="text-danger">*</strong></label>
                                        <input type="password" class="form-control" name="password"
                                            placeholder="{{ __('message.password') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="theme-btn-back me-3" data-bs-dismiss="modal"
                                title="{{ __('message.back') }}">{{ __('message.back') }}</button>
                            <button type="submit" class="theme-btn me-3"
                                title="{{ __('message.delete') }}">{{ __('message.delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @push('script')
        <script>
            document.getElementById('passwordForm').addEventListener('submit', function(e) {
                const password = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                const errorElement = document.getElementById('confirm_password_error');

                if (password !== confirmPassword) {
                    e.preventDefault(); // Prevent form submission
                    errorElement.style.display = 'block';
                    errorElement.textContent = 'Passwords do not match';
                } else {
                    errorElement.style.display = 'none';
                }
            });
            document
                .querySelector("#default-profile-img-file-input")
                .addEventListener("change", function() {
                    var o = document.querySelector(".default-user-profile-image"),
                        e = document.querySelector(".default-profile-img-file-input").files[0],
                        i = new FileReader();
                    i.addEventListener(
                            "load",
                            function() {
                                o.src = i.result;
                            },
                            !1
                        ),
                        e && i.readAsDataURL(e);
                });
            $('#deleteMyAccountBtn').on('click', function() {
                var selector = $('#deleteModal');
                selector.find('.is-invalid').removeClass('is-invalid');
                selector.find('.error-message').remove();
                selector.find('form').trigger('reset');
                selector.modal('show')
            })
        </script>
    @endpush
</x-app-layout>
