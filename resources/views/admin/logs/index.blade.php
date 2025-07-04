@extends('admin.layouts.app')

@section('title', $title.' -  ' . appName())

@section('content')

<input type="hidden" id="page_url" value="{{ route($routeInitialize.'.index') }}">

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-header">
                        <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Home /</span> {{ $title }}</h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dt-buttons btn-group flex-wrap float-end mt-4">
                        <button id="refresh-record" class="btn btn-success mx-2" title="Refresh Records"><i class="ti ti-refresh me-0 ti-xs"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="container">
                        <table class="dt-row-grouping table dataTable dtr-column data_table">
                            <thead>
                                <tr>
                                    @foreach($columnsConfig as $columnName)
                                        <th>{{ $columnName['name'] }}</th>
                                    @endforeach
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
