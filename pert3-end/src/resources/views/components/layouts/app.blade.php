<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('components.partials.header')


<body>
@include('components.partials.navbar')
<!-- navigation -->

<!-- /navigation -->

{{ $slot }}


@include('components.partials.footer')

</body>
@include('components.partials.scripts')
</html>