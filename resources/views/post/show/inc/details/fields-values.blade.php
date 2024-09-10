@php
    $customFields ??= [];
@endphp
@if (!empty($customFields))
    <div class="row gx-1 gy-1 mt-3">
        <div class="col-12">
            <div class="row mb-3">
                <div class="col-12">
                    <h4 class="p-0"><i class="fas fa-bars"></i> {{ t('Additional Details') }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12">
            <table class="table table-striped">
                <tbody>
                    @foreach ($customFields as $field)
                        @php
                            $fieldType = data_get($field, 'type');
                            $fieldName = data_get($field, 'name');
                            $fieldValue = data_get($field, 'default_value');
                        @endphp
                        @if ($fieldType !== 'video')
                            {{-- Add this condition to exclude video fields --}}
                            @if (is_array($fieldValue))
                                @if (count($fieldValue) > 0)
                                    <tr>
                                        <td class="fw-bolder w-50">{{ $fieldName }}:</td>
                                        <td>
                                            @foreach ($fieldValue as $valueItem)
                                                @php
                                                    $vItemValue = data_get($valueItem, 'value');
                                                @endphp
                                                @continue(is_null($vItemValue))
                                                <div><i class="fa fa-check"></i> {{ $vItemValue }}</div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @else
                                @if (is_string($fieldValue) || is_numeric($fieldValue) || is_bool($fieldValue))
                                    @if ($fieldType == 'file')
                                        <tr>
                                            <td class="fw-bolder w-50 w-100">{{ $fieldName }}</td>
                                            <td class="text-sm-end text-start">
                                                <a class="btn btn-default" href="{{ $fieldValue }}" target="_blank">
                                                    <i class="fas fa-paperclip"></i> {{ t('Download') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="fw-bolder w-50">{{ $fieldName }}</td>
                                            <td class="text-sm-end text-start">
                                                @if ($fieldType == 'url')
                                                    <a href="{{ $fieldValue }}" target="_blank"
                                                        rel="nofollow">{{ $fieldValue }}</a>
                                                @else
                                                    {{ $fieldValue }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
