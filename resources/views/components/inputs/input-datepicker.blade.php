{{-- https://getdatepicker.com/ --}}

@props([
    'property',
    'entity',
    'label',
    'placeholder',
    'custom_css' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'dateRange' => false,
    'property_error' => null,
])

<div class="form-floating input-group mb-3 @error($property) is-invalid @enderror @error($property_error) is-invalid @enderror" id="datepicker_{{ $property }}">
  <input name="{{ $property }}" id="{{ $property }}"
    class="form-control {{ $custom_css }} @error($property) is-invalid @enderror @error($property_error) is-invalid @enderror"
    value="{{ old($property, $entity != null ? $entity->$property : $old ?? '') }}" placeholder="{{ $label }}" {!! $required ? 'required="required"' : '' !!} {!! $readonly ? 'readonly="readonly"' : '' !!}
    {!! $disabled ? 'disabled' : '' !!} autocomplete="off" />
  <span class="input-group-text">
    <i class="fas fa-calendar"></i>
  </span>
  <label for="{{ $property }}" class="{{ $classLabel ?? '' }} {{ bool_val($required) ? 'required' : '' }}">
    {!! $label !!}
  </label>
  <x-inputs.input-error-property />

  @error($property_error)
    <span {{ $attributes->merge(['class' => 'invalid-feedback']) }} role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>

<script type="module">
  new TempusDominus(document.getElementById('datepicker_{{ $property }}'), {
    localization: {
      format: 'dd/MM/yyyy',
      startOfTheWeek: 1,
    },
    useCurrent: false,
    dateRange: {{ $dateRange }},
    display: {
      calendarWeeks: true,
      components: {
        clock: false,
      },
    },
  })
</script>
