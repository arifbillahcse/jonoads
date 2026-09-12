<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('code') — {{ config('app.name') }}</title>
<meta name="robots" content="noindex">
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css'])
</head>
<body>

<main class="error-page">
  <div class="section-inner error-inner">
    <p class="error-code">@yield('code')</p>
    <h1>@yield('heading')</h1>
    <p class="error-body">@yield('body')</p>
    <div class="hero-actions">
      <a href="{{ route('home') }}" class="btn btn-primary">Back to the homepage</a>
      @hasSection('secondary')
      @yield('secondary')
      @endif
    </div>
  </div>
</main>

</body>
</html>
