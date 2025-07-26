@extends('admin.layouts.app')
@section('title', $title. ' -  ' . appName())

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-header">
                        <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Home /</span> {{ $title }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="nav-align-left nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($business_settings as $category => $settings)
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link @if($loop->first) active @endif"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-left-{{ Str::slug($category) }}"
                                    aria-controls="navs-left-{{ Str::slug($category) }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                >
                                    {{ ucfirst($category) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach ($business_settings as $category => $settings)
                            <div class="tab-pane fade @if($loop->first) show active @endif" id="navs-left-{{ Str::slug($category) }}">
                                <div class="row">
                                    @foreach ($settings as $setting)
                                    <div class="@if($setting->input_type=='textarea' || $setting->key=='location_map_url') col-md-12 @else col-md-6 @endif mb-3">
                                        <label class="form-label">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>
                                        <div class="form-control-plaintext border p-2">
                                            @if($setting->input_type == 'file')
                                                @if($setting->value)
                                                    <img src="{{ asset('storage/'.$setting->value) }}" width="120px" alt="{{ $setting->key }}">
                                                @else
                                                    <img src="{{ asset('storage/images/default.png') }}" width="120px" alt="{{ $setting->key }}">
                                                @endif
                                            @elseif($setting->input_type == 'checkbox')
                                                {{ $setting->value ? 'Enabled' : 'Disabled' }}
                                            @else
                                                <span class="fw-bold">{{ $setting->value ?? 'N/A' }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="text-end">
                                    <button
                                        data-toggle="tooltip" 
                                        data-placement="top" 
                                        title="Edit {{ ucwords($category) }}"
                                        data-edit-url="{{ route('settings.edit', $category) }}"
                                        data-url="{{ route('settings.update', $category) }}"
                                        class="btn btn-primary edit-btn"
                                        tabindex="0" aria-controls="DataTables_Table_0"
                                        type="button" data-bs-toggle="modal"
                                        data-bs-target="#create-pop-up-modal-for-file">
                                        Edit {{ ucwords($category) }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modals -->
<x-modals />
<!--/ Modals -->
@endsection