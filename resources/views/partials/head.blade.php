<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'Laravel' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<!-- Dropzone CSS -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"/>

<!-- Dropzone JS -->
<link rel="stylesheet" href="{{ asset('css/slim.min.css') }}">

<script src="{{ asset('js/slim.kickstart.min.js') }}"></script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
