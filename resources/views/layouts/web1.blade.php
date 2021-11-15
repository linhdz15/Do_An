@extends('layouts.web-simple')

@section('content')
    @include('web.components.header')

    <main id="app">
        {{ $slot }}
    </main>

    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <span class="fas fa-angle-up"></span>
        </span>
    </div>

    @stack('modals')

    @include('web.components.footer')
@endsection
