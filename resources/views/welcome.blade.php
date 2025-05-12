<x-app-layout>
    <div class="welcome">
        <section class="hero-section">
            <div class="container text-center">
                <h1 class="display-4 fw-bold mb-4">{{__('message.find_home')}}</h1>
                <p class="lead mb-5">{{__('message.offer')}}</p>


                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h1 class="text-center mb-5">{{__('message.accesable')}}</h1>
                        <form action="{{ route('home') }}" method="get">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h3 class="card-title mb-4">{{__('message.search.location')}}</h3>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="address"
                                                placeholder="{{__('message.search.neighbor')}}"
                                                list="neighborhoodOptions">
                                            <button class="btn btn-primary"
                                                type="submit">{{__('message.search.0')}}</button>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('message.search.min_price') }}</label>
                                            <input type="number" class="form-control border-dark" name="min_price"
                                                value="{{ request('min_price') }}"
                                                placeholder="{{ __('message.search.no_min') }}" list="minPriceOptions"
                                                min="0">
                                            <datalist id="minPriceOptions">
                                                <option >2000</option>
                                                <option >2500</option>
                                                <option >3000</option>
                                                <option >3500</option>
                                            </datalist>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('message.search.max_price') }}</label>
                                            <input type="number" class="form-control border-dark" name="max_price"
                                                value="{{ request('max_price') }}"
                                                placeholder="{{ __('message.search.no_Max') }}" list="maxPriceOptions"
                                                min="0">
                                            <datalist id="maxPriceOptions">
                                                <option >2500</option>
                                                <option >5000</option>
                                                <option >7000</option>
                                                <option >10000</option>
                                            </datalist>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>


        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h1 class="fw-bold">{{__('message.explore')}}</h1>
                    <p class="text-muted">{{__('message.explore_text')}}</p>
                </div>

                <div class="row">
                    @foreach ($houses as $house)
                                        <div class="col-md-4 col-lg-3 my-4">
                                            <div class="card property-card h-100">
                                                <a href="{{ route('house_detail', ['id' => $house->id]) }}"
                                                    class="text-decoration-none text-reset stretched-link">

                                                    <div class="property-image">
                                                        <span><img src="{{getSingleImage($house)}}" alt="image"></span>
                                                    </div>
                                                    <div class="card-body">

                                                        <span class="property-type bg-danger mb-2 d-inline-block">Rent</span>
                                                        <h3>{{$house->price __("message.per")}} </h3>
                                                        <p class="text-muted">{{$house->address}}</p>
                                                        @php
                                                            $rating = $house->reviews->count() > 0 ? $house->reviews->avg('rating') : 0;
                                                            $filledStars = floor($rating);
                                                            $halfStar = $rating - $filledStars >= 0.4;
                                                            $emptyStars = 5 - $filledStars - ($halfStar ? 1 : 0);
                                                            $totalReviews = $house->reviews->count(); 
                                                        @endphp

                                                        <div class="mb-3 property-rating">
                                                            @for ($i = 1; $i <= $filledStars; $i++)
                                                                <i class="fas fa-star"></i>
                                                            @endfor

                                                            @if ($halfStar)
                                                                <i class="fas fa-star-half-alt"></i>
                                                            @endif

                                                            @for ($i = 1; $i <= $emptyStars; $i++)
                                                                <i class="far fa-star"></i>
                                                            @endfor

                                                            <span class="ms-1">({{ $totalReviews }} Reviews)</span>
                                                        </div>
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item"><i class="fas fa-faucet "></i>
                                                                {{$house->amenities['tap_water'] ?? ""}}</li>
                                                            <li class="list-inline-item"><i class="fas fa-home me-1"></i>
                                                                {{$house->amenities['rooms'] ?? ""}}</li>
                                                            <li class="list-inline-item"><i class="fas fa-chart-area"></i>
                                                                {{$house->amenities['area'] ?? ""}}</li>
                                                            <li class="list-inline-item"><i class="fas fa-dog"></i>
                                                                {{$house->amenities['dog'] ?? ""}}</li>
                                                        </ul>
                                                    </div>

                                                </a>
                                            </div>
                                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</x-app-layout>