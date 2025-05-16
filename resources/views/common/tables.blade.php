<x-app-layout>
    <div class="main-content">
        <div class="content">
            <div class="page-content-wrapper pt-4 radius-20">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <span>{{ $pageTitle ?? 'Data Table' }}</span>
                                {!! $button ?? '' !!}
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="dynamicDataTable">
                                        <thead class="table-dark">
                                            <tr>
                                                @foreach($columns as $column)
                                                    <th>
                                                        @if(is_object($column))
                                                            {{ $column->title ?? ucfirst(str_replace('_', ' ', $column->name)) }}
                                                        @else
                                                            {{ ucfirst(str_replace('_', ' ', $column)) }}
                                                        @endif
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                    </table>
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
    const isAdmin = {{ isAdmin() }}
    $(function () {
        // Configuration for DataTable
        var table = $('#dynamicDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $ajaxRoute ?? '#' }}',
            columns: [
                @foreach($columns as $column)
                    @php
                        $columnName = is_object($column) ? $column->name : $column;
                        $isAction = $columnName === 'action';
                        $nonOrderable = in_array($columnName, $nonOrderableColumns ?? ['action', 'Location', 'rented', 'verified', 'status']);
                        $nonSearchable = in_array($columnName, $nonSearchableColumns ?? ['action', 'Location', 'rented', 'verified', 'status']);
                    @endphp
                    {
                        data: '{{ $columnName }}',
                        name: '{{ $columnName }}',
                        @if($nonOrderable)
                            orderable: false,
                        @endif
                        @if($nonSearchable)
                            searchable: false,
                        @endif
                        @if($isAction)
                            className: 'text-center'
                        @endif
                    },
                @endforeach
            ],
            language: {
                emptyTable: "{{ __('message.no_found',['form'=> $title ]) }}",
                info: "{{ __('message.showing_all',['form'=>$title]) }}",
                infoEmpty: "{{ __('message.showing_all',['form'=>$title]) }}",
                infoFiltered: " {{__('message.filterd',['form'=>$title])}})",
                lengthMenu: " {{ __('message.show_menu',['form'=> $title]) }}",
                search: "{{ __('message.search.0') }}",
                zeroRecords: "{{ __('message.no_found_filt',['form'=>$title]) }}"
            }
        });

        // Delete button action with confirmation
        $('#dynamicDataTable').on('click', '.delete', function () {
            var dataId = $(this).data('id');
            var dataType = $(this).data('type');
    
              if(isAdmin){
                var deleteUrl = dataType=='user' ? "{{ route('admin.deleteUser',[':id']) }}".replace(':id', dataId) 
                    : "{{ route(userprefix().'.deleteHouse',[':id']) }}".replace(':id', dataId);
            }else{
                var deleteUrl = "{{ route('owner.deleteHouse',[':id']) }}".replace(':id', dataId);
            }
            
            if (confirm("{{ __('message.sure_delete',['form'=>$item]) }}")) {
                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                      "_method":"DELETE"
                    },
                    success: function (result) {
                        table.ajax.reload();
                        toastr.success("{{ __('message.delete_success',['form'=> $item]) }}");
                    },
                    error: function (xhr) {
                        alert('Error deleting {{ $title ?? "item" }}: ' + (xhr.responseJSON?.message || 'Unknown error'));
                    }
                });
            }
        });

        // Status change handler
        $('#dynamicDataTable').on('click', '.change-status', function () {
            var dataId = $(this).data('id');
            var statusUrl = "{{ route('admin.activate', [':id']) }}".replace(':id', dataId);
            
            $.ajax({
                url: statusUrl,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "PATCH"
                },
                success: function (result) {
                    table.ajax.reload();
                    toastr.success("{{ __('message.saved',['form'=>__('message.status')]) }}");
                },
                error: function (xhr) {
                    alert('Error updating status: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        });
    });
</script>
@endpush
    
</x-app-layout>