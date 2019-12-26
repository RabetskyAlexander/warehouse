@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-5">
            <h4>Просмотр типа атрибута</h4>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">Название</button>
                </div>
                <input type="text"
                       class="form-control"
                       name="name"
                       readonly
                       value="{{$productAttributeType->name}}"
                >
            </div>
        </div>
    </div>
@endsection