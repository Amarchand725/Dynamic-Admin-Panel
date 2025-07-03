{{-- <button
    data-toggle="tooltip" data-placement="top" title="Edit {{ $singularLabel }}"
    data-edit-url="{{ route($routeInitialize.'.edit', $model->id) }}"
    data-url="{{ route($routeInitialize.'.update', $model->id) }}"
    class="btn btn-primary btn-sm mb-3 mb-md-0 mx-3 edit-btn"
    tabindex="0" aria-controls="DataTables_Table_0"
    type="button" data-bs-toggle="modal"
    data-bs-target="#create-pop-up-modal">
    <i class="fa fa-edit"></i>
</button>

<a href="javascript:;"
    data-toggle="tooltip" data-placement="top" title="Delete {{ $singularLabel }}"
    class="btn btn-danger btn-sm delete"
    data-del-url="{{ route($routeInitialize.'.destroy', $model->id) }}">
    <i class="fa fa-trash"></i>
</a> --}}

<div class="d-flex align-items-center">
    <a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
        <i class="ti ti-dots-vertical ti-sm mx-1"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end m-0">
        @can($routeInitialize.'-edit')
            <button
                data-toggle="tooltip" data-placement="top" title="Edit {{ $singularLabel }}"
                data-edit-url="{{ route($routeInitialize.'.edit', $model->id) }}"
                data-url="{{ route($routeInitialize.'.update', $model->id) }}"
                class="dropdown-item edit-btn"
                tabindex="0" aria-controls="DataTables_Table_0"
                type="button" data-bs-toggle="modal"
                data-bs-target="#create-pop-up-modal-for-file">
                Edit
            </button>
        @endcan
        @can($routeInitialize.'-delete')
            <a href="javascript:;" class="dropdown-item delete" data-del-url="{{ route($routeInitialize.'.destroy', $model->id) }}">Delete</a>
        @endcan 
    </div>
</div>

