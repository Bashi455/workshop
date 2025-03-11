<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ระบบบริหารหอพัก</title>


    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />

    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-800">
    @livewire('navbar')
    <div class="flex">
    <x-sidebar />
    <div class="content w-full">
        @yield('content')
    </div>
    </div>
    @livewireScripts
</body>
</html>