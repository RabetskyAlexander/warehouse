@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Просмотр клиента</h4>
        <form class="row" method="post" action="/clients/update">
            {{csrf_field()}}
            <input type="text" hidden name="id" value="{{$client->id}}">
            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">ФИО</p>
                </div>
                <input type="text" class="form-control" name="name" value="{{$client->name}}">
            </div>
            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Телефон</p>
                </div>
                <input type="text" class="form-control" name="phone" value="{{$client->phone}}">
            </div>
            <button class="btn btn-success mb-3 col-md-2">Обновить</button>
        </form>


        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">Автомобиль</th>
                <th scope="col">Vin</th>
                <th scope="col"></th>
                <th scope="col">
                    <a class="btn btn-success icon-plus" href="/client-cars/add?client_id={{$client->id}}"></a>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($client->cars as $car)
                <tr>
                    <th>
                        {{$car->modification->fulldescription}}
                    </th>

                    <th>
                        {{$car->vin}}
                    </th>
                    <th>
                        <a href="/client-cars/view/{{$car->id}}" class="btn btn-warning icon-pencil"></a>
                    </th>
                    <th>
                        <a href="/client-cars/select/{{$car->id}}" class="btn btn-success icon-checkmark"></a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
