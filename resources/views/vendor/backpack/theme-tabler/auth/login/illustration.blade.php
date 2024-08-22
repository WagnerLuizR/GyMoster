@extends(backpack_view('layouts.auth'))

@section('content')
    <div class="page page-center">
        <div class="container container-normal py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg">
                    <div class="container-tight">
                        <div class="text-center mb-4 display-6 auth-logo-container">
                            {!! backpack_theme_config('project_logo') !!}
                        </div>
                        <div class="card card-md">
                            <div class="card-body pt-0">
                                @include(backpack_view('auth.login.inc.form'))
                            </div>
                        </div>
                        @if (config('backpack.base.registration_open'))
                            <div class="text-center text-muted mt-4">
                                <a tabindex="6" href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg d-none d-lg-block">
                    <img src="https://preview.tabler.io/static/illustrations/light/boy-with-key.png"
                         style="align-content: center; width: 100%; max-width: 100%" class="d-block mx-auto" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
