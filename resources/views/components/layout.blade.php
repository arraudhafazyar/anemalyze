@props(['title'])

<!DOCTYPE html>
<html lang="en" class="font-poppins">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{$title}}</title>
</head>
<body>
    {{ $slot }}
</body>
</html>

{{-- <script>
    const input = document.getElementById('tanggal');
    input.addEventListener('input', function() {
        if (this.value.trim() !== "") {
        this.classList.remove('border-gray-300');
        this.classList.add('border-blue-500');
        } else {
        this.classList.remove('border-blue-500');
        this.classList.add('border-gray-300');
        }
    });
    </script> --}}
