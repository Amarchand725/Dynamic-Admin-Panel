@extends('admin.layouts.app')

@section('title', $title.' -  ' . appName())

@section('content')
<input type="hidden" id="page_url" value="{{ route(Route::currentRouteName()) }}">

<div class="content-wrapper">
    <div class="flex-grow-1">
        <div class="card">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-header">
                        <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Home /</span> {{ $title }}</h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end align-item-center mt-4">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end align-item-center">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <button data-toggle="tooltip" data-placement="top" title="Refresh " type="button" class="btn btn-secondary add-new btn-primary me-3" id="refresh-btn" data-url="{{ route('logs.index') }}">
                                        <span>
                                            <i class="ti ti-refresh ti-sm"></i>
                                            <span class="d-none d-sm-inline-block">Refresh Records</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logs List Table -->
        <div class="card mt-4">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="container-fluid">
                        <table class="dt-row-grouping table dataTable dtr-column border-top table-border data_table table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User</th>
                                    <th scope="col" style="width: 100px">Action Type</th>
                                    <th scope="col" style="width: 100px">Action Model</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">IP</th>
                                    <th scope="col" style="width: 100px">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    //datatable
    $(document).ready(function(){
        var page_url = $('#page_url').val();
        var columns =     {!! json_encode($columnsConfig) !!}  // Get columns dynamically from controller
        initializeDataTable(page_url, columns);
    })
    $('#refresh-record').on('click', function(){
        var page_url = $('#page_url').val();
        var columns =     {!! json_encode($columnsConfig) !!}  // Get columns dynamically from controller
        initializeDataTable(page_url, columns);
    })
</script>
@endpush
