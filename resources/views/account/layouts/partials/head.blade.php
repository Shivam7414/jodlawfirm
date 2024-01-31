<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>{{ config('app.name' ?? 'Laravel') }}</title>
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset(config('app.favicon')) }}">
<link rel="icon" type="image/png" href="{{ asset(config('app.favicon')) }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" rel="stylesheet" />
<link href= {{ asset('assets/css/nucleo-icons.css') }} rel="stylesheet" />
<link href= {{ asset('assets/css/nucleo-svg.css') }} rel="stylesheet" />
<link href="{{ asset('assets/css/fontawsome.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" id="pagestyle"/>