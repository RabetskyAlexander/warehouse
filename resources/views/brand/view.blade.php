@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/brand/add" method="GET" class="col-md-5">
            <h4>Просмотр бренда</h4>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">Название</button>
                </div>
                <input type="text" class="form-control" name="name" readonly autocomplete="off" value="{{$brand->name}}">
            </div>
        </form>
    </div>
@endsection