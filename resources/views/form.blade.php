<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Order form</title>
    </head>
    <body>
        <div id="app">
            <div style="text-align: center; padding: 1em;">
                🐢 Loading...
            </div>
        </div>

        <script>
            var orderFormData = @json([
                'tariffs' => $tariffs,
                'submitURL' => action('OrderController@order')
            ]);
        </script>
        <script src="{{ url('js/app.js') }}" async></script>
    </body>
</html>
