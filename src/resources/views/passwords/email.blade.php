@extends('core::admin.master')

@section('title', __('Reset Password'))

@section('page-header')
@endsection
@section('sidebar')
@endsection
@section('mainClass')
@endsection
@section('errors')
@endsection

@section('content')

<div id="reset" class="container-reset container-xs-center">

    @include('users::_status', ['closable' => false])

    {!! BootForm::open()->action(url('password/email')) !!}

        <h1>{{ __('Reset Password') }}</h1>

        {!! BootForm::email(__('Email'), 'email')->addClass('form-control input-lg')->autofocus(true) !!}

        <div class="form-group form-action">
            {!! BootForm::submit(__('Send password reset link'), 'btn-primary')->addClass('btn-lg btn-block') !!}
        </div>

    {!! BootForm::close() !!}

</div>

@endsection
