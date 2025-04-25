<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'Laravel' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<!-- Splide Carousel -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/css/splide.min.css">
<link rel="stylesheet" href="{{asset('css/slim.min.css')}}">
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/js/splide.min.js"></script>
<!-- EasyZoom -->


<script src="{{ asset('js/slim.kickstart.min.js') }}"></script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
