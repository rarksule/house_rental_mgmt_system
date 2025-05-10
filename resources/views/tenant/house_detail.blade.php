<x-app-layout>
    <div class="property-header">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="display-4">{{$house->address}}</h1>
                    <p class="lead text-muted">{{$house->address}}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <h2 class="text-primary display-6">{{$house->price}}<small class="text-muted">/ Month</small></h2>
                    <div class="mt-3">
                        <button class="{{tourRequested() ? 'btn btn-success' : 'btn btn-outline-secondary' }} me-2"
                            id="req-tour"><i
                                class="me-1"></i>{{tourRequested() ? __('message.reqd_tour') : __('message.req_tour')}}</button>
                        <!-- Your existing button -->


                        <!-- Hidden form that will be submitted -->
                        <form id="tour-request-form" action="{{ route('messagesSend') }}" method="POST"
                            style="display: none;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $house->owner->id }}">
                            <input type="hidden" name="content" value="Let me see the house in person">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Main Content Row -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">

                <div class="container-fluid p-0">
                    {{-- First Row (40% height) --}}
                    <div class="row gx-1 mx-3 mb-2" style="height: 40vh;">
                        @for ($i = 0; $i < 2; $i++)
                            <div class="col-6 h-100">
                                <img src="{{ getAllMedia($house)[$i] ?? noImage() }}" alt="House image"
                                    class="img-fluid rounded w-100 h-100" style="object-fit: cover;">
                            </div>
                        @endfor

                    </div>

                    <div class="row gx-1 mx-3" style="height: 30vh;">
                        @for ($i = 2; $i < 5; $i++)
                            <div class="col-4 h-100">
                                <img src="{{ getAllMedia($house)[$i] ?? noImage() }}" alt="House image"
                                    class="img-fluid rounded w-100 h-100" style="object-fit: cover;">
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Description Section -->
                <section class="my-5">
                    <h2 class="mb-4">Description</h2>
                    <p>{!! $house->description !!}</p>
                </section>

                <!-- Amenities Section -->
                <section class="mb-5">
                    <h2 class="mb-4">Amenities</h2>
                    <div class="row">


                        <div class="col-md-6">
                            <ul class="amenities-list">
                                @foreach ($house->amenities as $key => $value)
                                    <li><i
                                            class="{{$value ? 'bi bi-check-circle text-success me-2' : 'bi bi-x-circle text-danger me-2'}}"></i>
                                        {{$key}}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </section>
                <form action="{{ route('tenant.rate') }}" method="post">
                    @csrf
                    <div class="rating-container mb-4">
                        <h4>{{__('message.rate_this')}}</h4>

                        <!-- Star Rating -->
                        <div class="star-rating mb-3 h2 property-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}">
                                    <i class="far fa-star"></i>
                                </span>
                            @endfor
                            <input type="hidden" name="rating" class="form-control" id="rating-value" value="0">
                        </div>
                        <input type="hidden" name="id" class="form-control" value="{{ $house->id}}">
                        <!-- Comment Form -->
                        <div class="mb-3">
                            <label for="comment" class="form-label">Your Review</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"
                                placeholder="Share your experience..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submit-rating">Submit Review</button>
                    </div>

                </form>

                <!-- Reviews Section -->
                <section class="mb-5">
                    <h2 class="mb-4">{{__('message.review')}}</h2>
                    @foreach ($house->reviews as $review)
                        <div class="card review-card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <h5 class="card-title">{{$review->tenant->first_name}}</h5>
                                    <small class="text-muted">{{timeAgo($review->created_at)}}</small>
                                </div>
                                <div class="mb-3 property-rating">
                                    @for ($i = 1; $i <= $review->rating; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor

                                    @for ($i = 5; $i > $review->rating; $i--)
                                        <i class="far fa-star"></i>
                                    @endfor

                                    <span class="ms-1">({{ $review->rating }} /5)</span>
                                </div>
                                <p class="card-text">{{$review->comment}}</p>


                                @if($review->replies->count() > 0 || isAdmin())
                                    <button class="btn btn-sm btn-link p-0 text-decoration-none mt-2" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#replies-{{$review->id}}">
                                        <i class="fas fa-reply me-1"></i> {{$review->replies->count()}}
                                        {{__('message.reply')}}
                                    </button>

                                    <div class="collapse mt-2" id="replies-{{$review->id}}">
                                        @foreach($review->replies as $reply)
                                            <div class="card bg-light mb-2">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <strong>{{ $reply->user->name }}</strong>
                                                        <small class="text-muted">{{timeAgo($reply->created_at)}}</small>
                                                    </div>
                                                    <p class="mb-0">{{$reply->content}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if(isAdmin())
                                            <div class="mt-2">
                                                <form action="{{ route('admin.reply') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="review_id" value="{{$review->id}}">
                                                    <div class="mb-2">
                                                        <textarea class="form-control form-control-sm" name="content" rows="2"
                                                            required></textarea>
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-sm btn-primary">{{__('message.save')}}</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </section>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Agent Info -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="mb-4 me-0">{{__('message.owner.contact')}}</h3>
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{getSingleImage($house->owner, 'profile_image')}}" alt="Owner photo"
                                class="rounded-circle me-3" style="height:100px; width=100px">
                            <div class="text-start">
                                <h5 class="mb-0">{{$house->owner->name}}</h5>
                                <p><i class="bi bi-telephone me-2"></i>{{$house->owner->contact_number}}</p>
                            </div>
                        </div>
                        <p class="card-text">{{ $house->owner->greeting }}</p>
                        <form action="{{Auth::check() ? route('messagesSend') : route('login')}}"
                            method="{{Auth::check() ? 'post' : 'get' }}">
                            @csrf
                            <div class="my-3">
                                <label for="message" class="form-label">{{__('message.message')}}*</label>
                                <textarea class="form-control" name="content" placeholder="Type your message..."
                                    required id="message" rows="3"></textarea>
                            </div>
                            <input type="hidden" value="{{ $house->owner->id }}" name="id">
                            <button type="submit"
                                class="btn btn-primary w-100">{{Auth::check() ? __('message.send_msg') : __('message.Sign_sendmsg')}}</button>

                        </form>
                    </div>
                </div>

                <!-- Location Map -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{__('message.location')}}</h5>
                        <div class="ratio ratio-16x9 mb-3">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d417.5002754813755!2d{{ $house->latitude }}!3d{{ $house->longitude }}!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2sus!4v1745454877797!5m2!1sen!2sus"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <p class="card-text">{{$house->address}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')

        <script>
            const tourRequested = {{ tourRequested() }}
                    const isTenant = {{ isTenant() }}
                document.getElementById('req-tour').addEventListener('click', function (e) {

                    e.preventDefault();
                    if (!isTenant || tourRequested) {
                        return;
                    }
                    // Optional: Add loading state
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

                    // Submit the hidden form
                    document.getElementById('tour-request-form').submit();
                });
        </script>
        <script src="{{ asset('assets/js/rateme.js') }}"></script>
    @endpush
</x-app-layout>