@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/product-types/add" method="post" class="col-md-10">
            <h4>Добавление типа товара</h4>
            {{csrf_field()}}
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Родительская категория</p>
                </div>
                <input type="number" name="parent_id" id="inputParentNode" value="0" hidden>
                <input type="text" class="form-control" id="inputParentNodeSearch" autocomplete="off">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Название</p>
                </div>
                <input type="text" class="form-control" name="name" autocomplete="off">
            </div>

            <input type="submit" class="form-control btn-success" value="Добавить">
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $("#inputParentNodeSearch").autocomplete({
                source: "/product-types/search",
                minLength: 2,
                select: function (event, ui) {
                    this.value = ui.item.name;
                    $('#inputParentNode').val(ui.item.id);
                    return false;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputParentNodeSearch').css('background-color', '#f77777');
                    }
                    else {
                        $('#inputParentNodeSearch').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {
                return $('<li>')
                    .append("<div class='product-name-column'>" + item.name + "</div>")
                    .appendTo(ul);
            };
        });
    </script>
@endsection