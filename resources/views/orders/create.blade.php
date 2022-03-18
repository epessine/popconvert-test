<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Popconvert - Test</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <script defer src="{{ asset('js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    </head>

    <body class="antialiased">

        <div id="app">

            <orders-create title="@lang('Create an order')"
                           end-point="{{ route('orders.store') }}"
                           :articles="@js($articles)" />

        </div>

    </body>
</html>
