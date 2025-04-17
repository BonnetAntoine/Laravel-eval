@props([
  'property',
  'label',
  'placeholder',
  'old'=> null,
  'required' => false,
  'maxlength'=> null,
  'minlength'=> null,
  'classDiv'=> null,
  'classLabel'=> null,
  'classInput'=> null,
  'readonly' => false,
  'disabled' => false,
  'entity' => null,
  'pivot' => false,
  'itemPivot'=> null,
  'autofocus' => false,
  'itemProperty'=> null
])

<div class="overflow-hidden {{ $classDiv ?? 'form-floating mb-3' }}" id="div_{{ $property }}">

  <input type="text" name="{{ $property }}" id="{{ $property }}" {{ $attributes->merge(['class' => 'form-control' . ($errors->has($property) ? ' is-invalid' : '')]) }}
    placeholder="{{ $placeholder ?? $label }}"
    value="{{ old($property, $entity != null
      ?
        ($itemPivot == null
          ? ($itemProperty == null
            ? $entity->$property
            : $entity->$itemProperty)
          : ($pivot
            ? $entity->pivot->$itemPivot
            : $entity->$itemPivot)
        )
      : ($old ?? '')) }}"
    {{ bool_val($required) ? 'required' : '' }}
    {{ $maxlength != null ? 'maxlength=' . $maxlength : '' }}
    {{ $minlength != null ? 'minlength=' . $minlength : '' }}
    {{ bool_val($readonly) ? 'readonly' : '' }}
    {{ bool_val($disabled) ? 'disabled' : '' }}
    {{ bool_val($autofocus) ? 'autofocus' : '' }}
  />
  <label for="{{ $property }}" class="{{ $classLabel ?? '' }} {{ bool_val($required) ? 'required' : '' }}">
    {!! $label !!}
  </label>

  <x-inputs.input-error-property />

</div>

@if (bool_val($autofocus))
  <script>
    window.onload = function() {
      document.getElementById("{{ $property }}").focus();
    };
  </script>
@endif
