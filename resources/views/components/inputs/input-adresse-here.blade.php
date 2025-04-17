@aware(['address' => $entity, 'disabled' => $disabled])

<div class="form-floating mb-3" id="div_libelle">
  <input type="text" name="address" id="address" class="form-control " placeholder="Adresse" list="addresses"
    onkeyup="majListe(this.value, '{{ $lang }}', {{ $gps }})" autocomplete="no">
  <ul id="addresses" class="d-none list-unstyled border">
  </ul>
  <label for="libelle" class="">
    Adresse (saisir 5 caractères minimum)
  </label>
</div>
<input type="hidden" name="address_id" value="{{ $address?->id }}">
<div class="small mb-2 px-1">Vous pouvez ajuster l’adresse proposée si nécessaire</div>
<x-inputs.input-text property="line_1" :entity="$address" label="Adresse ligne 1" required="true" maxlength="75" class="bg-body-secondary" />
<x-inputs.input-text property="line_2" :entity="$address" label="Adresse ligne 2" required="false" maxlength="75" class="bg-body-secondary" />
<x-inputs.input-text property="postal_code" :entity="$address" label="Code Postal" required="true" maxlength="5" class="bg-body-secondary" />
<x-inputs.input-text property="city" :entity="$address" label="Ville" required="true" maxlength="75" class="bg-body-secondary" />

@include('commun.js.maps.here')
