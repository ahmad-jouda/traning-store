{{-- Flash Message Start--}}

{{--
@if (isset($title))
<div class="alert alert-{{ $type ?? 'info' }}">
    <h4>{{ $title }}</h4>
    <p class="fs-5">{{ $slot }}</p>
    {{ $actions }}
    {{ $url }}
</div>
@endif
--}}

@if(session()->has('success'))
<div class="alert alert-success">
    {{session()->get('success')}}
    {{-- {{session(success)}}--}}
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger">
    {{session()->get('error')}}
    {{-- {{session(success)}}--}}
</div>
@endif

@if(session()->has('warning'))
<div class="alert alert-warning">
    {{session()->get('warning')}}
    {{-- {{session(success)}}--}}
</div>
@endif

@if(session()->has('info'))
<div class="alert alert-info">
    {{session()->get('info')}}
    {{-- {{session(success)}}--}}
</div>
@endif

{{-- Flash Message End--}}