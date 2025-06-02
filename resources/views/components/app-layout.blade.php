<!-- resources/views/components/app-layout.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="font-sans bg-gray-100">
    <div class="min-h-screen">
        {{ $slot }}
    </div>
</body>

</html>
