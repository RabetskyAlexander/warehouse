@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/codes/add" method="POST" class="col-md-5">
            {{csrf_field()}}
            <h4>Добавление OE кода</h4>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Код</p>
                </div>
                <input type="text" class="form-control" name="name" autocomplete="off">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Марка</p>
                </div>
                <input type="text" class="form-control" name="manufacture_id" id="inputManufacture" hidden>

                <input type="text" class="form-control" id="inputManufactureSearch">
            </div>

            <input type="submit" class="form-control btn-success" value="Добавить">
        </form>
    </div>

    <script>
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
            minLength: 2,
            select: function (event, ui) {
                this.value = ui.item.name;
                $('#inputManufacture').val(ui.item.id);
                return false;
            },
            response: function (ul, response) {
                if (response.content.length === 0) {
                    $('#inputManufactureSearch').css('background-color', '#f77777');
                }
                else {
                    $('#inputManufactureSearch').css('background-color', 'white');
                }
            }
        })
            .autocomplete("instance")._renderItem = function (ul, item) {

            return $("<li>")
                .append("<div class='product-name-column'>" + item.name + "</div>"                )
                .appendTo(ul);
        };
    </script>
@endsection
