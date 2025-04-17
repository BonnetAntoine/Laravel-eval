@can($path . '-delete')
  `
  <a href="#" class="btn btn-outline-danger btn-block btn-fit"
    onclick="restaurationItem('#` + (row.id).toString().padStart(3, '0') + `', '{{ url((isset($prefix) ? $prefix . '/' : '') . $path) }}/` + row.id + `/undelete')"
    data-bs-toggle="tooltip" title="Restaurer">
    <i class="fal fa-undo-alt fa-fw"></i>
  </a>&nbsp;
  `
@else
  `
  <a href="#" class="btn btn-outline-dark btn-inline btn-fit disabled" data-bs-toggle="tooltip" title="Supprimer" data-bs-toggle="tooltip" title="Restaurer">
    <i class="fal fa-undo-alt fa-fw"></i>
  </a>&nbsp;
  `
@endcan
