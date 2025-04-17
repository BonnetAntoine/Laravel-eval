@props(['ability', 'url', 'id', 'target' => false, 'icone' => 'fas fa-edit', 'couleur' => 'info', 'titre' => 'Modifier'])

@can($ability)
  <div data-bs-toggle="tooltip" title="{!! $titre !!}">
    <a href="{{ url($url) }}" class="btn btn-outline-{{ $couleur ?? 'info' }} btn-inline btn-fit" {{ $target ?? false ? 'target="_blank"' : '' }}>
      <i class="{{ $icone }} fa-fw"></i>
    </a>
  </div>&nbsp;
@else
  <div data-bs-toggle="tooltip" title="{{ $titre }}">
    <a href="#" class="btn btn-outline-dark btn-inline btn-fit disabled">
      <i class="{{ $icone }} fa-fw"></i>
    </a>
  </div>&nbsp;
@endcan
