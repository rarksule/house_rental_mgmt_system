<x-app-layout>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-content-wrapper bg-white p-4 radius-20">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <div class="page-title-left">
                                    <h2 class="mb-sm-0">{{ __('message.dashboard') }}</h2>
                                    <p>{{ __('message.Welcome_back') }}, {{ auth()->user()->name }} <span class="iconify font-24"
                                            data-icon="openmoji:waving-hand"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="dashboard-feature-item bg-off-white theme-border rounded-3 p-3 mb-4">
                                <div
                                    class="dashboard-feature-item-icon-wrap font-20 d-flex align-items-center justify-content-center bg-white rounded-3">
                                    <span class="iconify text-warning" data-icon="material-symbols:patient-list"></span>
                                </div>
                                <p class="mt-2">{{ __('message.Total_Owner') }}</p>
                                <h2 class="mt-1">{{ $totalOwner }}</h2>

                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="dashboard-feature-item bg-off-white theme-border rounded-3 p-3 mb-4">
                                <div
                                    class="dashboard-feature-item-icon-wrap font-20 d-flex align-items-center justify-content-center bg-white rounded-3">
                                    <span class="iconify text-primary" data-icon="bxs:home-circle"></span>
                                </div>
                                <p class="mt-2">{{ __('message.Total_houses') }}</p>
                                <h2 class="mt-1">{{ $totalHouse }}</h2>

                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="dashboard-feature-item bg-off-white theme-border rounded-3 p-3 mb-4">
                                <div
                                    class="dashboard-feature-item-icon-wrap font-20 d-flex align-items-center justify-content-center bg-white rounded-3">
                                    <span class="iconify text-warning" data-icon="material-symbols:garage-home"></span>
                                </div>
                                <p class="mt-2">{{ __('message.Total_communication') }}</p>
                                <h2 class="mt-1">{{ $totalmessage }}</h2>

                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="dashboard-feature-item bg-off-white theme-border rounded-3 p-3 mb-4">
                                <div
                                    class="dashboard-feature-item-icon-wrap font-20 d-flex align-items-center justify-content-center bg-white rounded-3">
                                    <span class="iconify text-success" data-icon="mdi:user"></span>
                                </div>
                                <p class="mt-2">{{ __('message.Total_Tenant') }}</p>
                                <h2 class="mt-1">{{ $totalTenant }}</h2>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="dashboard-properties-table bg-off-white theme-border p-3 rounded-3 mb-4">
                                    <div class="">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center justify-content-between mb-4">
                                                    <h4 class="mb-0">{{ __('message.new_tenants') }}</h4>
                                                    <div>
                                                        <a class="text-primary font-14 font-medium d-flex align-items-center justify-content-center"
                                                            href="{{ route('admin.tenants') }}">
                                                            {{ __('message.View_All') }}<i class="ri-arrow-right-line ms-2"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table theme-border p-3">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('message.first_name') }}</th>
                                                                <th>{{ __('message.last_name') }}</th>
                                                                <th>{{ __('message.email') }}</th>
                                                                <th>{{ __('message.status') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($tenants as $tenant)
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="text-gray-900">
                                                                            {{ $tenant->first_name }}
                                                                        </h6>
                                                                    </td>
                                                                    <td>{{ $tenant->last_name }}</td>
                                                                    <td>{{ $tenant->email }}</td>
                                                                    <td>
                                                                        <h6 class="btn-outlined {{ $tenant->status ? 'text-success' : 'text-danger' }} ">
                                                                            {{  $tenant->status ? __('message.active') : __('message.inactive') }}
                                                                        </h6>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="text-center">{{ __('message.no_data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="dashboard-properties-table bg-off-white theme-border p-3 rounded-3 mb-4">
                                    <div class="">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center justify-content-between mb-4">
                                                    <h4 class="mb-0">{{ __('message.new_owners') }}</h4>
                                                    <div>
                                                        <a class="text-primary font-14 font-medium d-flex align-items-center justify-content-center"
                                                            href="{{ route('admin.owners') }}">
                                                            {{ __('message.View_All') }}<i class="ri-arrow-right-line ms-2"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table theme-border p-3">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('message.first_name') }}</th>
                                                                <th>{{ __('message.last_name') }}</th>
                                                                <th>{{ __('message.email') }}</th>
                                                                <th>{{ __('message.status') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($owners as $owner)
                                                            <tr>
                                                                <td>
                                                                    <h6 class="text-gray-900">
                                                                        {{ $owner->first_name }}
                                                                    </h6>
                                                                </td>
                                                                <td>{{ $owner->last_name }}</td>
                                                                <td>{{ $owner->email }}</td>
                                                                <td>
                                                                    <h6 class="btn-outlined {{ $tenant->status ? 'text-success' : 'text-danger' }} ">
                                                                        {{  $tenant->status ? __('message.active') : __('message.inactive') }}
                                                                    </h6>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td class="text-center">{{ __('message.no_data') }}</td>
                                                            </tr>
                                                        @endforelse
                                                        </tbody>
                                                    </table>
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

