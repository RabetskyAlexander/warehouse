@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10">
            <h4>Просмотр типа товара</h4>
            {{csrf_field()}}
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Родительская категория</p>
                </div>
                <input type="text" class="form-control" readonly
                       value="{{$productType->parent ? $productType->parent->name : ''}}"
                               >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Название</p>
                </div>
                <input type="text" class="form-control" readonly value="{{$productType->name}}">
            </div>
        </div>
    </div>
@endsection