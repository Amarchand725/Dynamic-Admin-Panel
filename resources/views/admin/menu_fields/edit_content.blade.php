@method('PUT')
<input type="hidden" name="pre_menu" value="{{ $menu->menu }}">
<input type="hidden" name="field_order" id="field_order">

<script>
    const FIELD_TYPES = @json(fieldTypes());
    const INPUT_TYPES = @json(inputTypes());
    const FIELD_ATTRS = ['required', 'index_visible', 'create_visible', 'edit_visible', 'show_visible'];
</script>

<div class="row" data-init="dynamic-fields">
    <!-- Vertical Icons Wizard -->
    <div class="col-12 mb-4">
      <div class="d-flex justify-content-between align-items-center">
          <small class="text-light fw-semibold">Menu Fields</small>
          <button type="button" id="add-field" class="btn btn-success btn-sm">+ Add Field</button>
      </div>
      <div class="bs-stepper vertical wizard-vertical-icons-example mt-2">
        <div class="bs-stepper-header" id="stepperTabs">
            @foreach($fields as $name => $field)
                <div class="step" data-target="#{{ $field['name'] }}">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">
                            <i class="ti ti-file-description"></i>
                        </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">{{ $field['label'] ?? '' }}</span>
                            <span class="bs-stepper-subtitle">Setup {{ $field['label'] ?? '' }} </span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-sm text-danger remove-field ms-1" data-name="{{ $field['name'] }}">×</button>
                </div>
                <div class="line"></div>
            @endforeach
        </div>
        <div class="bs-stepper-content" id="stepperContent">
            @foreach($fields as $name => $field)
                <div id="{{ $field['name'] }}" class="content">
                    <div class="content-header mb-3">
                        <h6 class="mb-0">{{ $field['label'] ?? ucfirst($name) }}</h6>
                        <small>Enter {{ $field['label'] ?? $name }} Settings.</small>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label>Field Name</label>
                                <input type="text" name="fields[{{ $field['name'] }}][name]" value="{{ $field['name'] }}" class="form-control w-full">
                            </div>
                            <div class="mb-3">
                                <label>Data Type</label>
                                <select name="fields[{{ $field['name'] }}][type]" class="form-select w-full">
                                    @foreach (fieldTypes() as $key=>$fieldType)
                                        <option value="{{ $key }}" {{ $field['type']==$key ? 'selected' : '' }}>{{ $fieldType }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Input Type</label>
                                <select name="fields[{{ $field['name'] }}][input_type]" class="form-select w-full">
                                    @foreach (inputTypes() as $key=>$inputType)
                                        <option value="{{ $key }}" {{ $field['input_type']==$key ? 'selected' : '' }}>{{ $inputType }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Label</label>
                                <input type="text" name="fields[{{ $field['name'] }}][label]" value="{{ $field['label'] }}" class="form-control w-full">
                            </div>
                            <div class="mb-3">
                                <label>Placeholder</label>
                                <input type="text" name="fields[{{ $field['name'] }}][placeholder]" value="{{ $field['placeholder'] }}" class="form-control w-full">
                            </div>
                            @foreach (['required', 'index_visible', 'create_visible', 'edit_visible', 'show_visible'] as $attr)
                                <div class="mb-2">
                                    <label>
                                        <input type="checkbox" name="fields[{{ $field['name'] }}][{{ $attr }}]" value="1" {{ !empty($field[$attr]) ? 'checked' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $attr)) }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="mb-3">
                                <label>Extra (JSON)</label>
                                <textarea name="fields[{{ $field['name'] }}][extra]" placeholder="{'validation':'max:255'}" class="form-control w-full" rows="3">{{ $field['extra'] }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
      </div>
    </div>
</div>