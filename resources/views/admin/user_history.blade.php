<x-app-layout>
    <!-- Right Content Start -->
    <div class="main-content">
        <div class="page-content">
            <div class="container">
                <!-- Page Content Wrapper Start -->
                <div class="page-content-wrapper bg-white p-30 radius-20">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0">Your Rental History</h3>
                                </div>

                                <div class="card-body">
                                    @if($rentalHistory->isEmpty())
                                        <div class="alert alert-info">
                                            No rental history found.
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Property</th>
                                                        <th>Action</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rentalHistory as $history)
                                                        <tr>
                                                            <td>
                                                                <strong>{{ $history->house->name }}</strong><br>
                                                                <small
                                                                    class="text-muted">{{$history->nu ->address }}</small>
                                                            </td>
                                                            <td>
                                                                @if($history->action === 'rented')
                                                                    <span class="badge badge-success">Rented</span>
                                                                @elseif($history->action === 'left')
                                                                    <span class="badge badge-danger">Left</span>
                                                                @else
                                                                    <span class="badge badge-info">Visited</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $history->created_at->format('M d, Y h:i A') }}</td>
                                                            <td>
                                                                @if($history->is_active)
                                                                    <span class="badge badge-success">Active</span>
                                                                @else
                                                                    <span class="badge badge-secondary">Inactive</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            {{ $rentalHistory->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>