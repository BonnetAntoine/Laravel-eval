@props([
  'property',
  'label',
  'required' => true,
  'showIconeEye' => true
])

<div {{ $attributes->merge(['class' => 'form-floating mb-3']) }} id="div_{{ $property }}">

  <input type="password" name="{{ $property }}" id="{{ $property }}" {{ $attributes->merge(['class' => 'form-control' . ($errors->has($property) ? ' is-invalid' : '')]) }}
    placeholder="{{ $placeholder ?? $label }}" />

  @if ($showIconeEye)
    <span class="password-icon">
      <i class="fa-regular fa-eye _{{ $property }}"></i>
      <i class="fa-regular fa-eye-slash _{{ $property }}"></i>
    </span>
  @endif

  <label for="{{ $property }}" {{ $attributes->merge(['class' => $required ? ' required' : '']) }}>
    {!! $label !!}
  </label>

  <x-inputs.input-error-property />

</div>

@if ($showIconeEye)
  <script>
    const eye_{{ $property }} = document.querySelector(".fa-eye._{{ $property }}");
    const eyeoff_{{ $property }} = document.querySelector(".fa-eye-slash._{{ $property }}");
    const passwordField_{{ $property }} = document.querySelector("#{{ $property }}");

    eye_{{ $property }}.addEventListener("click", () => {
      eye_{{ $property }}.style.display = "none";
      eyeoff_{{ $property }}.style.display = "block";

      passwordField_{{ $property }}.type = "text";
    });

    eyeoff_{{ $property }}.addEventListener("click", () => {
      eyeoff_{{ $property }}.style.display = "none";
      eye_{{ $property }}.style.display = "block";

      passwordField_{{ $property }}.type = "password";
    });
  </script>
@endif
