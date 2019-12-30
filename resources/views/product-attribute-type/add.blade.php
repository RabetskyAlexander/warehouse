@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/product-attribute-types/add" method="post" class="col-md-5">
            {{csrf_field()}}
            <h4>Добавление нового типа атрибута</h4>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Название</p>
                </div>
                <input type="text" class="form-control" name="name" autocomplete="off" required>
            </div>
            <input type="submit" class="form-control btn-success" value="Добавить">
        </form>
    </div>
@endsection