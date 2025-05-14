<x-app-layout>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-content-wrapper bg-white p-4 radius-20">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-header text-primary">
                                    <h5 class="mb-0">
                                        <i class="fas fa-cog"> </i>{{ __('message.manage_policy') }}
                                    </h5>
                                </div>

                                <div class="card-body">
                                    <!-- Policy Content Tabs -->
                                    <ul class="nav nav-tabs mb-4" id="policyTabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active text-secondary" id="privacy-tab" data-toggle="tab"
                                                href="#privacy" role="tab" aria-controls="privacy" aria-selected="true">
                                                {{ __('message.privacy') }}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-secondary" id="cookie-tab" data-toggle="tab" href="#cookie"
                                                role="tab" aria-controls="cookie" aria-selected="false">
                                                {{ __('message.cookie') }}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-secondary" id="terms-tab" data-toggle="tab" href="#terms"
                                                role="tab" aria-controls="terms" aria-selected="false">
                                                {{ __('message.term_cond') }}
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <form method="POST" action="{{ route('admin.policy') }}" id="policyForm">
                                        @csrf
                                        @method('PUT')

                                        <div class="tab-content" id="policyTabsContent">
                                            <!-- Privacy Policy -->
                                            <div class="tab-pane fade show active" id="privacy" role="tabpanel"
                                                aria-labelledby="privacy-tab">
                                                <div class="form-group">
                                                    <label for="privacy_policy">{{__('message.content',['form'=>__('message.privacy')])}}</label>
                                                    <textarea class="form-control" id="privacy_policy"
                                                        name="privacy_policy"
                                                        rows="10">{{ old('privacy_policy', $setting->privacy_policy ?? '') }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Cookie Policy -->
                                            <div class="tab-pane fade" id="cookie" role="tabpanel"
                                                aria-labelledby="cookie-tab">
                                                <div class="form-group">
                                                    <label for="cookie_policy">{{__('message.content',['form'=>__('message.cookie')])}}</label>
                                                    <textarea class="form-control" id="cookie_policy"
                                                        name="cookie_policy"
                                                        rows="10">{{ old('cookie_policy', $setting->cookie_policy ?? '') }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Terms & Conditions -->
                                            <div class="tab-pane fade" id="terms" role="tabpanel"
                                                aria-labelledby="terms-tab">
                                                <div class="form-group">
                                                    <label for="terms_conditions">{{__('message.content',['form'=>__('message.term_cond')])}}</label>
                                                    <textarea class="form-control" id="terms_conditions"
                                                        name="terms_conditions"
                                                        rows="10">{{ old('terms_conditions', $setting->terms_conditions ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-5">
                                            <i class="fas fa-save"></i> {{ __('message.save_policy') }}
                                        </button>
                                    </form>

                                    <hr class="my-5">

                                    <!-- Language Toggles -->
                                    <h5 class="mb-3">
                                        <i class="fas fa-language"></i> {{ __('message.language_settings') }}
                                    </h5>

                                    <form method="POST" action="{{ route('admin.language') }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>{{__('message.language')}}</th>
                                                        <th>{{__('message.language_code')}}</th>
                                                        <th>{{__('message.status')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($languages as $language)
                                                        <tr>
                                                            <td>{{ $language->name }}</td>
                                                            <td>{{ $language->code }}</td>
                                                            <td>
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="language-{{ $language->id }}"
                                                                        name="languages[{{ $language->id }}]" {{ $language->status ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="language-{{ $language->id }}"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> {{ __('message.save_language') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            const array = ['textarea#terms_conditions', 'textarea#cookie_policy', 'textarea#privacy_policy']
            array.forEach(element => {
                tinymce.init({
                    selector: element,  // change this value according to your HTML
                    plugins: ['advlist', 'lists', 'charmap', 'anchor', 'searchreplace', 'fullscreen', 'insertdatetime', 'wordcount'],
                    toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
                    a_plugin_option: true,
                    a_configuration_option: 400
                });
            });

            // Initialize tabs if they're not working automatically
            $(document).ready(function () {
                // Initialize tab functionality
                $('#policyTabs a').on('click', function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });

                // Handle form submission
                $('form#policyForm').on('submit', function (e) {
                    // Get the active textarea
                    const activeTextarea = $('.tab-pane.active textarea');
                    const activeTabId = $('.tab-pane.active').attr('id');

                    // Check if active textarea is empty
                    if (!activeTextarea.val().trim()) {
                        e.preventDefault(); // Prevent form submission

                        // Show error message
                        activeTextarea.addClass('is-invalid');
                        activeTextarea.after('<div class="invalid-feedback">This field is required</div>');

                        // Scroll to the error
                        $('html, body').animate({
                            scrollTop: activeTextarea.offset().top - 100
                        }, 300);

                        // Highlight the corresponding tab
                        $(`#${activeTabId}-tab`).addClass('text-danger');

                        return false;
                    }

                    // Clear any existing errors if validation passes
                    activeTextarea.removeClass('is-invalid');
                    $(`.invalid-feedback`).remove();
                    $(`#${activeTabId}-tab`).removeClass('text-danger');

                    return true;
                });

                // Clear validation when user starts typing
                $('textarea').on('input', function () {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                    $(`#${$(this).closest('.tab-pane').attr('id')}-tab`).removeClass('text-danger');
                });
            });
        </script>
    @endpush
</x-app-layout>