<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My News Website')</title>
    <!-- You would link your CSS/JS assets here -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; background: #f9f9f9; margin: 0; }
        .container { max-width: 960px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .header nav { margin-top: 10px; }
        .header nav a { text-decoration: none; color: #007bff; margin-right: 15px; font-weight: 500; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #888; }
    </style>
</head>
<body>

<div class="container">
    <header class="header">
        <h1><a href="{{ route('web.home') }}" style="text-decoration: none; color: #333;">My News Site</a></h1>
        <nav>
            <a href="{{ route('web.home') }}">Home</a>
            <a href="{{ route('web.news.index') }}">News</a>
            <a href="{{ route('web.categories.index') }}">Categories</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> My News Website. All rights reserved.</p>
    </footer>
</div>

</body>
</html>
