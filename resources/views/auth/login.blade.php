@extends('layouts.auth')

@section('content')
<!--begin::Content-->
<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
    <!--begin::Logo-->
    <a href="{{ route('dashboard') }}" class="mb-12" style="font-size: 24px;">
        {{-- <img alt="Logo" src="{{ asset('images/logo-1.svg') }}" class="h-40px" /> --}}
        Asset & Stock Management
    </a>
    <!--end::Logo-->
    <!--begin::Wrapper-->
    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">

        @if (session('status'))
            <div class="alert alert-info">
                <div class="mb-4 text-center">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <!--begin::Form-->
        <form class="form w-100" id="kt_sign_in_form" method="POST" action="/login">
            @csrf
            <!--begin::Heading-->
            <div class="text-center mb-10">
                <!--begin::Title-->
                <h1 class="text-dark mb-3">@lang('global.login')</h1>
                <!--end::Title-->
            </div>
            <!--begin::Heading-->
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--begin::Label-->
                <label class="form-label fs-6 fw-bolder text-dark">
                    @lang('global.email')
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="email"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    name="email"
                    id="email"
                    placeholder="dummy@gmail.com">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-10">
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack mb-2">
                    <!--begin::Label-->
                    <label class="form-label fw-bolder text-dark fs-6 mb-0">
                        @lang('global.password')
                    </label>
                    <!--end::Label-->
                    <!--begin::Link-->
                    <a href="/forgot-password" class="link-primary fs-6 fw-bolder">@lang('global.forgot_password') ?</a>
                    <!--end::Link-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Input-->
                <input class="form-control form-control-lg @error('password') is-invalid @enderror"
                    type="password"
                    id="password"
                    name="password"
                    placeholder="*****"
                    autocomplete="off" />
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Actions-->
            <div class="text-center">
                <!--begin::Submit button-->
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">@lang('global.login')</span>
                    <span class="indicator-progress">Tunggu...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Submit button-->
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Content-->
@endsection
