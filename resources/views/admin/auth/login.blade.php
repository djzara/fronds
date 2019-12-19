@extends('layout.master')


@section('left-gutter')
    <div class="col-md-2">

        @include('layout.gutters.base-left-gutter')

    </div>

@stop

@section('content')

    <div class="fronds-widget-content col-md-12 mt-5 justify-content-center text-center">

        <div class="fronds-row col-md-4 offset-md-4">
            <h2>{{ __('page.admin.title') }}</h2>
        </div>
        <div class="fronds-row col-md-8 offset-md-2">
            <fronds-form id="fronds-login-form"
                         dusk="fronds-admin-login-form"
                         submits-to="{{ $submitLoginTo }}"
                         with-method="post"
                         in-mode="{{ config('fronds.security.authentication.login_scheme') }}">
                @csrf
                <div class="fronds-row col-md-12">
                    <fronds-input id="fronds-admin-login-email"
                                  input-id="fronds-admin-email"
                                  input-name="email"
                                  :input-label-classes="['mr-2']"
                                  input-label="{{ __('controls.input.admin.email') }}"></fronds-input>
                </div>
                <div class="fronds-row col-md-12">
                    <fronds-input id="fronds-admin-login-pass"
                                  input-id="fronds-admin-pass"
                                  input-name="password"
                                  :input-label-classes="['mr-2']"
                                  input-label="{{ __('controls.input.admin.password') }}"
                                  input-type="password"></fronds-input>
                </div>


            </fronds-form>
        </div>

        <div class="fronds-row col-md-12">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <fronds-button id="fronds-admin-login-btn" btn-role="submit" btn-event-name="fronds-form-confirm"
                               btn-text="{{ __('controls.button.admin.login') }}"></fronds-button>
            </div>
        </div>
    </div>


@stop



@section('right-gutter')

    @include('layout.gutters.base-right-gutter')

@stop