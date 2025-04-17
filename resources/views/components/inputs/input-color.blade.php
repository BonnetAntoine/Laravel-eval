@props([
    'property',
    'label',
    'required' => false,
    'classDiv' => null,
    'classLabel' => null,
    'classInput' => null,
    'readonly' => false,
    'disabled' => false,
    'entity' => null,
])

<div class="overflow-hidden {{ $classDiv ?? 'form-floating mb-3' }}" id="div_{{ $property }}">

  <input type="color" name="{{ $property }}" id="{{ $property }}" {{ $attributes->merge(['class' => 'form-control' . ($errors->has($property) ? ' is-invalid' : '')]) }}
    placeholder="{{ $placeholder ?? $label }}" value="{{ old($property, $entity->$property) }}" {{ bool_val($required) ? 'required' : '' }}
    {{ bool_val($readonly) ? 'readonly' : '' }} {{ bool_val($disabled) ? 'disabled' : '' }} />
  <label for="{{ $property }}" class="{{ $classLabel ?? '' }} {{ bool_val($required) ? 'required' : '' }}">
    {!! $label !!}
  </label>

  <x-inputs.input-error-property />

</div>
