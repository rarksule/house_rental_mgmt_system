<x-app-layout>
    <div class="main-content">
        <div class="page-content">
            <div class="container">
                <div class="page-content-wrapper radius-20">
                    <div class="container-fluid px-4">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div
                                    class="page-title-box d-sm-flex align-items-center justify-content-between border-bottom mb-3">
                                    <div class="page-title-left">
                                        <h5 class="mb-sm-0 ms-1 fw-bold">{{ $pageTitle }}</h5>
                                    </div>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"
                                                    title="{{ __('message.dashboard') }}">{{ __('message.dashboard') }}</a>
                                            </li>
                                            <li class="breadcrumb-item">{{ __('message.owner.0') }}</li>
                                            <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(isset($house) && $house->id)
                            <form action="{{ route('owner.update', [$house->id]) }}" id="houseForm" novalidate method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                        @else
                            <form action="{{ route('owner.storeHouse') }}" id="houseForm" novalidate method="post"
                                enctype="multipart/form-data">
                                @csrf
                        @endif

                                <!-- Basic Information Section -->
                                <div class="card mb-4 border-0 shadow">
                                    <div class="card-body">
                                        <div class="mb-3 mt-3">
                                            <label for="name" class="form-label fw-bold">Title</label>
                                            <input type="text" class="form-control form-control-lg" id="name"
                                                name="name" placeholder="Title (Name)"
                                                value="{{ old('name', $house->name ?? '') }}" required>
                                            <div class="invalid-feedback">{{__("message.invalid",["form" => __("message.title")])}}</div>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="address" class="form-label fw-bold">house
                                                address</label>
                                            <input type="text" class="form-control form-control-lg" name="address"
                                                placeholder="house address" id="address"
                                                value="{{ old('address', $house->address ?? '') }}" required>
                                            <div class="invalid-feedback">{{__("message.invalid",["form" => __("message.location")])}}</div>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="description" class="form-label fw-bold">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="6"
                                                required>{{ old('description', $house->description ?? '') }}</textarea>
                                            <div class="invalid-feedback">{{__("message.invalid",["form" => __("message.description")])}}
                                            </div>
                                        </div>
                                        <h5 class="mt-3 fw-bold">Upload Images</h5>
                                        <input type="file" id="hidden-preview-container" name="images[]"
                                            class="form-control" multiple accept="image/*" style="display: none;"
                                            >


                                        <!-- Drag and drop area -->
                                        <div class="dropzone border-primary rounded p-4 text-center" id="myDropzone">
                                            <div class="dz-message needsclick">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                                <h5>Drop files here or click to upload</h5>
                                                <span class="text-muted">Upload up to 5 images (Max size: 2MB
                                                    each)</span><br>
                                                <span>or</span><br>

                                                <button type="button" class="btn btn-primary mt-2">Select File</button>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">{{__("message.invalid",["form" => __("message.images")])}}
                                        </div>

                                        <!-- Image preview container -->
                                        <div class="mt-4" id="imagePreviewContainer" style="display: none;">
                                            <h6 class="mb-3">Preview:</h6>
                                            <div class="row overflow-md-visible" id="imagePreviews">
                                                @if (isset($house))
                                                    @foreach($house->getMedia('images') as $image)
                                                        <div class="col-auto position-relative mb-3">
                                                            <div
                                                                class="image-preview-wrap rounded position-relative image-container">
                                                                <img class="img-fluid rounded img-thumbnail"
                                                                    src="{{ $image->getUrl() }}"
                                                                    style="width: 170px; height: 120px; object-fit: cover;">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image"
                                                                    data-house-id="{{ $house->id }}"
                                                                    data-media-id="{{ $image->id }}">
                                                                    &times;
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <!-- Preview items will be added dynamically here -->
                                            </div>
                                        </div>
                                        @error('images')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                        @error('images.*')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Location Section -->
                                <div class="card mb-4 border-0 shadow">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="latitude" class="form-label fw-bold">Latitude</label>
                                                <input type="text" class="form-control" id="latitude" name="latitude"
                                                    placeholder="Ex: 1.462260"
                                                    value="{{ old('latitude', $house->latitude ?? '') }}" required>
                                                <div class="invalid-feedback">{{__("message.invalid",["form" => __("message.latitude")])}}
                                                </div>
                                                <a href="https://www.latlong.net/" target="blank"><small
                                                        class="text-muted">Go here to get Latitude from
                                                        address</small></a>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="longitude" class="form-label fw-bold">Longitude</label>
                                                <input type="text" class="form-control" id="longitude" name="longitude"
                                                    placeholder="Ex: 103.812530"
                                                    value="{{ old('longitude', $house->longitude ?? '') }}" required>
                                                <div class="invalid-feedback">{{__("message.invalid",["form" => __("message.longtiude")])}}
                                                </div>
                                                <a href="https://www.latlong.net/" target="blank"><small
                                                        class="text-muted">Go here to get Longitude from
                                                        address.</small></a>
                                            </div>
                                        </div>

                                        <h5 class="fw-bold mt-4 mb-3">house Details</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="rooms" class="form-label fw-bold">Number rooms</label>
                                                <input type="number" class="form-control" id="rooms" name="rooms"
                                                    min="0" value="{{ old('rooms', $house->rooms ?? '') }}" required>
                                                <div class="invalid-feedback">{{__("message.invalid",["form" => __("message.rooms")])}}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="area" class="form-label fw-bold">area in (m²)</label>
                                                <input type="number" class="form-control" id="area" name="area" min="0"
                                                    value="{{ old('area', $house->area ?? '') }}" required>
                                                <div class="invalid-feedback">{{__("message.invalid",["form" => __("message.area")])}}</div>
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3 mt-3">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="tapWater"
                                                        name="tapWater" {{ old('tapWater', isset($house->tapWater) ? 'checked' : '') }}>
                                                    <label class="form-check-label" for="tapWater">Tap water
                                                        available</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="kitchen"
                                                        name="kitchen" {{ old('kitchen', isset($house->kitchen) ? 'checked' : '') }}>
                                                    <label class="form-check-label" for="kitchen">Kitchen</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="acceptMarried"
                                                        name="acceptMarried" {{ old('acceptMarried', isset($house->acceptMarried) ? 'checked' : '') }}>
                                                    <label class="form-check-label" for="acceptMarried">accept married
                                                        couple</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="hasDog"
                                                        name="hasDog" {{ old('hasDog', isset($house->hasDog) ? 'checked' : '') }}>
                                                    <label class="form-check-label" for="hasDog">I have Dog</label>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row g-3 mt-3 mb-3">
                                            <div class="col-md-6">
                                                <label for="price" class="form-label fw-bold">Price</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="price" name="price"
                                                        min="0" value="{{ old('price', $house->price ?? '') }}"
                                                        required>
                                                    <span class="input-group-text fs-6 bg-light">{{__("message.per")}}</span>
                                                    <div class="invalid-feedback">{{__("message.invalid",["form" => __("message.price")])}}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            <label for="visitor" class="form-label fw-bold">{{__('message.visited').' '.__('message.tenant').' '.__('message.email')}}</label>
                                                <input type="text" class="form-control form-control-lg"
                                                    name="visitor_email" placeholder="visitor"
                                                    id="visitor"
                                                    list="visitor"
                                                    value="{{ old('renter', isset($house->renter) ? $house->renter->name : '') }}">
                                                    <datalist id="visitor">
                                                        @foreach ($tenants as $tenant)
                                                        <option value="{{ $tenant->email }}">{{ $tenant->name }}</option>
                                                        @endforeach
                                                    </datalist>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information Section -->
                                <div class="card mb-4 border-0 shadow">

                                <div class="card-body">
                                    <div class="mb-3 ">
                                        <label for="privateNotes" class="form-label fw-bold">Private notes</label>
                                        <textarea class="form-control border-primary" id="privateNotes" name="privateNotes"
                                            rows="3">{{ old('privateNotes', $house->privateNotes ?? '') }}</textarea>
                                        <small class="text-muted">Private notes are only visible to owner. It wont be
                                            shown
                                            on the frontend.</small>
                                    </div>
                                        <div class="form-check form-switch ">
                                            <input class="form-check-input" type="checkbox" id="rented" name="rented" {{ old('rented', isset($house->rented) ? 'checked' : '') }}>
                                            <label class="form-check-label fw-bold h5" for="rented">Rented</label>
                                        </div>
                                        <div class="mb-1"  id="paymentDateContainer">
                                            <div class="row g-3 mt-3 mb-3">
                                            <div class="col-md-6">
                                                <label for="payment_date" class="form-label fw-bold">Payment Date</label>
                                                <input type="date" class="form-control form-control-lg"
                                                    name="payment_date" placeholder="payment_date"
                                                    id="payment_date"
                                                    value="{{ old('payment_date', isset($house->payment_date) ? $house->payment_date->format('Y-m-d') : '') }}">
                                                <div class="invalid-feedback">{{ __("message.invalid",["form" => __("message.date")])}}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="renter" class="form-label fw-bold">{{ __('message.tenant').' '.__('message.email') }}</label>
                                                <input type="text" class="form-control form-control-lg"
                                                    name="renter_email" placeholder="renter"
                                                    id="renter"
                                                    list="renters"
                                                    value="{{ old('renter', isset($house->renter) ? $house->renter->name : '') }}">
                                                    <datalist id="renters">
                                                        @foreach ($tenants as $tenant)
                                                        <option value="{{ $tenant->email }}">{{ $tenant->name }}</option>
                                                        @endforeach
                                                    </datalist>
                                                <div class="invalid-feedback">Please specify who rented.</div>
                                                
                                            
                                            </div>

                                            </div>
                                        </div>
                                        </div>
                                </div>

                                <!-- Footer Buttons -->
                                <div class="d-flex justify-content-end mb-5">
                                    <div>
                                        <button type="submit" class="btn btn-primary px-4 py-2 me-2">Save</button>
                                    </div>
                                </div>
                            </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            let dbImages = {{ isset($house) ? $house->getMedia('images')->count() : 0 }}
                        if (dbImages > 0) {
                document.getElementById('imagePreviewContainer').style.display = 'block';
            }
            document.querySelectorAll('.remove-image').forEach(button => {
                button.addEventListener('click', function () {
                    const houseId = this.getAttribute('data-house-id');
                    const mediaId = this.getAttribute('data-media-id');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                    // Confirm before deleting
                    if (confirm('Are you sure you want to delete this image from Database?')) {
                        $.ajax({
                            url: "{{ route('owner.deletemedia') }}", // You'll need to create this route
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                house_id: houseId,
                                media_id: mediaId,
                                _token: csrfToken
                            },
                            success: function (response) {
                                // Remove the image container from the DOM
                                button.closest('.col-auto').remove();
                                dbImages--;
                                toastr.success(response.message || 'Image deleted successfully');
                            },
                            error: function (xhr, status, error) {
                                toastr.error(xhr.responseJSON.message || 'Failed to delete image');
                            }
                        });
                    }
                });
            });
        </script>
        <script src="{{ asset('assets/js/house-form.js') }}"></script>
    @endpush


</x-app-layout>