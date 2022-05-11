<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error 500</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Roboto Slab', serif;
        }
        .responsive {
            width: 100%;
            height: auto;
        }
        .image{
            width: 30%;
            margin-left: auto;
            margin-right: auto;

        }
        h1{
            font-size: 500%;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0px;
        }
        p{
            text-align: center;
            font-size: 120%;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>500</h1>
    <div class="image">
        <img src="{{ asset('dist/img/500.png') }}" alt="500error" class="responsive">
    </div>
    <p>Внутрішня помилка сервера</p>
    <p>Вибачте, але щось пішло не так ...</p>
    <p><a href="{{ route('welcome') }}"> Спробуйте перейти на цю сторінку</a></p>
</div>

</body>
</html>