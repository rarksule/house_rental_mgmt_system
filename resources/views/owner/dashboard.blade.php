<x-app-layout>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-content-wrapper bg-white p-30 radius-20">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <div class="page-title-left">
                                    <h2 class="mb-sm-0">{{ __('message.dashboard') }}</h2>
                                    <p>{{ __('message.welcome_back') }}, {{ auth()->user()->name }} <span class="iconify font-24"
                                            data-icon="openmoji:waving-hand"></span></p>
                                </div>
                                <div class="page-title-right">
                                    <a href="{{ route('owner.addHouse') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i>{{' '. __('message.add_house') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-4 col-xl-4">
                            <div class="dashboard-feature-item bg-off-white theme-border radius-4 p-20 mb-25">
                                <div
                                    class="dashboard-feature-item-icon-wrap font-20 d-flex align-items-center justify-content-center bg-white radius-4">
                                    <span class="iconify orange-color" data-icon="bxs:home-circle"></span>
                                </div>
                                <p class="mt-2">{{ __('message.Total_houses') }}</p>
                                <h2 class="mt-1">{{ $totalProperties }}</h2>

                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-4">
                            <div class="dashboard-feature-item bg-off-white theme-border radius-4 p-20 mb-25">
                                <div
                                    class="dashboard-feature-item-icon-wrap font-20 d-flex align-items-center justify-content-center bg-white radius-4">
                                    <span class="iconify orange-color" data-icon="bi:bar-chart-line-fill"></span>
                                </div>
                                <p class="mt-2">{{ __('message.Total_Tenant') }}</p>
                                <h2 class="mt-1">{{ $totalTenants }}</h2>

                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-4">
                            <div class="dashboard-feature-item bg-off-white theme-border radius-4 p-20 mb-25">
                                <div
                                    class="dashboard-feature-item-icon-wrap font-20 d-flex align-items-center justify-content-center bg-white radius-4">
                                    <span class="iconify green-color" data-icon="material-symbols:patient-list"></span>
                                </div>
                                <p class="mt-2">{{ __('message.tenant_lead') }}</p>
                                <h2 class="mt-1">{{ $tenantLead }}</h2>
                            </div>
                        </div>
                    </div>
                    <!-- dashboard-feature-item row -->

                    <!-- Chart row -->
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xl-12">
                            <div class="bg-off-white radius-4 mb-25 theme-border p-20 w-100">
                                <div class="bg-transparent">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h4 class="mb-0">{{ __('message.rent_revenue') }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <h2>{{ $revenue }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div id="chart1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Chart row -->

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="dashboard-properties-table bg-off-white theme-border p-20 radius-4 mb-25">
                                <div class="">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-between mb-25">
                                                <h4 class="mb-0">{{ __('message.upcoming_rent') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table theme-border p-20">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('message.name') }}</th>
                                                            <th>{{ __('message.phone') }}</th>
                                                            <th>{{ __('message.price') }}</th>
                                                            <th>{{ __('message.due_date') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($renters as $renter)
                                                            <tr>
                                                                <td>
                                                                    <h6 class="theme-text-color">{{ $renter->name }}
                                                                    </h6>
                                                                    <p class="font-13">{{ $renter->contact_number }}</p>
                                                                </td>
                                                                <td>{{ $renter->contact_number }}</td>
                                                                <td>{{ $renter->rentedHouse->price }}
                                                                </td>
                                                                <td>@if($renter->rentedHouse->payment_date->isPast())
                                                                    <!-- For past dates -->
                                                                    <span class="text-danger">
                                                                        Due {{ $renter->rentedHouse->payment_date->diffForHumans() }}
                                                                    </span>
                                                                @else
                                                                    <!-- For future dates -->
                                                                    <span class="text-success">
                                                                        Due in {{ $renter->rentedHouse->payment_date->diffForHumans() }}
                                                                    </span>
                                                                @endif</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td class="text-center">{{ __('message.no_data') }}</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>

                                                <div>
                                                    <a class="theme-link font-14 font-medium d-flex align-items-center justify-content-center mt-20"
                                                        href="{{ route('owner.tenants') }}">
                                                        {{ __('message.view_all') }}<i class="ri-arrow-right-line ms-2"></i>
                                                    </a>
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
        </div>
    </div>
</x-app-layout>
{{-- @endsection --}}

@push('script')
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index-charts.js') }}"></script>
@endpush