@extends('layouts.master')

@push('styles')
    <style>
        .btn-create-unit {
            border-radius: 4px !important;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-borderless w-100" id="table-units">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>@lang('global.name')</th>
                            <th>@lang('global.action')</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div> <!-- End Table -->

        </div> <!-- End Card Body -->
    </div> <!-- End Card -->
@endsection

@push('scripts')
    <script src="{{ mix('js/regex.js') }}"></script>
    <script src="{{ mix('js/unit.js') }}"></script>
@endpush
