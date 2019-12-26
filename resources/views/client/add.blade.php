@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Добавление клиента</h4>
        <form class="row" method="post" action="/clients/add">
            {{csrf_field()}}
            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">ФИО</p>
                </div>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Телефон</p>
                </div>
                <input type="text" class="form-control" name="phone" required>
            </div>
            <button class="btn btn-success mb-3 col-md-2">Добавить</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
