@props([
    'property',
    'label',
    'placeholder',
    'old' => null,
    'required' => false,
    'maxlength' => null,
    'minlength' => null,
    'classDiv' => null,
    'classLabel' => null,
    'classInput' => null,
    'readonly' => false,
    'disabled' => false,
    'entity' => null,
])

<div class="{{ $classDiv ?? 'form-floating mb-3' }}" id="div_{{ $property }}">

  @if (!empty($classDivInput))
    <div class="{{ $classDivInput }}">
  @endif
  <input type="text" name="{{ $property }}" id="{{ $property }}" class="{{ $classInput ?? 'form-control' }} @error($property) is-invalid @enderror"
    placeholder="{{ $placeholder ?? $label }}" value="{{ str_replace(' ', '', old($property, $entity != null ? $entity->$property : $old ?? '')) }}" {{ $required ? 'required' : '' }}
    {!! $maxlength != null ? 'maxlength="' . $maxlength . '"' : '' !!} {!! $minlength != null ? 'minlength="' . $minlength . '"' : '' !!} onblur="ajouterSeparateurTelephone('{{ $property }}')" onfocus="retirerSeparateurTelephone('{{ $property }}')"
    onkeyup="this.value=this.value.replace(/\D/g,'')" {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} />
  <label for="{{ $property }}" class="{{ $classLabel ?? '' }} {{ $required ? 'required' : '' }}">{{ $label }}</label>
  <x-inputs.input-error-property />
  @if (!empty($classDivInput))
</div>
@endif
</div>

<script>
  function ajouterSeparateurTelephone(item) {
    let telephoneItem = document.getElementById(item);
    let telephoneValue = telephoneItem.value.replace(/(.{2})(?=.)/g, "$1 ");
    telephoneItem.value = telephoneValue;
  }

  function retirerSeparateurTelephone(item) {
    let telephoneItem = document.getElementById(item);
    let telephoneValue = telephoneItem.value.replace(/ /g, "");
    telephoneItem.value = telephoneValue;
  }
</script>
