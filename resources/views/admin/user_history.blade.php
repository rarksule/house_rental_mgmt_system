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
                                                        <th>description</th>
                                                        <th>Links</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rentalHistory as $history)
                                                        <tr>
                                                            <td>
                                                                @if(isset($history->house))
                                                                    <strong>{{ $history->house->name }}</strong><br>
                                                                    <small class="text-muted">{{$history->house->address }}</small>

                                                                @else
                                                                    <strong>{{ $history->user->name }}</strong><br>
                                                                    <small class="text-muted">{{$history->user->role }}</small>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($history->type == RENTED)
                                                                    <span class="property-type bg-danger mb-2 d-inline-block">Rented</span>
                                                                @elseif($history->type == RELEASED)
                                                                    <span class="property-type bg-danger mb-2 d-inline-block">Left</span>
                                                                @else
                                                                    <span class="property-type bg-danger mb-2 d-inline-block">Visited</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $history->created_at->format('M d, Y h:i A') }}</td>
                                                            <td>
                                                                <p>{{$history->content}}</p>
                                                            </td>
                                                            <td>
                                                                @if(isset($history->house))
                                                                <span class="property-type bg-danger mb-2 d-inline-block">Go to House</span>
                                                                @elseif(isAdmin())
                                                                <span class="property-type bg-danger mb-2 d-inline-block">Go to User</span>
                                                                @endif
                                                                
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- <div class="d-flex justify-content-center">
                                            {{ $rentalHistory->links() }}
                                        </div> --}}
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