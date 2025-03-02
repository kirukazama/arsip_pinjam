<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link href="{{ asset('assets') }}/img/logo/logo-siap.png" rel="icon">
<title>{{ $title ?? 'SIAP' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
