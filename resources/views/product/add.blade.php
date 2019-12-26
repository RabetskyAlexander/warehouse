@extends('layouts.app')

@section('content')
    <div class="container block-border">
        <h4>Добавление товара</h4>
        <form style="margin-top: 20px;" action="/products/add" method="post">
            {{csrf_field()}}
            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Артикул</p>
                </div>
                <input type="text" class="form-control" autocomplete="off" name="name" required>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Бренд</p>
                </div>
                <input type="text" class="form-control" id="inputBrandSearch">
                <div class="input-group-append">
                    <input class="btn btn-danger form-control" id="inputBrand" name="brand_id" required readonly />
                </div>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Тип</p>
                </div>
                <input type="text" class="form-control" id="inputTypeSearch">
                <div class="input-group-append">
                    <input class="btn btn-danger form-control" id="inputType" name="type_id" required readonly />
                </div>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Описание</p>
                </div>
                <input type="text" class="form-control" name="description">
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Место</p>
                </div>
                <input type="text" class="form-control" name="place">
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Комментарий</p>
                </div>
                <input type="text" class="form-control" name="user_description">
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Импортер</p>
                </div>
                <select name="importer_id" class="form-control">
                    @foreach(\App\Models\Importer::all() as $importer)
                        <option value="{{$importer->id}}">
                            {{$importer->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Колличество</p>
                </div>
                <input type="number" class="form-control" name="count" required>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Цена</p>
                </div>
                <input type="number" step="any" class="form-control" name="price" required>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Дата закупки</p>
                </div>
                <input type="date" class="form-control" name="date" value="{{date('Y-m-d')}}" required>
            </div>

            <input type="submit" class="btn btn-success" value="Сохранить">
        </form>
    </div>

    <script>
        $(document).ready(function () {

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
        });
    </script>
@endsection
