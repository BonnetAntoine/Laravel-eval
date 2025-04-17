@props([
    'property',
    'label',
    'old' => null,
    'required' => false,
    'checked' => false,
    'classDiv' => null,
    'classLabel' => null,
    'classInput' => null,
    'readonly' => false,
    'disabled' => false,
    'entity' => null,
])

@php
  $required = isset($required) ? bool_val($required) : false;
@endphp

<div class="form-check form-switch pb-0 {{ $classDiv }}">
  <input type="checkbox" class="form-check-input" name="{{ $property }}" id="{{ $property }}" value="1" role="switch" {{ $required ? 'required' : '' }}
    {{ $checked || old($property, $old ?? '') ? 'checked="checked"' : '' }} />
  <label for="{{ $property }}" class="form-check-label {{ $classLabel ?? '' }} {{ $required ?? false ? 'required' : '' }}">{!! $label !!}</label>
  <x-inputs.input-error-property />
</div>
