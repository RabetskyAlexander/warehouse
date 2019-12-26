@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Редактирование автомобиля клиента</h4>
        <form method="post" action="/client-cars/update">
            {{csrf_field()}}
            <input type="text" hidden name="id" value="{{$car->id}}"/>


            <div class="input-group mb-3 col-md-12">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Марка</p>
                </div>
                <input type="text" class="form-control" id="inputManufactureSearch"/>
                <div class="input-group-prepend">
                    <input type="number" class="form-control" id="inputManufacture" readonly/>
                </div>
            </div>

            <div class="input-group mb-3 col-md-12">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Модель</p>
                </div>
                <input type="text" class="form-control" id="inputModelSearch"/>
                <div class="input-group-prepend">
                    <input type="number" class="form-control" id="inputModel" readonly  value="{{$car->modification->modelid}}"/>
                </div>
            </div>

            <div class="input-group mb-3 col-md-12">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Модификация</p>
                </div>
                <input type="text" class="form-control" id="inputModificationSearch" value="{{$car->modification->fulldescription}}"/>
                <div class="input-group-prepend">
                    <input
                        type="number"
                        class="form-control"
                        id="inputModification"
                        required
                        readonly
                        name="passanger_car_id"
                        value="{{$car->passanger_car_id}}"
                    />
                </div>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">VIN</p>
                </div>
                <input type="text" class="form-control" name="vin" value="{{$car->vin}}"/>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Дата выпуска</p>
                </div>
                <input type="text" class="form-control" name="year" value="{{$car->year}}"/>
            </div>

            <div class="row">
                <div class="input-group mb-3 col-md-4">
                    <div class="input-group-prepend">
                        <p class="btn btn-outline-secondary">ABS</p>
                    </div>
                    <input type="checkbox"
                           class="form-control"
                           name="abs"
                        {{ $car->abs ? 'checked' : '' }}
                    />
                </div>
                <div class="input-group mb-3 col-md-4">
                    <div class="input-group-prepend">
                        <p class="btn btn-outline-secondary">Барабаны</p>
                    </div>
                    <input type="checkbox"
                           class="form-control"
                           name="is_drum"
                        {{ $car->is_drum ? 'checked' : '' }}
                    />
                </div>
                <div class="input-group mb-3 col-md-4">
                    <div class="input-group-prepend">
                        <p class="btn btn-outline-secondary">Кондиционер</p>
                    </div>
                    <input type="checkbox"
                           class="form-control"
                           name="is_conditioner"
                           {{ $car->is_conditioner ? 'checked' : '' }}
                    />
                </div>

                <div class="block-border container">
                    <h4>Товары</h4>
                    @foreach($car->products as $product)
                        <div class="input-group mb-3 col-md-12 product-block">
                            <div class="input-group-prepend">
                                <p class="btn btn-outline-secondary">Товар</p>
                            </div>
                            <input type="text" class="form-control" value="{{$product->name . ' ' . $product->brand->name . ' ' . $product->type->name}}"/>
                            <div class="input-group-append">
                                <input type="text" class="form-control" readonly name="products[]" value="{{$product->id}}"/>
                                <button class="form-control btn-danger icon-cross btn-remove-product"></button>
                            </div>
                        </div>
                    @endforeach
                    <div class="input-group mb-3 col-md-12">
                        <div class="input-group-prepend">
                            <p class="btn btn-outline-secondary">Товар</p>
                        </div>
                        <input type="text" class="form-control" id="inputArticleSearch"/>
                        <div class="input-group-append">
                            <input type="text" class="form-control" id="inputArticle" readonly name="products[]" value="" />
                        </div>
                    </div>
                </div>

            </div>


            <button class="btn btn-success mb-3 col-md-2">Обновить</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {

            $("#inputManufactureSearch").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "/manufacturers/search",
                        data: {
                            name: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                minLength: 1,
                select: function (event, ui) {
                    this.value = ui.item.name;
                    $('#inputManufacture').val(ui.item.id);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputManufactureSearch').css('background-color', '#f77777');
                    } else {
                        $('#inputManufactureSearch').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<div class='product-search-row'> "
                        + "<div class='product-name-column'>" + item.name + "</div>"
                        + "</div>"
                    )
                    .appendTo(ul);
            };

            $("#inputModelSearch").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "/cars/models/search",
                        data: {
                            name: request.term,
                            manufacturer_id: $('#inputManufacture').val()
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                minLength: 1,
                select: function (event, ui) {
                    this.value = ui.item.name;
                    $('#inputModel').val(ui.item.id);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputModelSearch').css('background-color', '#f77777');
                    } else {
                        $('#inputModelSearch').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<div class='product-search-row'> "
                        + "<div class='product-name-column'>" + item.name + "</div>"
                        + "</div>"
                    )
                    .appendTo(ul);
            };

            $("#inputModificationSearch").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "/cars/modifications/search",
                        data: {
                            name: request.term,
                            model_id: $('#inputModel').val()
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                minLength: 2,
                select: function (event, ui) {
                    this.value = ui.item.model;
                    $('#inputModification').val(ui.item.id);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputModificationSearch').css('background-color', '#f77777');
                    } else {
                        $('#inputModificationSearch').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $("<li>")
                    .append("<div class='product-search-row'> "
                        + "<div class='product-name-column'>" + item.year + "</div>"
                        + "<div class='product-name-column'>" + item.model + "</div>"
                        + "<div class='product-name-column'>" + item.cube + "</div>"
                        + "<div class='product-name-column'>" + item.KW + "</div>"
                        + "<div class='product-name-column'>" + item.HP + "</div>"
                        + "<div class='product-name-column'>" + item.fuel + "</div>"
                        + "<div class='product-name-column'>" + item.bodyType + "</div>"
                        + "<div class='product-name-column'>" + item.engineCode + "</div>"
                        + "<div class='product-name-column'>" + item.driveType + "</div>"
                        + "</div>"
                    )
                    .appendTo(ul);
            };

            $("#inputArticleSearch").autocomplete({
                minLength: 2,
                source: function( request, response ) {
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
                    $('#inputArticle').val(ui.item.id);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputArticleSearch').css('background-color', '#f77777');
                    }
                    else {
                        $('#inputArticleSearch').css('background-color', 'white');
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

            $('.btn-remove-product').on('click', function () {
                $(this).closest('.product-block').remove();
            })

        });
    </script>
@endsection
