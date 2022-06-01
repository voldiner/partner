<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Політика конфіденційності</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
          rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', Arial, Helvetica, sans-serif;
        }

        .big-row {
            background-color: #f3f6f8;

        }
        .white-col{
            background-color: white;
        }
        .font-gray{
            color: darkgrey;
            font-size: 120%;
        }
        .footer{
            background-color: #007bff;
            color: #fff;
            font-size: 90%;
        }
        .footer a{
            text-decoration: none;
            color: #fff;
        }
        .footer a:hover {
            text-decoration: none; color: #fff200;
        }
        .footer b{
            font-family: 'Roboto', Arial, Helvetica, sans-serif;
            font-weight: normal;
            font-size: 85%;
        }
    </style>
</head>
<body>
<div class="row big-row">
    <div class="col-sm-10 col-xl-6 offset-xl-3 offset-sm-1">
        <h2>Політика конфіденційності сервісу "Електронний кабінет перевізника"</h2>
    </div>
</div>

<div class="row big-row p-2">
    <div class="col-sm-10 col-xl-6 offset-xl-3 offset-sm-1 white-col p-2 shadow-sm">
        <div class="row">
            <div class="col-auto font-gray">1</div>
            <div class="col">
                <h5>Загальні положення</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">1.1</div>
            <div class="col">
                Ця Політика конфіденційності встановлює порядок отримання, зберігання, обробки, використання і розкриття персональних даних зареєстрованих учасників (далі – Користувачі)
                онлайн-сервісу  «Електронний кабінет перевізника»  за посиланнями: <a href="{{ route('welcome') }}">{{ route('welcome') }}</a> (далі – Сервіс).
            </div>
        </div>
    </div>
</div>
<div class="row big-row p-2">
    <div class="col-sm-10 col-xl-6 offset-xl-3 offset-sm-1 white-col p-2 shadow-sm">
        <div class="row">
            <div class="col-auto font-gray">2</div>
            <div class="col">
                <h5>Визначення основних термінів і понять</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">2.1</div>
            <div class="col">
                <b>Відвідувач</b> – будь-яка особа має право користуватись відкритими інформаційними розділами Сервісу, які доступні без реєстрації.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">2.2</div>
            <div class="col">
                <b>Користувач</b> – учасник електронного документообігу, який пройшов реєстрацію на веб-сайті Оператора за посиланням
                <a href="{{ route('register') }}">{{ route('register') }}</a>.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">2.3</div>
            <div class="col">
                <b>Оператор</b> – приватне акціонерне товариство «Волинське обласне підприємство автобусних станцій», власник та адміністратор Сервісу.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">2.4</div>
            <div class="col">
                <b>Первинні документи</b> – документи, які містять відомості про господарські операції, підтверджують їх здійснення та є підставою для бухгалтерського обліку таких господарських операцій.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">2.5</div>
            <div class="col">
                <b>Сервіс</b> (онлайн-сервіс «Електронний кабінет перевізника») - програмна продукція у вигляді онлайн-сервісу, призначена для автоматизації процесів електронного документообігу між Користувачами та Оператором, що передбачає надсилання, отримання та зберігання первинних документів та інших документів в електронному вигляді за посиланням – {{ url('/') }}.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">2.6</div>
            <div class="col">
                Інші терміни та визначення, що вживаються у цих Правилах, застосовуються у значеннях, наведених у Законі України «Про електронні довірчі послуги».
            </div>
        </div>
    </div>
</div>
<div class="row big-row p-2">
    <div class="col-sm-10 col-xl-6 offset-xl-3 offset-sm-1 white-col p-2 shadow-sm">
        <div class="row">
            <div class="col-auto font-gray">3</div>
            <div class="col">
                <h5>Підключення Користувача</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">3.1</div>
            <div class="col">
                До початку використання Сервісу Користувач повинен:
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">3.1.1</div>
            <div class="col">
                Ознайомитись з цими Правилами, прийняти їх та дотримуватись під час використання Сервісу;
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">3.1.2</div>
            <div class="col">
                Ознайомитися з Політикою конфіденційності, прийняти її та дотримуватись під час використання Сервісу;
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">3.1.3</div>
            <div class="col">
                Пройти реєстрацію за посиланням <a href="{{ route('register') }}">{{ route('register') }}</a>.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">3.1.4</div>
            <div class="col">
                Пройти процедуру підтвердження адреси електронної скриньки.
            </div>
        </div>

        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">3.1.5</div>
            <div class="col">
                Після реєстрації перевірити та при необхідності виправити реквізити, що завантажені з системи обліку Оператора і
                знаходяться в кабінеті Користувача в розділі НАЛАШТУВАННЯ.
            </div>
        </div>
    </div>
