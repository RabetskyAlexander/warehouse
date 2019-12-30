<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>vrom.by</title>

    <link rel="icon" href="{{asset('favicon3.ico')}}">

    <link rel="stylesheet" href="{{asset('/icon/style.css')}}">

    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/preloader.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">


    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<div id="preloader" class="display-none preloader-container">
    <div class="loading-window">
        <div class="car">
            <div class="strike"></div>
            <div class="strike strike2"></div>
            <div class="strike strike3"></div>
            <div class="strike strike4"></div>
            <div class="strike strike5"></div>
            <div class="car-detail spoiler"></div>
            <div class="car-detail back"></div>
            <div class="car-detail center"></div>
            <div class="car-detail center1"></div>
            <div class="car-detail front"></div>
            <div class="car-detail wheel"></div>
            <div class="car-detail wheel wheel2"></div>
        </div>

        <div class="text">
            <span>Loading</span><span class="dots">...</span>
        </div>
    </div>
</div>

<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Пав.32
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Производители
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/manufacturers">
                                Автомобилей
                            </a>
                            <a class="dropdown-item" href="/brands">
                                Деталей
                            </a>
                        </div>
                    </li>

                    @if(Request::is('/'))
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Детальный поиск
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#modalSearchRoller">
                                    Ролик
                                </button>
                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#modalSearchAbsorber">
                                    Амортизатор крышки
                                </button>
                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#modalSearchBrakeHose">
                                    Шланг тормозной
                                </button>
                            </div>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Добавить
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="/products/add" class="dropdown-item">
                                Товар
                            </a>
                            <a href="/product-types/add" class="dropdown-item">
                                Тип товара
                            </a>
                            <a href="/brands/add" class="dropdown-item">
                                Бренд
                            </a>
                            <a href="/codes/add" class="dropdown-item">
                                OE код
                            </a>
                            <a href="/product-attribute-types/add" class="dropdown-item">
                                Тип атрибута
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Клиенты
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/clients/index">
                                Выбрать
                            </a>
                            <a class="dropdown-item" href="/clients/add">
                                Добавить
                            </a>
                        </div>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">

                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))

                    @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @if(!$errors->isEmpty())

            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</div>

@if(Request::is('/'))
    <div class="modal fade" id="modalSearchRoller" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Поиск ролика</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <p class="btn btn-outline-secondary">Ширина</p>
                        </div>
                        <input type="number" class="form-control" id="inputRollerWidth" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append">
                            <p class="btn btn-outline-secondary btn-clear">mm</p>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <p class="btn btn-outline-secondary">Высота</p>
                        </div>
                        <input type="number" class="form-control" id="inputRollerHeight" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append" id="button-addon4">
                            <p class="btn btn-outline-secondary btn-clear">mm</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" id="btnRollerSearch" class="btn btn-primary">Найти</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSearchAbsorber" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Поиск амортизатора крышки</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon1">Длинна</button>
                        </div>
                        <input type="number" class="form-control" id="inputAbsorberWidth" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append" id="button-addon4">
                            <button class="btn btn-outline-secondary btn-clear" type="button">mm</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" id="btnSearchAbsorber" class="btn btn-primary">Найти</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSearchBrakeHose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Поиск тормозного шланга</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <p class="btn btn-outline-secondary">Длинна</p>
                        </div>
                        <input type="number" class="form-control" id="inputBrakeHoseWidth" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append">
                            <p class="btn btn-outline-secondary btn-clear">mm</p>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select class="form-control" id="inputBrakeHoseType_1">
                            <option value="1">M10x1 Внешняя резьба</option>
                            <option value="2">M10x1 Внутренняя резьба </option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <select class="form-control" id="inputBrakeHoseType_2">
                            <option value="1">M10x1 Внешняя резьба</option>
                            <option value="2">M10x1 Внутренняя резьба </option>
                        </select> </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" id="btnSearchBrakeHose" class="btn btn-primary">Найти</button>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="preview-container display-none">
    <div class="preview-content">
        <img id="preview-img" src="https://car-mod.com/img/product/JPGROUP/1415201700_96984.jpg">
    </div>
</div>

<script>
    function previewInit () {
        function handlerIn(event) {
            let element = event.target;
            $('#preview-img').attr('src', element.src);
            $('.preview-container').removeClass('display-none');
        }

        function handlerOut(event) {
            $('.preview-container').addClass('display-none');
        }

        $('.search-product-table-column-img').hover(handlerIn, handlerOut);
    }
</script>

</body>
</html>
