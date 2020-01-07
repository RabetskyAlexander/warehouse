@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary">Артикул</button>
                    </div>
                    <input type="text" class="form-control" id="inputArticle">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-clear-article">X</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button">OE код</button>
                    </div>
                    <input type="text" class="form-control" id="inputCode">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-clear-code">X</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button">Тип</button>
                    </div>
                    <input type="text" class="form-control" id="inputType">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-clear-type">X</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th scope="col">Артикул</th>
            <th scope="col">Артикул</th>
            <th scope="col">Бренд</th>
            <th scope="col">Тип</th>
            <th scope="col">Описание</th>
            <th scope="col">Поставщик</th>
            <th scope="col">Закупка</th>
            <th scope="col">Место</th>
            <th scope="col">Комментарий</th>
            <th scope="col">Учет</th>
            <th scope="col">Шт</th>
            <th scope="col">Цена</th>
        </tr>
        </thead>
        <tbody id="productTableBody">
        </tbody>
    </table>

    @isset($car)
        <input type="hidden" id="inputCar" value="{{$car->id}}">
        <div class="right-side-bar">
        <div>
            <a href="/clients/unselect" class="btn btn-danger icon-cross"></a>
            <a href="/clients/view/{{$car->client_id}}" class="btn btn-warning icon-pencil"></a>

            <div style="display: flex; justify-content: center;">
                <h4>Клиент</h4>
            </div>
            <div>
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary icon-user"></button>
                        </div>
                        <input type="text" class="form-control" readonly value="{{$car->client->name}}"/>
                    </div>
                </div>
            </div>
            <div>
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary icon-phone"></button>
                        </div>
                        <input type="text" class="form-control" readonly value="{{$car->client->phone}}"/>
                    </div>
                </div>
            </div>

            <div>
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary">Модификация</button>
                        </div>
                        <input type="text" class="form-control" readonly
                               value="{{$car->modification->fulldescription}}"/>
                    </div>
                </div>
            </div>

            <div>
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary">vin</button>
                        </div>
                        <input type="text" class="form-control" readonly value="{{$car->vin}}"/>
                    </div>
                </div>
            </div>

            <div>
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary">Год</button>
                        </div>
                        <input type="text" class="form-control" readonly
                               value="{{$car->yaer ?: $car->modification->constructioninterval}}"/>
                    </div>
                </div>
            </div>

            <div style="display:flex; justify-content: space-around">
                <div class="input-group-item">
                    <button class="btn btn-outline-secondary">Барабаны</button>
                    <input type="checkbox" class="input-check-box" readonly {{$car->is_drum ? 'checked' : ''}}/>
                </div>
                <div class="input-group-item">
                    <button class="btn btn-outline-secondary">ABS</button>
                    <input type="checkbox" class="input-check-box" readonly {{$car->abs ? 'checked' : ''}}/>
                </div>
                <div class="input-group-item">
                    <button class="btn btn-outline-secondary">Кондиционер</button>
                    <input type="checkbox" class="input-check-box" readonly {{$car->is_conditioner ? 'checked' : ''}}/>
                </div>
            </div>
        </div>

        <div class="container table-client-car-products">
            @foreach($car->products as $product)
                <div class="input-group" style="margin: 0px !important;">
                    <div class="input-group-prepend">
                        <p class="btn btn-outline-secondary form-control">
                            {{$product->type->name}}
                        </p>
                    </div>
                    <button class="btn btn-outline-secondary form-control btn-product" data-id="{{$product->id}}">
                        {{$product->name}}
                    </button>
                </div>
            @endforeach
        </div>

    </div>
    @endisset



    <script>
        $(document).ready(function () {

            $("#inputType").autocomplete({
                source: "/product-types/search",
                minLength: 2,
                select: function (event, ui) {
                    this.value = ui.item.name;
                    loadByTypeId(ui.item.id);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputType').css('background-color', '#f77777');
                    }
                    else {
                        $('#inputType').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $('<li class="product-type-search-row">' + item.name + '</li>')
                    .appendTo(ul);
            };

            $("#inputArticle").autocomplete({
                minLength: 2,
                source: function (request, response) {
                    $.ajax({
                        url: "/products/search",
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    this.value = ui.item.name;
                    loadByProductId(ui.item.id);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputArticle').css('background-color', '#f77777');
                    } else {
                        $('#inputArticle').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {

                return $("<li>")
                    .append("<div class='product-search-row'> "
                        + "<div class='product-name-column'>" + item.name + "</div>"
                        + "<div>" + item.brandName + "</div>"
                        + "<div>" + (item.typeName ? item.typeName : '') + "</div>"
                        + "</div>"
                    )
                    .appendTo(ul);
            };

            $("#inputCode").autocomplete({
                source: "/codes/search",
                minLength: 2,
                select: function (event, ui) {
                    this.value = ui.item.name;
                    data = {
                        code_id: ui.item.id
                    };
                    loadByCodeId(data);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputCode').css('background-color', '#f77777');
                    } else {
                        $('#inputCode').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {

                return $("<li>")
                    .append("<div class='product-search-row'> "
                        + "<div class='product-name-column'>" + item.name + "</div>"
                        + "<div>" + item.brandName + "</div>"
                        + "<div>" + (item.typeName ? item.typeName : '') + "</div>"
                        + "</div>"
                    )
                    .appendTo(ul);
            };

            $('.btn-product').on('click', function () {
                loadByProductId($(this).data('id'));
            });

            function loadByProductId(productId) {
                let data = {
                    product_id: productId
                };
                preloaderShow();
                $.ajax({
                    url: '/products/get/analog/product-id',
                    data: data,
                    method: 'get',
                    success: function (response) {
                        renderProducts(response);
                        preloaderHide();
                    },
                    error: function () {
                        preloaderHide();
                    }
                });
            }

            function loadByTypeId(typeId) {
                let data = {
                    type_id: typeId
                };
                preloaderShow();
                $.ajax({
                    url: '/products/get/analog/type-id',
                    data: data,
                    method: 'get',
                    success: function (response) {
                        renderProducts(response);
                        preloaderHide();
                    },
                    error: function () {
                        preloaderHide();
                    }
                });
            }

            function loadByCodeId(data) {
                preloaderShow();
                $.ajax({
                    url: '/products/get/analog/code-id/',
                    data: data,
                    method: 'get',
                    success: function (response) {
                        renderProducts(response);
                        preloaderHide();
                    },
                    error: function () {
                        preloaderHide();
                    }
                });
            }

            function renderProducts(data) {
                $('.table-product-row').remove();
                data.forEach(function (item) {

                    let row = $('<tr class="table-product-row"></tr>');
                    if (item.count > 0) {
                        row.addClass('product-in-stock');
                    }
                    let client = $('#inputCar').val();
                    let block = ' ';
                    if (client){
                        block = '<button class="btn btn-success btn-client-product-add" data-id="'+ item.id +'"><span class="icon-plus"></span></button>';
                    }
                    row.append(
                        '<th>'
                        + '<img class="search-product-table-column-img" onerror="this.onerror=null; this.src=`/images/no_photo.jpg`" src="' + item.image + '" />'
                        + '</th>'
                        + '<th>' + item.name + '</th>'
                        + '<th>' + item.brandName + '</th>'
                        + '<th>' + item.typeName + '</th>'
                        + '<th>' + (item.description ? item.description : ' ') + '</th>'
                        + '<th>' + (item.importerName ? item.importerName : ' ') + '</th>'
                        + '<th>' + item.price + '</th>'
                        + '<th>' + (item.place ? item.place : ' ') + '</th>'
                        + '<th>' + (item.descriptionClient ? item.descriptionClient : ' ') + '</th>'
                        + '<th>'
                        + '<form style="display: flex;">'
                        + '<input name="id" type="hidden" value=' + item.id + ' />'
                        + '<input name="count" style="width: 50px;" class="count-input-new form-control" type="number" value=' + item.countNew + ' />'
                        + '<input type="submit" class="btn-update-count btn-success btn" value="save"/>'
                        + '</form>'
                        + '</th>'
                        + '<th>' + item.count + '</th>'
                        + '<th>' + item.price + '</th>'
                        + '<th>' +
                        block +
                        '<a href="products/edit/' + item.id + '" class="btn btn-warning"><span class="icon-pencil"></span></a>' +
                        '</th>'
                    );

                    $('#productTableBody').append(row);

                });
                previewInit();
            }

            $('.btn-clear-article').on('click', function () {
                $('#inputArticle').val('');
            });

            $('.btn-clear-code').on('click', function () {
                $('#inputCode').val('');
            });

            $('.btn-clear-type').on('click', function () {
                $('#inputType').val('');
            });



            $('#btnRollerSearch').on('click', function () {
                let data = {
                    width: $('#inputRollerWidth').val(),
                    height: $('#inputRollerHeight').val()
                };

                preloaderShow();
                $.ajax({
                    url: '/products/roller-search',
                    data: data,
                    success: function (response) {
                        renderProducts(response);
                        $('#modalSearchRoller').modal('hide');
                        preloaderHide();
                    },
                    error: function (error) {
                        $('#modalSearchRoller').modal('hide');
                        preloaderHide();
                    }
                });
            });

            $('#btnSearchAbsorber').on('click', function () {
                let data = {
                    width: $('#inputAbsorberWidth').val()
                };
                preloaderShow();
                $.ajax({
                    url: '/products/absorber-search',
                    data: data,
                    success: function (response) {
                        renderProducts(response);
                        $('#modalSearchAbsorber').modal('hide');
                        preloaderHide();
                    },
                    error: function (error) {
                        $('#modalSearchAbsorber').modal('hide');
                        preloaderHide();
                    }
                });
            });

            $('#btnSearchBrakeHose').on('click', function () {
                let data = {
                    width: $('#inputBrakeHoseWidth').val(),
                    type_1: $('#inputBrakeHoseType_1').val(),
                    type_2: $('#inputBrakeHoseType_2').val()
                };
                preloaderShow();
                $.ajax({
                    url: '/products/break-horse-search',
                    data: data,
                    success: function (response) {
                        renderProducts(response);
                        $('#modalSearchBrakeHose').modal('hide');
                        preloaderHide();
                    },
                    error: function (error) {
                        $('#modalSearchBrakeHose').modal('hide');
                        preloaderHide();
                    }
                });
            });

            function preloaderShow() {
                $('#preloader').removeClass('display-none');
            }

            function preloaderHide() {
                $('#preloader').addClass('display-none');
            }

            $('#productTableBody').on('click', function (event) {
                let element = event.target;
                if ($(element).hasClass('btn-client-product-add'))
                {
                    let data = {
                        client_car_id: $('#inputCar').val(),
                        product_id: $(element).data('id')
                    };
                    $.ajax({
                        'method': 'get',
                        url: '/client-cars/product/add',
                        data: data,
                        success: function (response) {

                        },
                        error: function (error) {

                        }
                    });
                }
                if ($(element).hasClass('btn-update-count'))
                {
                    event.preventDefault();
                    let data = $(event.target).closest('form').serialize();
                    console.log(data);
                    $.ajax({
                        'method': 'get',
                        url: '/products/count-update',
                        data: data,
                        success: function (response) {

                        },
                        error: function (error) {

                        }
                    });
                }
            });


        });
    </script>
@endsection
