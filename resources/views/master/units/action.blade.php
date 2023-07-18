<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle no-arrow btn-action btn-ellipsis" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-ellipsis-h"></i>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item"
                onclick="openGlobalModal('{{ route('units.edit', $row->id) }}', `{{ __('global.edit') . ' ' . __('global.unit') }}`, {footer: true, target: `target-unit-action`})"">
                @lang('global.edit')
            </a>
        </li>
        <li>
            <a class="dropdown-item"
                onclick="confirmDelete(`{{ $row->id }}`)">@lang('global.delete')</a>
        </li>
    </ul>
</div>
