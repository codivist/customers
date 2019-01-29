@extends('core::admin.master')

@section('title', __('New customer'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'customers'])
        <h1 class="header-title">@lang('New customer')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-customers'))->multipart()->role('form') !!}
        @include('customers::admin._form')
    {!! BootForm::close() !!}

@endsection
