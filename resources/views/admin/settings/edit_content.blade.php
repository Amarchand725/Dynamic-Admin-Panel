@method('PUT')
<div class="">
    <div class="row">
        <input type="hidden" name="category" value="{{ $category }}">
        @foreach ($business_settings as $setting)
            <div class="@if($setting->input_type=='textarea' || $setting->key=='location_map_url') col-md-12 @else col-md-6 @endif mb-3">
                <label class="form-label">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>

                @switch($setting->input_type)
                    @case('textarea')
                        <textarea class="form-control" name="settings[{{ $setting->key }}]">{{ $setting->value }}</textarea>
                        @break

                    @case('file')
                        <input type="file" class="form-control uploader" id="{{ $setting->key }}" name="settings[{{ $setting->key }}]">
                        @if ($setting->value)
                            <span>
                                <img style="width:120px" src="{{ asset('storage/'.$setting->value) }}" alt="{{ $setting->key }}">
                            </span>
                        @else
                            <span id="preview-{{ $setting->key }}"></span>
                        @endif
                        @break

                    @case('checkbox')
                        <div class="form-check">
                            <input type="hidden" name="settings[{{ $setting->key }}]" value="0">
                            <input type="checkbox" class="form-check-input" id="check_{{ $setting->key }}"
                                name="settings[{{ $setting->key }}]" value="1"
                                {{ $setting->value ? 'checked' : '' }}>
                            <label class="form-check-label" for="check_{{ $setting->key }}">Enabled</label>
                        </div>
                        @break

                    @case('select')
                        @if($setting->key=='timezone')
                            <select name="settings[{{ $setting->key }}]" class="form-select w-auto">
                                <option value="">Select {{ $setting->key }}</option>
                                @foreach (getTimeZone() as $timezone)
                                    <option value="{{ $timezone }}" {{ $setting->value==$timezone?'selected':'' }}>{{ $timezone }}</option>
                                @endforeach
                            </select>
                        @else
                            <select name="settings[{{ $setting->key }}]" class="form-select w-auto">
                                <option value="">Select {{ $setting->key }}</option>
                            </select>
                        @endif
                        @break

                    @case('time')
                    @case('email')
                    @case('url')
                    @case('number')
                    @case('text')
                        @if($setting->key=='phone_number')
                            <input type="text" 
                                class="form-control phoneNumber" 
                                name="settings[{{ $setting->key }}]" 
                                value="{{ $setting->value }}">
                        @else
                            <input type="text" 
                                class="form-control" 
                                name="settings[{{ $setting->key }}]" 
                                value="{{ $setting->value }}">
                        @endif
                        @break
                        
                    @default
                        <input type="{{ $setting->input_type ?? 'text' }}"
                            class="form-control"
                            name="settings[{{ $setting->key }}]"
                            value="{{ $setting->value }}">
                @endswitch

            </div>
        @endforeach
    </div>
</div>
<script>
    $('select').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent(),
        });
    });
</script>