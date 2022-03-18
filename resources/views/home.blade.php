<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Popconvert - Test</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        
        <script defer src="{{ asset('js/app.js') }}"></script>
    </head>

    <body class="antialiased">

        <div id="app">
            
            <home link="{{ route('orders.create') }}"
                  text="@lang('Create an order')" />

        </div>

    </body>
</html>
