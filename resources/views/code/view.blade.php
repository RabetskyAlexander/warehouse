@extends('layouts.app')

@section('content')
    <div class="container">
        <div  class="col-md-5">
            {{csrf_field()}}
            <h4>Просмотр OE кода</h4>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Код</p>
                </div>
                <input type="text" class="form-control" readonly value="{{$code->name}}">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <p class="btn btn-outline-secondary">Марка</p>
                </div>

                <input
                        type="text"
                        readonly
                        class="form-control"
                        id="inputManufactureSearch"
                        value="{{$code->manufacture->description}}"
                >
            </div>

        </div>
    </div>
@endsection