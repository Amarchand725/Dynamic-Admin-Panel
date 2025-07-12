@php
    $isChild = $menu->menu_group !== null;
@endphp

<li class="list-group-item lh-1 d-flex flex-column align-items-start border rounded mb-1 shadow-sm" data-id="{{ $menu->id }}">
    <div class="w-100 d-flex justify-content-between align-items-center">
        <span class="d-flex align-items-center gap-2">
            @if ($isChild)
                <i class="drag-handle cursor-move ti ti-chevron-right text-muted"></i>
            @else
                <i class="drag-handle cursor-move {{ $menu->icon }} text-primary"></i>
            @endif
            <strong>{{ $menu->menu_label }}</strong>
        </span>
    </div>

    @if ($menu->children && $menu->children->count())
        <ul class="list-group list-group-flush nested-sortable ms-4 mt-2 w-100 ps-2 border-start border-2 border-primary">
            @foreach ($menu->children as $child)
                @include('admin.menus._menu-item', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li>