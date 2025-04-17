@php
  $required = isset($required) ? ($required === "true" ? true : false) : false;
@endphp


<div class="{{ $classDiv ?? 'form-group'}} @error($property) is-invalid @enderror">
  <label for="{{ $property }}" class="{{ $classLabel ?? '' }} {{ $required ? 'required' : '' }}">{{ $label }}</label>
  <textarea name="{{ $property }}"
            id="{{ $property }}"
            class="{{ $classInput ?? 'form-control'}}"
            placeholder="{{ $placeholder ?? $label }}">{!! old($property, $old ?? '') !!}</textarea>
  <x-inputs.input-error-property />
</div>

<script>
  CKEDITOR.plugins.addExternal( 'stylesheetparser', '/ckeditor/plugins/stylesheetparser/', 'plugin.js' );
  CKEDITOR.replace('{{ $property }}', {
    allowedContent: true,
    autoGrow_bottomSpace: 50,
    extraPlugins: "stylesheetparser",
    contentsCss: ["{{ asset('css/ck.css') }}"],
    stylesSet: [],
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',
    customConfig: '{{ asset("js/config.js") }}',
    on: {
      insertElement: function(event) {
        var element = event.data;
        if (element.getName() == 'img') {
          element.addClass('img-fluid');
          element.removeAttribute("style");
        }
      }
    }
  });
</script>
