  @can($path . '-update')
    `
    <a href="{{ url((isset($prefix) ? $prefix . '/' : '') . $path) }}/` + row.id + `/edit" class="btn btn-outline-warning btn-inline btn-fit" data-bs-toggle="tooltip" title="Modifier">
      <i class="fa-regular fa-pen-to-square fa-fw"></i>
    </a>&nbsp;
    `
  @else
    @can($path . '-retrieve')
      `
      <a href="{{ url((isset($prefix) ? $prefix . '/' : '') . $path) }}/` + row.id + `" class="btn btn-outline-info btn-inline btn-fit" data-bs-toggle="tooltip" title="Voir">
        <i class="fa-regular fa-eye fa-fw"></i>
      </a>&nbsp;
      `
    @else
      `
      <a href="#" class="btn btn-outline-dark btn-inline btn-fit disabled" data-bs-toggle="tooltip" title="Modifier">
        <i class="fa-regular fa-pen-to-square fa-fw"></i>
      </a>&nbsp;
      `
    @endcan
  @endcan
