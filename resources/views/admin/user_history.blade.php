<x-app-layout>
    <!-- Right Content Start -->
    <div class="main-content">
        <div class="page-content">
            <div class="container">
                <!-- Page Content Wrapper Start -->
                <div class="page-content-wrapper bg-white p-4 radius-20">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0">{{__("message.activity_history",["form" => $who])}}</h3>
                                </div>

                                <div class="card-body">
                                    @if($rentalHistory->isEmpty())
                                        <div class="alert alert-info">
                                            {{__("message.no_rental")}}
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>{{__('message.house')}}</th>
                                                        <th>{{__('message.action')}}</th>
                                                        <th>{{__('message.date')}}</th>
                                                        <th>{{__("message.description")}}</th>
                                                        <th>{{__("message.Links")}}</th>
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
                                                                    <span
                                                                        class="badge-type bg-success mb-2 d-inline-block">{{__("message.rented")}}</span>
                                                                @elseif($history->type == RELEASED)
                                                                    <span
                                                                        class="badge-type bg-danger mb-2 d-inline-block">{{__("message.left")}}</span>
                                                                @elseif($history->type == VISITED)
                                                                    <span
                                                                        class="badge-type bg-info mb-2 d-inline-block">{{__("message.visited")}}</span>
                                                                @elseif($history->type == ADDED)
                                                                    <span
                                                                        class="badge-type bg-success mb-2 d-inline-block">{{__("message.added")}}</span>
                                                                @elseif($history->type == REGISTERED)
                                                                    <span
                                                                        class="badge-type bg-success mb-2 d-inline-block">{{__("message.joined")}}</span>
                                                                @elseif($history->type == REMOVED)
                                                                    <span
                                                                        class="badge-type bg-danger mb-2 d-inline-block">{{__("message.removed")}}</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $history->created_at->format('M d, Y h:i A') }}</td>
                                                            <td>
                                                                <p>{{$history->content}}</p>
                                                            </td>
                                                            <td>
                                                                @if(isset($history->house))
                                                                    <a href="{{route('house_detail',[$history->house->id])}}"><span class="badge-type bg-primary mb-2 d-inline-block">{{__("message.goto_house")}}</span></a>
                                                                @elseif(isAdmin())
                                                                    <a href="{{route('admin.editUsers',[$history->user->id])}}" ><span class="badge-type bg-primary mb-2 d-inline-block">{{__("message.goto_user")}}</span></a>
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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