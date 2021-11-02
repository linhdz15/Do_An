@php
    $messages = [];
    if (session()->has('message')) {
        $messages[] = [
            'class' => 'alert-success',
            'content' => session('message'),
        ];
    }
    if (session()->has('error')) {
        $messages[] = [
            'class' => 'alert-danger',
            'content' => session('error'),
        ];
    }
    if (session()->has('warning')) {
        $messages[] = [
            'class' => 'alert-warning',
            'content' => session('warning'),
        ];
    }
    if (session()->has('action')) {
        $messages[] = [
            'class' => 'alert-danger',
            'content' => session('action'),
        ];
    }
@endphp

@foreach ($messages as $message)
    <div class="alert alert-dismissible {{ $message['class'] }}">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span>{{ $message['content'] }}</span>
    </div>
@endforeach
