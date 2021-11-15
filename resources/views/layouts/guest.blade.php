@extends('layouts.web-simple')

@push('styles')
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/guest.css') }}">
    <script src="{{ mix('js/guest.js') }}" defer></script>
    <style>
        .min-h-screen {
            min-height: 500px;
            padding-bottom: 30px;
        }
        input, textarea, label {
            border: inherit;
        }
        .profile .shadow {
            box-shadow: none!important;
        }
    </style>
@endpush

@push('scripts')
    <!-- Scripts -->
    @livewireScripts
@endpush

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