</div>
<div class="row big-row p-2">
    <div class="col-sm-10 col-xl-6 offset-xl-3 offset-sm-1 white-col p-2 shadow-sm">
        <div class="row">
            <div class="col-auto font-gray">4</div>
            <div class="col">
                <h5>Порядок використання Сервісу</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">4.1</div>
            <div class="col">
                Сервіс створений для:
                <ul>
                    <li>
                        Суб'єктів господарськлої діяльності, які здійснюють регулярні пасажирські перевезення автомобільним транспортом,
                        та уклали угоду про надання автостанційних послуг з Оператором
                    </li>
                    <li>
                        Інших контрагентів та партнерів Оператора.
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">4.2</div>
            <div class="col">
                Метою створення сервісу є покращення комунікації та документообороту Оператора з Користувачами, використовуючі електронні засоби взаємодії.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">4.3</div>
            <div class="col">
                Відвідувач Сервісу набуває статусу Користувача з моменту проходження реєстрації згідно п.3.1.3. Правил.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">4.4</div>
            <div class="col">
                Під час роботи в Сервісі Користувач може здійснювати наступні дії:
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">4.4.1</div>
            <div class="col">
                Перегляд актів виконаних робіт та роздрук документів чи збереження документів у форматі PDF. Також є можливість відбору необхідних документів.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">4.4.2</div>
            <div class="col">
                Перегляд відомостей проданих квитків. Є можливість роздрукувати відомість чи зберегти у форматі PDF.
                Також є можливість відбору необхідних відомостей за реквізитами та датою. Роздрук реєстра відомостей.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">4.4.3</div>
            <div class="col">
                Пошук та перегляд реквізитів квитків, що придбані на автостанціях Оператора.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">4.4.4</div>
            <div class="col">
                Перегляд та коректування реквізитів Користувача: повна назва, скорочена назва, код ЄДРПОУ, номер свідоцтва платника ПДВ,
                індивідуальний податковий номер, ідентифікаційний код, адреса, назва страхової компанії, телефон.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">4.4.5</div>
            <div class="col">
                Зміна паролю, зміна адреси електронної пошти.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">4.4.6</div>
            <div class="col">
                Відновлення втраченого паролю.
            </div>
        </div>
    </div>
</div>
<div class="row big-row p-2">
    <div class="col-sm-10 col-xl-6 offset-xl-3 offset-sm-1 white-col p-2 shadow-sm">
        <div class="row">
            <div class="col-auto font-gray">5</div>
            <div class="col">
                <h5>Плата за використання Сервісу</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">5.1</div>
            <div class="col">
                Робота в Сервісі для Користувачів безкоштовна.
            </div>
        </div>
    </div>
</div>
<div class="row big-row p-2">
    <div class="col-sm-10 col-xl-6 offset-xl-3 offset-sm-1 white-col p-2 shadow-sm">
        <div class="row">
            <div class="col-auto font-gray">6</div>
            <div class="col">
                <h5>Прикінцеві положення</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">6.1</div>
            <div class="col">
                Оператор може внести зміни у ці Правила шляхом публікації нової редакції Правил за посиланням <a
                        href="{{ route('terms') }}">{{  route('terms') }}</a> з зазначення дати такої редакції.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">6.1</div>
            <div class="col">
                Правила в новій редакції, як це зазначено в п. 6.1. набирають чинності з моменту розміщення на відповідній сторінці Сервісу.
            </div>
        </div>
        <div class="row">
            <div class="col-auto font-gray pl-3 ml-3">6.1</div>
            <div class="col">
                Оператор має право надсилати Користувачам електронні листи інформаційного характеру,
                використовуючи при цьому електронні адреси Користувачів, попередньо наданих на законних підставах Користувачами
                виключно для цілей електронного документообігу чи інформування Користувачів з питань співпраці з Оператором.
            </div>
        </div>
    </div>
</div>
@include('partials.footer_wide')
</body>
</html>