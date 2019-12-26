@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/brands/add" method="POST" class="col-md-5">
            {{csrf_field()}}
            <h4>Добавление бренда</h4>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">Название</button>
                </div>
                <input type="text" class="form-control" name="name" autocomplete="off" required>
            </div>
            <input type="submit" class="form-control btn-success" value="Добавить">
        </form>
    </div>
@endsection