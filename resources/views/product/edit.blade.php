@extends('layouts.app')

@section('content')
    <div class="container block-border">

        <form class="col-sm-12 col-lg-6 col-md-6 mb-3 block-border" action="/products/copy" method="GET">
            <h4>Копирование товара</h4>
            <div class="input-group col-md-12">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Артикул</p>
                </div>
                <input type="text" name="product_id" id="inputProductId" value="{{$product->id}}" hidden>
                <input type="text" name="product_copy_id" id="inputProductCopyId" hidden>
                <input type="text" class="form-control" id="inputProductCopySearch">
                <div class="input-group-append">
                    <button class="btn btn-danger form-control">Скопировать</button>
                </div>
            </div>
        </form>

        <h4>Редактирование товара</h4>
        <form style="margin-top: 20px;" action="/products/update" method="get">
            <input type="text" hidden name="id" value="{{$product->id}}">
            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Артикул</p>
                </div>
                <input type="text" class="form-control" autocomplete="off" name="name" value="{{$product->name}}">
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Бренд</p>
                </div>
                <input type="text" class="form-control" id="inputBrandSearch" value="{{$product->brand->name}}">
                <div class="input-group-append" id="button-addon2">
                    <input class="btn btn-danger form-control" id="inputBrand" name="brand_id" value="{{$product->brand_id}}" required readonly />
                </div>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Тип</p>
                </div>
                <input type="text" class="form-control" id="inputTypeSearch" value="{{$product->type->name}}">
                <div class="input-group-append" id="button-addon2">
                    <input class="btn btn-danger form-control" id="inputType" name="type_id" required readonly  value="{{$product->type_id}}" />
                </div>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Описание</p>
                </div>
                <input type="text" class="form-control" name="description" value="{{$product->description}}">
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Место</p>
                </div>
                <input type="text" class="form-control" name="place" value="{{$product->place}}">
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Комментарий</p>
                </div>
                <input type="text" class="form-control" name="user_description" value="{{$product->user_description}}">
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Импортер</p>
                </div>
                <select name="importer_id" class="form-control">
                    <option value="">Не указан</option>
                    @foreach($importers as $importer)
                        <option value="{{$importer->id}}" {{$importer->id === $product->importer_id ? 'selected' : ''}}>
                            {{$importer->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Колличество</p>
                </div>
                <input type="number" class="form-control" name="count" value="{{$product->count}}">
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Цена</p>
                </div>
                <?php $money = \App\Models\ExchangeRates::query()->first(); ?>
                <input type="number" class="form-control" name="price" value="{{$product->price * $money->euro}}">
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Дата закупки</p>
                </div>
                <input type="date" class="form-control" name="date" value="{{$product->date}}">
            </div>

            <input type="submit" class="btn btn-success" value="Сохранить">
        </form>

    </div>

    <div class="container block-border">
        <div class="row mb-3">
            <h4 class="col-md-6">Кроссы</h4>
            <div class="input-group col-md-6">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">Артикул</button>
                </div>
                <input type="text" id="inputArticleCross" hidden>
                <input type="text" class="form-control" id="inputArticleSearchCross">
                <div class="input-group-append">
                    <input class="btn btn-success" type="submit" id="btnAddCross" value="Добавить"/>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">Артикул</th>
                <th scope="col">Бренд</th>
                <th scope="col">Тип</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($product->crosses as $cross)
                @if($cross->product)
                    <tr>
                        <th>
                            {{$cross->product->name}}
                        </th>
                        <th>
                            {{$cross->product->brand->name}}
                        </th>
                        <th>
                            {{$cross->product->type->name}}
                        </th>
                        <th>
                            <button
                                    data-cross_id="{{$cross->cross_id}}"
                                    class="btn btn-danger btn-remove-cross"
                            >
                                Удалить
                            </button>
                        </th>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="container block-border">
        <div class="row mb-3">
            <h4 class="col-md-6">OE коды</h4>
            <div class="input-group col-md-6">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">OE код</button>
                </div>
                <input type="text" id="inputCode" hidden>
                <input type="text" class="form-control" id="inputCodeSearch">
                <div class="input-group-append">
                    <input class="btn btn-success" id="btnProductCodeAdd" type="submit" value="Добавить"/>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">Код</th>
                <th scope="col">Бренд</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($product->codes as $code)
                <tr>
                    <th>
                        {{$code->name}}
                    </th>

                    <th>
                        {{$code->manufacture->description}}
                    </th>

                    <th>
                        <button
                                data-code_id="{{$code->id}}"
                                class="btn btn-danger btn-remove-code"
                        >
                            Удалить
                        </button>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="container block-border">
        <div class="row mb-3">
            <h4 class="col-md-6">Атрибуты</h4>
            <div class="col-md-6">
                <div class="input-group col-md-12">
                    <div class="input-group-prepend">
                        <p class="btn btn-outline-secondary">Тип</p>
                    </div>
                    <input type="text" id="inputProductAttribute" hidden>
                    <input type="text" id="inputProductAttributeSearch" class="form-control">
                </div>
                <div class="input-group col-md-12">
                    <div class="input-group-prepend">
                        <p class="btn btn-outline-secondary">Значение</p>
                    </div>
                    <input type="text" class="form-control" id="inputProductAttributeValue">
                </div>
                <button class="btn btn-success" style="float: right;" id="btnProductAttributeAdd">Добавить</button>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Значение</th>
            </tr>
            </thead>
            <tbody>
            @foreach($product->attributes as $attribute)
                <tr>
                    <th>
                        {{$attribute->type ? $attribute->type->name : 'не найден'}}
                    </th>

                    <th>
                        {{$attribute->display_value}}
                    </th>

                    <th>
                        <button
                                data-attribute_id="{{$attribute->id}}"
                                class="btn btn-danger btn-remove-attribute"
                        >
                            Удалить
                        </button>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="container block-border">
        <form class="row mb-3" action="/products/image/add" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <h4 class="col-md-6">Изображение</h4>
            <div class="input-group col-md-6">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">Добавление изображения</button>
                </div>
                <input type="number" hidden class="form-control" name="product_id" value="{{$product->id}}">
                <input type="file" class="form-control" name="file">
                <div class="input-group-append">
                    <input class="btn btn-success" type="submit" value="Добавить"/>
                </div>
            </div>
        </form>

        <div class="container">
            @foreach($product->images as $image)
                <div class="col-md-3">
                    <span class="btn-remove-img icon-cross" data-image_id="{{$image->id}}"></span>
                    <img style="width: 100%;"  src="/images/{{ $product->brand_id . '/' . $image->src}}" alt="">
                </div>
            @endforeach
        </div>

    </div>


    <script>
        $(document).ready(function () {

            $("#inputProductCopySearch").autocomplete({
                source: "/products/search",
                minLength: 2,
                select: function (event, ui) {
                    $('#inputProductCopyId').val(ui.item.id);
                    this.value = ui.item.name;
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputProductCopySearch').css('background-color', '#f77777');
                    }
                    else {
                        $('#inputProductCopySearch').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $('<li>')
                    .append("<div class='product-search-row'> "
                        + "<div class='product-name-column'>" + item.name + "</div>"
                        + "<div>" + item.brandName + "</div>"
                        + "<div>" + (item.typeName ? item.typeName : '') + "</div>"
                        + "</div>"
                    )
                    .appendTo(ul);
            };

            $("#inputBrandSearch").autocomplete({
                source: "/brands/search",
                minLength: 2,
                select: function (event, ui) {
                    $('#inputBrand').val(ui.item.id);
                    $('#inputBrand').removeClass('btn-danger');
                    $('#inputBrand').addClass('btn-success');
                    this.value = ui.item.name;
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputBrandSearch').css('background-color', '#f77777');
                    }
                    else {
                        $('#inputBrandSearch').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $('<li>' + item.name + '</li>')
                    .appendTo(ul);
            };

            $("#inputTypeSearch").autocomplete({
                source: "/product-types/search",
                minLength: 2,
                select: function (event, ui) {
                    $('#inputType').val(ui.item.id);
                    $('#inputType').removeClass('btn-danger');
                    $('#inputType').addClass('btn-success');
                    this.value = ui.item.name;
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputTypeSearch').css('background-color', '#f77777');
                    }
                    else {
                        $('#inputTypeSearch').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $('<li>' + item.name + '</li>')
                    .appendTo(ul);
            };

            $("#inputCodeSearch").autocomplete({
                source: "/codes/search",
                minLength: 2,
                select: function (event, ui) {
                    this.value = ui.item.name;
                    $('#inputCode').val(ui.item.id);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputCodeSearch').css('background-color', '#f77777');
                    }
                    else {
                        $('#inputCodeSearch').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $('<li>')
                    .append("<div class='product-search-row'> "
                        + "<div class='product-name-column'>" + item.name + "</div>"
                        + "<div>" + item.brandName + "</div>"
                        + "</div>"
                    )
                    .appendTo(ul);
            };

            $("#inputProductAttributeSearch").autocomplete({
                source: "/product-attributes/search",
                minLength: 2,
                select: function (event, ui) {
                    this.value = ui.item.name;
                    $('#inputProductAttribute').val(ui.item.id);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputProductAttributeSearch').css('background-color', '#f77777');
                    }
                    else {
                        $('#inputProductAttributeSearch').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $('<li>')
                    .append("<div class='product-name-column'>" + item.name + "</div>")
                    .appendTo(ul);
            };

            $("#inputArticleSearchCross").autocomplete({
                source: "/products/search",
                minLength: 2,
                select: function (event, ui) {
                    this.value = ui.item.name;
                    $('#inputArticleCross').val(ui.item.id);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputArticleSearchCross').css('background-color', '#f77777');
                    }
                    else {
                        $('#inputArticleSearchCross').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $('<li>')
                    .append("<div class='product-search-row'> "
                        + "<div class='product-name-column'>" + item.name + "</div>"
                        + "<div>" + item.brandName + "</div>"
                        + "<div>" + (item.typeName ? item.typeName : '') + "</div>"
                        + "</div>"
                    )
                    .appendTo(ul);
            };

            $('#btnAddCross').on('click', function () {
                let data = {
                    product_id: $('#inputProductId').val(),
                    cross_id: $('#inputArticleCross').val()
                };
                if (data.product_id && data.cross_id) {
                    $.ajax({
                        url: '/crosses/add',
                        data,
                        method: 'get',
                        success: function (response) {
                            window.location.reload();
                        },
                        error: function () {

                        }
                    });
                }
            });

            $('.btn-remove-cross').on('click', function () {
                let data = {
                    cross_id: $(this).data('cross_id'),
                    product_id: $('#inputProductId').val()
                };
                if (data.cross_id && data.product_id) {
                    $.ajax({
                        url: '/crosses/remove',
                        data,
                        success: function () {
                            window.location.reload();
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            });

            $('.btn-remove-code').on('click', function () {
                let data = {
                    code_id: $(this).data('code_id'),
                    product_id: $('#inputProductId').val()
                };

                $.ajax({
                    url: '/products/code/remove',
                    data,
                    success: function () {
                        window.location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $('.btn-remove-attribute').on('click', function () {
                let data = {
                    id: $(this).data('attribute_id')
                };
                if (data.id) {
                    $.ajax({
                        url: '/product-attributes/remove',
                        data,
                        success: function () {
                            window.location.reload();
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            });

            $('#btnProductCodeAdd').on('click', function () {
               let data = {
                   code_id: $('#inputCode').val(),
                   product_id: $('#inputProductId').val()
               };

               $.ajax({
                   url: '/products/code/add',
                   data,
                   success: function () {
                        window.location.reload();
                   },
                   error: function() {

                   }
               });
            });

            $('#btnProductAttributeAdd').on('click', function () {
                let data = {
                    product_attribute_type_id: $('#inputProductAttribute').val(),
                    value: $('#inputProductAttributeValue').val(),
                    product_id: $('#inputProductId').val()
                };

                $.ajax({
                    url: '/product-attributes/add',
                    data,
                    success: function () {
                        window.location.reload();
                    },
                    error: function() {

                    }
                });
            });

            $('.btn-remove-img').on('click', function () {
                let data = {
                    image_id: $(this).data('image_id')
                };

                $.ajax({
                    url: '/products/image/remove',
                    data,
                    success: function () {
                        window.location.reload();
                    },
                    error: function() {

                    }
                });
            });


        });
    </script>
@endsection
