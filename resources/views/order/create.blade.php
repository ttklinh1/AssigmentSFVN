@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Create') }}</div>

                    <div class="card-body">
                        <form>
                            @csrf
                            <div class="row mb-3">
                                <label for="customer_name" class="col-md-4 col-form-label text-md-end">{{ __('Customer Name') }}</label>

                                <div class="col-md-6">
                                    <input id="customer_name" type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name" value="{{ old('customer_name') }}" required autocomplete="name" autofocus>

                                    @error('customer_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    List product available
                                    <table class="table" id="product_available">
                                        <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Price</th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $product)
                                            <tr id="{{$product->id}}">
                                                <td>{{$product->name}}</td>
                                                <td>{{$product->unit}}</td>
                                                <td>{{$product->price}}</td>
                                                <td><button type="button" class="btn btn-primary" onClick="addProduct({{$product}})">Add</button></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    List product added
                                    <table class="table" id="product_add">
                                        <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    @error('products')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-primary" onClick="saveOrder()">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let arrProduct = [];

        function saveOrder() {
            if(arrProduct.length == 0){
                alert("You must add product");
                return;
            }
            for(var i =0;i<arrProduct.length;i++){
                arrProduct[i].quantity = parseInt($('#quantity-' + arrProduct[i].id).val());
            }

            $.ajax({
                type:'POST',
                url:'{{ URL::route('order-post-create') }}',
                data:{
                    'customer_name': $('#customer_name').val(),
                    'products' : arrProduct,
                    '_token': "{{ csrf_token() }}",
                }
                ,
                success:function(data) {
                    alert(data.message);
                    window.location.href = "{{ route('order')}}";
                }
            });
        }
        function addProduct(product){
            // add item in table product add
            $("#product_add").find('tbody')
                .append($('<tr id='+ product.id+'>')
                  .append($('<td>')
                        .text(product.name)
                    ) .append($('<td>')
                        .text(product.unit)
                    ) .append($('<td>')
                        .text(product.price)
                    ) .append($('<td>')
                        .append($("<input name ='quantity' id='quantity-"+ product.id+ "'/>"))
                    ).append($('<td>')
                        .append($("<button class='btn btn-danger' type='button' onClick='removeProduct("+ product.id + ") '>Remove</button>"))
                    )
                );
            arrProduct.push(product);
            // remove item from product available table
            $('table#product_available tr#'+ product.id +'').remove();
        }
        function removeProduct(id){
            let product = arrProduct.find(x => x.id === id);
            const indexOfObject = arrProduct.findIndex(object => {
                return object.id === id;
            });
            const newArr = [
                ...arrProduct.slice(0, indexOfObject),
                ...arrProduct.slice(indexOfObject + 1),
            ];
            // remove item from table product add
            $('table#product_add tr#'+ id +'').remove();
            arrProduct = newArr;
            // add item to product available table
            $("#product_available").find('tbody')
                .append($('<tr id='+ product.id+'>')
                    .append($('<td>')
                        .text(product.name)
                    ) .append($('<td>')
                        .text(product.unit)
                    ) .append($('<td>')
                        .text(product.price)
                    ) .append($('<td>')
                        .append($("<button class='btn btn-primary' type='button' onClick='addProduct("+ product + ")'>Add</button>"))
                    )
                );
        }
    </script>
@endsection

