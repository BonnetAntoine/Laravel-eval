{{--
  Penser à utiliser cdnCss('bootstrap-datepicker') et cdnJS('bootstrap-datepicker')
  https://bootstrap-datepicker.readthedocs.io/
--}}
@php
  $required = isset($required) ? bool_val($required) : false;
  $readonly = isset($readonly) ? bool_val($readonly) : false;
  $disabled = isset($disabled) ? bool_val($disabled) : false;
@endphp

<div class="overflow-hidden {{ $classDiv ?? 'form-floating mb-3'}} @error($property) is-invalid @enderror">
  <input name="{{ $property }}"
         id="{{ $property }}"
         class="datepicker {{ $classInput ?? 'form-control'}} @error($property) is-invalid @enderror"
         value="{{ old($property, $entity != null ? $entity->$property : ($old ?? '')) }}"
         placeholder="{{ $label }}"
         {!! $required ? 'required="required"' : '' !!}
         {!! $readonly ? 'readonly="readonly"' : '' !!}
         {!! $disabled ? 'disabled' : '' !!}
         autocomplete="off"
  />
  <label for="{{ $property }}" class="{{ $classLabel ?? '' }} {{ $required ? 'required' : '' }}">{!! $label !!}</label>
  {{ $slot }}
  <x-inputs.input-error-property />
</div>
