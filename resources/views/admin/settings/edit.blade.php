@extends('admin.layouts.app')
@section('title', $title. ' -  ' . appName())

@section('content')
<div class="content-wrapper">
    <!-- Tabs -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-header">
                        <h4 class="fw-bold mb-0">Company Settings</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- User Content -->
            <div class="col-xl-12 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- User Pills -->
                <ul class="nav nav-pills flex-column flex-md-row mb-4 profile-tabs">
                    <li class="nav-item"></li>
                    <li class="nav-item">
                        <button type="button" class="nav-link active " role="tab" data-bs-toggle="tab" data-bs-target="#navs-company-profile" aria-controls="navs-company-profile" aria-selected="true">
                            <i class="ti ti-user-check me-1 ti-xs"></i>Company Profile
                        </button>
                    </li>
                    {{-- <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-settings" aria-controls="navs-settings" aria-selected="true">
                            <i class="fa fa-cog" aria-hidden="true"></i>&nbsp; Settings
                        </button>
                    </li> --}}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="navs-company-profile" role="tabpanel">
                        <div class="card-body">
                            <form id="company-settings" action="{{ route('settings.update', getSetting('id', 1)) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('PATCH') }}

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-2 col-form-label">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" 
                                            value="{{ getSetting('name', null) }}" 
                                            name="settings[name]" id="name" placeholder="Enter company name"/>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="name_error" class="text-danger error">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="logo" class="col-md-2 col-form-label">White Logo </label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="settings[logo]" type="file" id="logo" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="logo_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="logo" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        @if(!empty(getSetting('logo', null)))
                                            <div id="logo-preview" class="p-3 w-25 rounded bg-light">
                                                <img class="img-fluid img-thumbnail w-50 mx-auto" src="{{ asset('storage').'/'.getSetting('logo', null) }}" alt="">
                                            </div>
                                        @else
                                            <div id="logo-preview" class="p-3 w-25 rounded bg-light"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="black_logo" class="col-md-2 col-form-label">Black Logo </label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="settings[black_logo]" type="file" id="black_logo" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="black_logo_error" class="text-danger error">{{ $errors->first('black_logo') }}</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="black_logo" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        @if(!empty(getSetting('black_logo', null)))
                                            <div id="black_logo-preview">
                                                <img style="width:15%; height:5%" src="{{ asset('storage').'/'.getSetting('black_logo', null) }}" alt="">
                                            </div>
                                        @else
                                            <div id="black_logo-preview"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="favicon" class="col-md-2 col-form-label">Favicon</label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="settings[favicon]" type="file" id="favicon" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="favicon_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="favicon" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        @if(!empty(getSetting('favicon', null)))
                                            <div id="favicon-preview">
                                                <img style="width:5%; height:5%" src="{{ asset('storage').'/'.getSetting('favicon', null) }}" alt="">
                                            </div>
                                        @else
                                            <div id="favicon-preview"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="slip_stamp" class="col-md-2 col-form-label">Slip Stamp </label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="settings[slip_stamp]" type="file" id="slip_stamp" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="slip_stamp_error" class="text-danger error">{{ $errors->first('slip_stamp') }}</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="slip_stamp" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        @if(!empty(getSetting('slip_stamp', null)))
                                            <div id="slip_stamp-preview">
                                                <img style="width:10%; height:5%" src="{{ asset('storage').'/'.getSetting('slip_stamp', null) }}" alt="">
                                            </div>
                                        @else
                                            <div id="slip_stamp-preview"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="admin_signature" class="col-md-2 col-form-label">Admin Signature </label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="settings[admin_signature]" type="file" id="admin_signature" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="admin_signature_error" class="text-danger error">{{ $errors->first('admin_signature') }}</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="admin_signature" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        @if(!empty(getSetting('admin_signature', null)))
                                            <div id="admin_signature-preview">
                                                <img style="width:10%; height:5%" src="{{ asset('storage').'/'.getSetting('admin_signature', null) }}" alt="">
                                            </div>
                                        @else
                                            <div id="admin_signature-preview"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="phone_number" class="col-md-2 col-form-label">Phone Number <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control phoneNumber" type="text" 
                                            name="settings[phone_number]" value="{{ getSetting('phone_number', null) }}" id="phone_number" 
                                            placeholder="Enter company phone number" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="phone_number_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="support_email" class="col-md-2 col-form-label">Support Email <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="email" name="settings[support_email]" value="{{ getSetting('support_email', null) }}" id="support_email" placeholder="Enter support email" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="support_email_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="sale_email" class="col-md-2 col-form-label">Sale Email <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="email" name="settings[sale_email]" value="{{ getSetting('sale_email', null) }}" id="sale_email" placeholder="Enter sale email" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="sale_email_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-md-2 col-form-label">Operating Hours</label>
                                    <div class="col-md-10 d-flex gap-2">
                                        <select name="settings[day_range]" class="form-select w-auto">
                                            <option value="Mon-Fri" {{ getSetting('day_range', null)=='Mon-Fri'?'selected':'' }}>Mon-Fri</option>
                                            <option value="Sat-Sun" {{ getSetting('day_range', null)=='Sat-Sun'?'selected':'' }}>Sat-Sun</option>
                                        </select>
                                
                                        <input class="form-control w-auto" type="time" name="settings[start_time]" value="08:00" />
                                        <span class="align-self-center">to</span>
                                        <input class="form-control w-auto" type="time" name="settings[end_time]" value="17:00" />
                                
                                        <select name="settings[timezone]" class="form-select w-auto">
                                            <option value="CDT" {{ getSetting('timezone', null)=='CDT'?'selected':'' }}>CDT</option>
                                            <option value="EST" {{ getSetting('timezone', null)=='EST'?'selected':'' }}>EST</option>
                                            <option value="PST" {{ getSetting('timezone', null)=='PST'?'selected':'' }}>PST</option>
                                            <option value="UTC" {{ getSetting('timezone', null)=='UTC'?'selected':'' }}>UTC</option>
                                        </select>
                                    </div>
                                </div>                                
                                <div class="mb-3 row">
                                    <label for="website_url" class="col-md-2 col-form-label">Website URL</label>
                                    <div class="col-md-10">
                                        <textarea name="settings[website_url]" id="website_url" class="form-control" placeholder="Enter website url">{{ getSetting('website_url', null) }}</textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="website_url_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="location_map_url" class="col-md-2 col-form-label">Location Map URL</label>
                                    <div class="col-md-10">
                                        <textarea name="settings[location_map_url]" id="location_map_url" class="form-control" placeholder="Enter website url">{{ getSetting('location_map_url', null) }}</textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="location_map_url_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="country" class="col-md-2 col-form-label">Country</label>
                                    <div class="col-md-10">
                                        <select name="settings[country]" id="country" class="form-select" data-url="{{ route('get-states') }}">
                                            @foreach (countries() as $country)
                                                <option value="{{ $country->name }}" {{ getSetting('country', null)==$country->name?'selected':'' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="country_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="state" class="col-md-2 col-form-label">State</label>
                                    <div class="col-md-10">
                                        <select name="settings[state]" id="state" class="form-select" data-url="{{ route('get-cities') }}">
                                            @foreach ($states as $state)
                                                <option value="{{ $state->name }}" {{ getSetting('state', null)==$state->name?'selected':'' }}>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="state_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="city" class="col-md-2 col-form-label">City</label>
                                    <div class="col-md-10">
                                        <select name="settings[city]" id="city" class="form-select">
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->name }}" {{ getSetting('city', null)==$city->name?'selected':'' }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="city_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="zip_code" class="col-md-2 col-form-label">Zipcode</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="settings[zip_code]" value="{{ getSetting('zip_code', null) }}" id="zip_code" placeholder="Enter zip code"/>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="zip_code_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="area" class="col-md-2 col-form-label">Area</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="settings[area]" value="{{ getSetting('area', null) }}" id="area" placeholder="Enter area"/>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="area_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="address" class="col-md-2 col-form-label">Address <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <textarea name="settings[address]" id="address" class="form-control" placeholder="Enter address">{{ getSetting('address', null) }}</textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="address_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="facebook_link" class="col-md-2 col-form-label">Facebook Link</label>
                                    <div class="col-md-10">
                                        <textarea name="settings[facebook_link]" id="" class="form-control" placeholder="Enter facebook link here...">{{ getSetting('facebook_link', null) }}</textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="facebook_link_error" class="text-danger error">{{ $errors->first('facebook_link') }}</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="instagram_link" class="col-md-2 col-form-label">Instagram Link</label>
                                    <div class="col-md-10">
                                        <textarea name="settings[instagram_link]" id="instagram_link" class="form-control" placeholder="Enter instagram link here...">{{ getSetting('instagram_link', null) }}</textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="instagram_link_error" class="text-danger error">{{ $errors->first('instagram_link') }}</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="linked_in_link" class="col-md-2 col-form-label">LinkedIn Link</label>
                                    <div class="col-md-10">
                                        <textarea name="settings[linked_in_link]" id="linked_in_link" class="form-control" placeholder="Enter linkedIn link here...">{{ getSetting('linked_in_link', null) }}</textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="linked_in_error" class="text-danger error">{{ $errors->first('linked_in_link') }}</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="twitter_link" class="col-md-2 col-form-label">Twitter Link</label>
                                    <div class="col-md-10">
                                        <textarea name="settings[twitter_link]" class="form-control" placeholder="Enter twitter link here...">{{ getSetting('twitter_link', null) }}</textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="twitter_error" class="text-danger error">{{ $errors->first('twitter_link') }}</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="address" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        <button id="updateButton" type="submit" class="btn btn-primary me-2">
                                            <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                            Update
                                        </button>  
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="tab-pane fade" id="navs-settings" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10 pl-md-2 pt-md-0 pt-sm-4 pt-4">
                                    <div class="tab-content px-primary">
                                        <div id="Change Password-1" class="tab-pane fade active show">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                                    Change Setting
                                                </h5>
                                                <div class="d-flex align-items-center mb-0"></div>
                                            </div>
                                            <hr />
                                            <div class="content py-primary" id="change-password">
                                                <div class="content" id="Change Password-1">
                                                    <form id="company-settings" action="{{ route('settings.update', getSetting('id', null)) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        {{ method_field('PATCH') }}

                                                        <input type="hidden" name="settings" value="settings" />
                                                        <div class="mb-3 row">
                                                            <div class="col-md-12">
                                                                <label for="lanaguage" class="col-md-3 col-form-label"></label>
                                                                <small><b>- Enabling this setting allows administrators to fill discrepancies or leaves for the previous month after the month-end. Default is 'Off'.</b></small>
                                                            </div>
                                                            <label for="lanaguage" class="col-md-3 col-form-label">Allow Filling Previous Month Discrepancies/Leaves {{ getSetting('discrepancy_leave_allow_enable_disable', null) }}</label>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline mt-3">
                                                                    <input type="radio" id="dis-allow-enable" name="discrepancy_leave_allow_enable_disable" class="form-check-input" @if (!empty(getSetting('discrepancy_leave_allow_enable_disable', null)) && getSetting('discrepancy_leave_allow_enable_disable', null) == 1) checked @endif required
                                                                    value="1" />
                                                                    <label class="form-check-label" for="dis-allow-enable">Enable</label>
                                                                </div>
                                                                <div class="form-check form-check-inline mt-3">
                                                                    <input type="radio" id="dis-allow-disable" name="discrepancy_leave_allow_enable_disable" class="form-check-input" @if (getSetting('discrepancy_leave_allow_enable_disable', null) == 0) checked @endif required
                                                                    value="0" />
                                                                    <label class="form-check-label" for="dis-allow-disable">Disable</label>
                                                                </div>
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                                <span id="discrepancy_leave_allow_enable_disable_error" class="text-danger error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="lanaguage" class="col-md-3 col-form-label">Max Leaves <small>Allow Per Month</small> <span class="text-danger">*</span></label>
                                                            <div class="col-md-9">
                                                                <input class="form-control" type="number" name="max_leaves" value="{{ old('max_leaves', getSetting('max_leaves', null)) }}" id="lanaguage" placeholder="Enter max allow leaves" />
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                                <span id="max_leaves_error" class="text-danger error">{{ $errors->first('max_leaves') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="lanaguage" class="col-md-3 col-form-label">Max Discrepancies <small>Allow Per Month</small> <span class="text-danger">*</span></label>
                                                            <div class="col-md-9">
                                                                <input class="form-control" type="number" name="max_discrepancies" value="{{ old('max_discrepancies', getSetting('max_discrepancies', null)) }}" id="lanaguage" placeholder="Enter max allow discrepancies" />
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                                <span id="max_discrepancies_error" class="text-danger error">{{ $errors->first('max_discrepancies') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="insurance_eligibility" class="col-md-3 col-form-label">Insurance Eligibility <span class="text-danger">*</span></label>
                                                            <div class="col-md-9">
                                                                <select class="form-select select2" id="insurance_eligibility" name="insurance_eligibility">
                                                                    <option value="0" {{ getSetting('insurance_eligibility', null)==0?'selected':'' }}>Immediately</option>
                                                                    <option value="1" {{ getSetting('insurance_eligibility', null)==1?'selected':'' }}>1 Month</option>
                                                                    <option value="2" {{ getSetting('insurance_eligibility', null)==2?'selected':'' }}>2 Month</option>
                                                                    <option value="3" {{ getSetting('insurance_eligibility', null)==3?'selected':'' }}>3 Month</option>
                                                                    <option value="4" {{ getSetting('insurance_eligibility', null)==4?'selected':'' }}>4 Month</option>
                                                                    <option value="5" {{ getSetting('insurance_eligibility', null)==5?'selected':'' }}>5 Month</option>
                                                                    <option value="6" {{ getSetting('insurance_eligibility', null)==6?'selected':'' }}>6 Month</option>
                                                                </select>
                                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                                                <span id="insurance_eligibility_error" class="text-danger error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="address" class="col-md-3 col-form-label"></label>
                                                            <div class="col-md-9">
                                                                <button type="button" class="btn btn-primary me-2 d-none" id="editButton">Edit</button>
                                                                <button id="updateButton" type="submit" class="btn btn-primary me-2">
                                                                    Save Changes
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Tabs -->
</div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $('form').on('submit', function () {
                const btn = $('#updateButton');
                btn.prop('disabled', true);
                $('#spinner').removeClass('d-none');
            });
        });

        $(document).ready(function() {
            // When the file input changes
            $('#logo').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                // Create an image element
                var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                // Display the image preview
                $('#logo-preview').html(img);
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            });

            $('#black_logo').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                // Create an image element
                var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                // Display the image preview
                $('#black_logo-preview').html(img);
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            });

            $('#slip_stamp').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                // Create an image element
                var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                // Display the image preview
                $('#slip_stamp-preview').html(img);
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            });

            $('#admin_signature').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Create an image element
                    var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                    // Display the image preview
                    $('#admin_signature-preview').html(img);
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            });

            $('#favicon').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                // Create an image element
                var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                // Display the image preview
                $('#favicon-preview').html(img);
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            });

            $('select').each(function () {
                $(this).select2({
                    dropdownParent: $(this).parent(),
                });
            });

            // $('#company-settings input, select, textarea').prop('disabled', true);

            // $('#editButton').click(function() {
            //   $(this).addClass('d-none');
            //   $('#updateButton').removeClass('d-none');
            //   $('#company-settings input, select, textarea').prop('disabled', false);
            // });
        });
    </script>
@endpush
