<form id="form-units">
    <!-- Form Group -->
    <div class="form-group">
        <label for="name" class="form-label">@lang('global.name')</label>
        <x-form.text
            id="name"
            error="name"
            name="name"
            value="{{ $data->name }}"
            :text="__('global.name')"></x-form.text>
    </div> <!-- End Form Group -->
</form>

<div class="target-unit-action">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary"
        onclick="updateData(`{{ $data->id }}`)">
        @lang('global.save')
    </button>
</div>
