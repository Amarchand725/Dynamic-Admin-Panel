<table class="table table-flush-spacing">
    @foreach($fields as $name => $field)
        <tr>
            <td class="text-nowrap fw-semibold">{{ $field['label'] ?? ucfirst($name) }}</td>
            <td>
                @if($field['type'] === 'file')
                    @if(!empty($field['value']))
                        <img src="{{ asset('storage/' . $field['value']) }}" width="80">
                    @endif
                @elseif($name === 'status')
                    <span class="badge bg-label-{{ $model->status ? 'success' : 'danger' }}">
                        {{ $model->status ? 'Active' : 'Deactive' }}
                    </span>
                @elseif($name === 'fields')
                    @php $tableFields = $model->hasMenFields; @endphp 
                    <table class="table">
                        <tr>
                            <th><strong>Field Name</strong></th>
                            <th><strong>Data Type</strong></th>
                            <th><strong>Input Type</strong></th>
                        </tr>
                        @if(isset($tableFields) && !empty($tableFields))
                            @foreach ($tableFields as $tableKey=>$tableField)
                                <tr>
                                    <td>{{ ucfirst($tableField->name) ?? '-' }}</td>
                                    <td>{{ ucfirst($tableField->data_type ?? '-') }}</td>
                                    <td>{{ ucfirst($tableField->input_type ?? '-') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                @else
                    @if($name=='menu_group')
                        @if(isset($model->hasMenuGroup) && !empty($model->hasMenuGroup))
                            {{ ucfirst($model->hasMenuGroup->menu ?? '-') }}
                        @else
                            -
                        @endif
                    @elseif($name=='icon')
                        <i class="menu-icon tf-icons {{ $model->icon ?? '-' }}"></i>
                    @else
                        {!! ucfirst($field['value'] ?? '-') !!}
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
</table>
