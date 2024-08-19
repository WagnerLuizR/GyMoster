@extends(backpack_view('blank'))
@php

    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'wrapper_class' => 'd-flex justify-content-center', // Centraliza o widget
        'heading_class' => 'display-3 text-center '.(backpack_theme_config('layout') === 'horizontal_overlap' ? ' text-white' : ''),
        'content_class' => 'text-center '.(backpack_theme_config('layout') === 'horizontal_overlap' ? 'text-white' : ''),
    ];


@endphp

@section('content')
    <div style="text-align: center;">
        <img src="https://preview.tabler.io/static/illustrations/light/weightlifting.png" alt="weightlifting"
             style="align-content: center; width: 70%; max-width: 70%;">
    </div>
@endsection
