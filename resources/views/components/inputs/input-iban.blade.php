@php
  $required = isset($required) ? bool_val($required) : false;
  $disabled = isset($disabled) ? bool_val($disabled) : false;
@endphp

<div class="{{ $classDiv ?? 'form-floating mb-3' }}" id="div_{{ $property }}">

  @if (!empty($classDivInput))
    <div class="{{ $classDivInput }}">
  @endif
  <input type="text" name="{{ $property }}" id="{{ $property }}" class="{{ $classInput ?? 'form-control' }} @error($property) is-invalid @enderror"
    placeholder="{{ $placeholder ?? $label }}" value="{{ str_replace(' ', '', old($property, $entity != null ? $entity->$property : $old ?? '')) }}" {!! $required ? 'required="required"' : '' !!}
    maxlength="34" minlength="14" {!! $disabled ? 'disabled' : '' !!} />
  <label for="{{ $property }}" class="{{ $classLabel ?? '' }} {{ $required ? 'required' : '' }}">{{ $label }}</label>
  @error($property)
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
  @if (!empty($classDivInput))
</div>
@endif
</div>

<script>
  document.getElementById('{{ $property }}').addEventListener('input', function(e) {
    e.target.value = format_iban(e.target.value);
  });
  document.getElementById('{{ $property }}').addEventListener('blur', function(e) {
    e.target.value = format_iban(e.target.value);
  });
  document.getElementById('{{ $property }}').addEventListener('focus', function(e) {
    e.target.value = format_iban(e.target.value);
  });

  window.onload = function() {
    document.getElementById("{{ $property }}").value = format_iban(document.getElementById("{{ $property }}").value);
  };

  function format_iban(input) {
    return input.replace(/[^\da-zA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim().toUpperCase();
  }
</script>
