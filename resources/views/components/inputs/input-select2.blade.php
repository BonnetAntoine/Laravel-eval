@props([
  'property',
  'name' => null,
  'entity',
  'label',
  'values',
  'itemValue' => 'id',
  'itemLabel' => 'label',
  'required' => false,
  'disabled' => false,
  'liaison' => null,
  'onchange' => ''
])

<div class="form-floating mb-3 ">

  <select id="{{ $name ?? $property }}" name="{{ $name ?? $property }}" title="{{ $label }}" autocomplete="off" {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}
    class="form-control select2 form-control-sp @error($property) is-invalid @enderror">
    <option selected value=""></option>
    @foreach ($values as $value)
      <option id="{{ $property }}_{{ $value->$itemValue }}" value="{{ $value->$itemValue }}" {{ old($property, $entity?->$property ?? null) == $value->id ? 'selected' : '' }}
        data-liaison="{{ $liaison != null ? $value->$liaison : '' }}">
        {{ $value->$itemLabel }}</option>
    @endforeach
  </select>

  <label for="{{ $property }}" class="{{ bool_val($required) ? 'required' : '' }}">
    {{ $label }}
  </label>

  <x-inputs.input-error-property />
</div>

<script type="module">
  $(document).ready(function() {
    var select = $('#{{ $property }}').select2({
      language: 'fr',
      theme: 'bootstrap-5',
      allowClear: {{ bool_val($required) ? 'true' : 'false' }},
      placeholder: "",
    });

    // Simplified onChange handler
    select.on('change', function () {
        const selectedValue = $(this).val();
        if (typeof changeSalarie === 'function') {
            changeSalarie(selectedValue);
        }
    });

    select.data('select2')
      .$selection
      .css('height', '58px')
      .css('display', 'flex')
      .css('align-items', 'flex-end');
  });
</script>
</script>
</script>
