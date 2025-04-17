@props(['multiple'])

@php
  $required  = isset($required) ? bool_val($required) : false;
  $readonly  = isset($readonly) ? bool_val($readonly) : false;
  $disabled  = isset($disabled) ? bool_val($disabled) : false;
  $multiple  = isset($multiple) ? bool_val($multiple) : false;
@endphp

<div class="{{ $classDiv ?? 'form-floating mb-3' }}" id="div_{{ $property }}">

  <input type="file" name="{{ $property }}{{ $multiple ? '[]' : ''}}" id="{{ $property }}" class="{{ $classInput ?? 'form-control form-control-sm' }} @error($property) is-invalid @enderror"
    placeholder="{{ $placeholder ?? $label }}"
    value="{{ old($property, $entity != null ? $entity->$property : ($old ?? '')) }}"
    {!! $required ? 'required' : '' !!}
    {!! $readonly ? 'readonly' : '' !!}
    {!! $disabled ? 'disabled' : '' !!}
    {!! $multiple ? 'multiple="multiple"' : '' !!}
  />
  <label for="{{ $property }}" class="{{ $classLabel ?? '' }} {{ $required ? 'required' : '' }}">
    {{ $label }}
  </label>
  <x-inputs.input-error-property />
</div>
