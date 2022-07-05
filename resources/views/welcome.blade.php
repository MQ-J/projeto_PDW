<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Backend API</title>
</head>

<body>
    <h1 class="text-center">Bem vindo ao backend.</h1>

    <div class="list-group w-25 mx-auto">
        <li class="list-group-item list-group-item-action active text-center" aria-current="true">
            Projetos alimentados por este backend
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <a href="https://github.com/MQ-J/ReactMobile" class="text-decoration-none">ReactMobile</a>
            <a href="https://mq-j.github.io/ReactMobile/dist/" class="btn btn-success rounded-pill p-1" role="button"><small>Online</small></a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <a href="https://github.com/MQ-J/DW2" class="text-decoration-none">DW2</a>
            <a href="https://mqj.dev.br/" class="btn btn-success rounded-pill p-1" role="button"><small>Online</small></a>
        </li>
    </div>

    <!-- Créditos pra quem fez o Laravel -->
    <div class="flex justify-center mt-4 sm:items-center sm:justify-between w-25 mx-auto border border-secondary rounded">
        <div class="text-center text-sm text-gray-500 sm:text-left pb-2">
            <div class="flex items-center">
                <p class="">Que tal conhecer o criador do Laravel?</p>
                <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="-mt-px text-gray-400" style="width: 25px; height: 25px;">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>

                <a href="https://laravel.bigcartel.com" class="ml-1 underline">
                    Shop
                </a>

                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="ml-4 -mt-px text-gray-400" style="width: 25px; height: 25px;">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>

                <a href="https://github.com/sponsors/taylorotwell" class="ml-1 underline">
                    Sponsor
                </a>
            </div>
        </div>

        <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>