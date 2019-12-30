@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <h4>Клиенты</h4>
            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Телефон</p>
                </div>
                <input type="text" class="form-control" id="inputClientSearch"
                       aria-label="Example text with button addon" aria-describedby="button-addon1">
            </div>
        </div>

        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">ФИО</th>
                <th scope="col">Телефон</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <th>
                        {{$client->name}}
                    </th>

                    <th>
                        {{$client->phone}}
                    </th>
                    <th>
                        <a href="/clients/view/{{$client->id}}" class="btn btn-success btn-select-client">
                            <span class="icon-checkmark"></span>
                        </a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <script>
        $(document).ready(function () {
            $("#inputClientSearch").autocomplete({
                source: "/clients/search",
                minLength: 2,
                select: function (event, ui) {
                   window.location = '/clients/view/' + ui.item.id;
                },
                response: function (ul, response) {
                    if (response.content.length === 0) {
                        $('#inputClientSearch').css('background-color', '#f77777');
                    }
                    else {
                        $('#inputClientSearch').css('background-color', 'white');
                    }
                }
            })
                .autocomplete("instance")._renderItem = function (ul, item) {

                return $("<li>")
                    .append("<div class='product-search-row'> "
                        + "<div>" + item.name + "</div>"
                        + "<div>" + item.phone + "</div>"
                        + "</div>"
                    )
                    .appendTo(ul);
            };
        });
    </script>
@endsection