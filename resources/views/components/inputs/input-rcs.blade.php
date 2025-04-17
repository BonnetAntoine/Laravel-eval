@php
  $required = isset($required) ? ($required === "true" ? true : false) : false;
  $disabled  = isset($disabled) ? ($disabled === 'true' ? true : false) : false;
@endphp

<div class="{{ $classDiv ?? 'form-floating mb-3'}}" id="div_{{ $property }}">

  @if (!empty($classDivInput))
    <div class="{{ $classDivInput }}">
  @endif
  <input type="text"
         name="{{ $property }}"
         id="{{ $property }}"
         class="{{ $classInput ?? 'form-control'}} @error($property) is-invalid @enderror"
         placeholder="{{ $placeholder??$label }}"
         value="{{ str_replace(' ', '', old($property, $entity != null ? $entity->$property : ($old ?? ''))) }}"
         {!! $required ? 'required="required"' : '' !!}
         {!! $maxlength != null ? 'maxlength="' . $maxlength . '"' : '' !!}
         {!! $minlength != null ? 'minlength="' . $minlength . '"' : '' !!}
         onblur="ajouterSeparateur('{{ $property }}')"
         onfocus="retirerSeparateur('{{ $property }}')"
         {!! $disabled == 'true' ? 'disabled' : '' !!}
  />
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
  function ajouterSeparateur(item){
    let telephoneItem = document.getElementById(item);
    let telephoneValue = telephoneItem.value.replace(/(.{3})(?=.)/g,"$1 ");
    telephoneItem.value = telephoneValue;
  }

  function retirerSeparateur(item){
    let telephoneItem = document.getElementById(item);
    let telephoneValue = telephoneItem.value.replace(/ /g, "");
    telephoneItem.value = telephoneValue;
  }
</script>
