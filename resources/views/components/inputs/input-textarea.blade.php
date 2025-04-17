@props([
  'property',
  'label',
  'placeholder',
  'old',
  'required' => false,
  'classDiv',
  'classLabel',
  'classInput',
  'readonly' => false,
  'disabled' => false,
  'entity' => null,
  'pivot' => false,
  'itemPivot' => null,
  'itemProperty' => null,
])

<div class="{{ $classDiv ?? 'form-floating mb-3' }}" id="div_{{ $property }}">
  <textarea name="{{ $property }}"
            id="{{ $property }}"
            class="{{ $classInput ?? 'form-control' }} @error($property) is-invalid @enderror"
            placeholder=" {{ $placeholder ?? $label }}"
            {{ bool_val($required) ? 'required' : '' }}
            {{ bool_val($readonly) ? 'readonly' : '' }}
            {{ bool_val($disabled) ? 'disabled' : '' }}
            style="height: {{ $rows ?? 110 }}px">{!!
              old($property, $entity != null
                ?
                  ($itemPivot == null
                    ? ($itemProperty == null
                      ? $entity->$property
                      : $entity->$itemProperty)
                    : ($pivot
                      ? $entity->pivot->$itemPivot
                      : $entity->$itemPivot)
                  )
                : ($old ?? ''))
              !!}</textarea>
  <label for="{{ $property }}" class="{{ $classLabel ?? '' }} {{ bool_val($required) ? 'required' : '' }}">
    {!! $label !!}
  </label>
  @error($property)
    <span class="invalid-feedback d-inline" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>
