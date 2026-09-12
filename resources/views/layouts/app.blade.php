<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', config('app.name'))</title>
<meta name="description" content="@yield('description')">
@include('partials.meta')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- First stop for a keyboard or screen-reader user: skip the nav. --}}
<a href="#main" class="skip-link">Skip to content</a>

@include('partials.header')

<main id="main" tabindex="-1">

@yield('content')
</main>

@include('partials.footer')

</body>
</html>
