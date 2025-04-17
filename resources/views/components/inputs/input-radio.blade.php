@php
  $required = isset($required) ? ($required === "true" ? true : false) : false;
  $checked = isset($checked) ? ($checked === "true" ? true : false) : false;
  $disabled = isset($disabled) ? ($disabled === "true" ? true : false) : false;
@endphp

<div class="custom-control custom-radio d-flex align-items-center my-2 {{ $classDiv ?? '' }}">
  <input type="radio"
         {{ $attributes->merge(['class' => 'form-check-input me-2 mt-0' . ($errors->has($property) ? ' is-invalid' : '')]) }}
         name="{{ $property }}"
         id="{{ $property . '-' . Str::slug($label) }}"
         value="{{ $value }}"
         {{ $required ? 'required' : '' }}
         {{ $disabled ? 'disabled' : '' }}
         {{ ($checked || old($property, $old ?? '') == $value) ? 'checked=checked' : '' }}
  />
  <label for="{{ $property . '-' . Str::slug($label) }}" class="custom-control-label {{ $classLabel ?? '' }} {{ $required ? 'required' : '' }}">{!! $label !!}</label>
  <x-inputs.input-error-property />
</div>
