@extends('layouts.main')
@section('content')
    <div class="col-count-6">
        @foreach($categories as $category)
            <a class="categories-products" href="javascript:;" data-alias="{{$category->alias}}">{{$category->title}}</a><br/>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-10 m-auto text-center">

            <table class="table table-responsive">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">title</th>
                    <th scope="col">image</th>
                    <th scope="col">description</th>
                    <th scope="col">first_invoice</th>
                    <th scope="col">url</th>
                    <th scope="col">price</th>
                    <th scope="col">amount</th>
                    <th class="text-left" scope="col">offers</th>
                    <th class="text-left" scope="col">categories</th>
                </tr>
                </thead>
                <tbody id="productsResult">
                    @include('pages.products.items')
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            var xhr;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });

            $("input[name='search_products']").on('change', function () {
                var value = $(this).val();
                if(xhr && xhr.readyState != 4){
                    xhr.abort();
                }

                xhr = $.ajax({
                    url: "{{route('products.search')}}",
                    method: 'GET',
                    data: {search:value, _token:_token},
                    success: function(data) {
                        console.log(data.result);
                        $("#productsResult").html(data.result);
                    }
                });
            })

            $(".categories-products").on('click', function () {
                var value = $(this).data('alias');
                if(xhr && xhr.readyState != 4){
                    xhr.abort();
                }

                xhr = $.ajax({
                    url: "{{route('products.search')}}",
                    method: 'GET',
                    data: {category:value, _token:_token},
                    success: function(data) {
                        $("#productsResult").html(data.result);
                    }
                });
            })
        })
    </script>
@endsection
