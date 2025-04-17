@props(['property' => null, 'entity' => null, 'action' => null, 'method', 'has_uploaded_file' => false])

<form action="{{ $action != null ? $action : ($entity == null ? route($property . '.store') : route($property . '.update', [$property => $entity->id])) }}" method="POST"
  {{ $has_uploaded_file ? 'enctype="multipart/form-data"' : '' }} class="needs-validation" novalidate>
  @csrf
  @isset($method)
    @method($method)
  @else
    <input type="hidden" name="_method" value="{{ $entity == null ? 'POST' : 'PUT' }}" />
  @endisset
  <input type="hidden" name="id" value="{{ $entity?->id ?? -1 }}" />

  {!! $slot !!}
</form>
