@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Добавление автомобиля клиента</h4>
        <form method="post" action="/client-cars/add">
            {{csrf_field()}}
            <input type="text" hidden name="client_id" value="{{$client_id}}">


            <div class="input-group mb-3 col-md-12">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Марка</p>
                </div>
                <input type="text" class="form-control" id="inputManufactureSearch">
                <div class="input-group-prepend">
                    <input type="number" class="form-control" id="inputManufacture" readonly>
                </div>
            </div>

            <div class="input-group mb-3 col-md-12">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Модель</p>
                </div>
                <input type="text" class="form-control" id="inputModelSearch">
                <div class="input-group-prepend">
                    <input type="number" class="form-control" id="inputModel" readonly>
                </div>
            </div>

            <div class="input-group mb-3 col-md-12">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Модификация</p>
                </div>
                <input type="text" class="form-control" id="inputModificationSearch">
                <div class="input-group-prepend">
                    <input type="number" class="form-control" id="inputModification" required readonly name="passanger_car_id">
                </div>
            </div>


            <button class="btn btn-success mb-3 col-md-2">Добавить</button>
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

        });
    </script>
@endsection
