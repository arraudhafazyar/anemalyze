@props(['title'])

<!DOCTYPE html>
<html lang="en" class="font-poppins">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>{{$title}}</title>
</head>
<body>
    {{ $slot }}
</body>
</html>
