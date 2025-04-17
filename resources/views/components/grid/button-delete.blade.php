@can($path . '-delete')
  `
  <form method="POST" action="{{ url((isset($prefix) ? $prefix . '/' : '') . $path) }}/` + row.id + `" id="form-delete-` + row.id + `" accept-charset="UTF-8" class="d-inline">
    <input name="_method" type="hidden" value="DELETE">
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-outline-danger btn-inline" data-bs-toggle="tooltip" title="Supprimer" aria-label="Supprimer"
      onclick="suppressionItem('#` + (row.id).toString().padStart(3, '0') + `', ` + row.id + `)">
      <i class="fa-regular fa-trash-can fa-fw"></i>
    </button>
  </form>
  `
@else
  `
  <a href="#" class="btn btn-outline-dark btn-inline btn-fit disabled" data-bs-toggle="tooltip" title="Supprimer">
    <i class="fa-regular fa-trash-can fa-fw"></i>
  </a>&nbsp;
  `
@endcan
