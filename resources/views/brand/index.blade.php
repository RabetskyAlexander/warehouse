@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Производители деталей</h4>
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Active</th>
            </tr>
            </thead>
            <tbody>
            @foreach($brands as $brand)
                <tr>
                    <th scope="row">
                        {{$brand->id}}
                    </th>
                    <td>
                        {{$brand->name}}
                    </td>
                    <td>
                        <input type="checkbox"
                               data-brand-id="{{$brand->id}}"
                               class="form-control input-brand-status"
                               style="height: 25px;"
                        {{ $brand->is_show === 1 ? 'checked' : '' }}
                        >
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function(){
            $('.input-brand-status').on('change', function () {
                let data = {
                    id: $(this).data('brand-id'),
                    is_show: +this.checked
                };
                updateBrand(data);
            });

            function updateBrand(data) {
                $.ajax({
                    url: 'brands/update-status',
                    data: data,
                    success: function (response) {},
                    error: function () {}
                });
            }
        });
    </script>
@endsection