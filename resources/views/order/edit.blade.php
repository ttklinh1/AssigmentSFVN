@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Edit') }}</div>

                    <div class="card-body">
                        <form>
                            @csrf
                            <div class="row mb-3">
                                <label for="customer_name" class="col-md-4 col-form-label text-md-end">{{ __('Customer Name') }}</label>

                                <div class="col-md-6">
                                    <input id="customer_name" value = "{{$order->customer_name}}" type="text" class="form-control @error('customer_name') is-invalid @enderror" name="name" value="{{ old('customer_name') }}" required autocomplete="name" autofocus>

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
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $product)
                                            <tr id="{{$product['id']}}">
                                                <td>{{$product['name']}}</td>
                                                <td>{{$product['unit']}}</td>
                                                <td>{{$product['price']}}</td>
                                                <td><button type="button" class="btn btn-primary" onClick="addProduct({{$product}},{{$order_detail}})">Add</button></td>
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
                                            <th scope="col">Amount</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order_detail as $product)
                                            <tr id="{{$product['product'][0]['id']}}">
                                                <td>{{$product['product'][0]['name']}}</td>
                                                <td>{{$product['product'][0]['unit']}}</td>
                                                <td>{{$product['product'][0]['price']}}</td>
                                                <td>{{$product['quantity']}}
                                                    <input type="hidden"
                                                           id="quantity-{{$product['product'][0]['id']}}"
                                                           value="{{$product['quantity']}}"/>
                                                </td>
                                                <td>{{$product['amount']}}</td>
                                                <td><button type="button" class="btn btn-danger" onClick="removeProduct({{$product['product'][0]['id']}},{{$order_detail}})">Remove</button></td>
                                            </tr>
                                        @endforeach
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
                                    <button type="button" class="btn btn-primary"  onClick="saveOrder({{$order->id}})">
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
        let arrProduct = [] ;
        let num = 1;

        function saveOrder(id) {
            for(var i =0;i<arrProduct.length;i++){
                arrProduct[i].quantity = parseInt($('#quantity-' + arrProduct[i].id).val());
            }
            $.ajax({
                type:'POST',
                url:'{{ URL::route('order-update') }}',
                data:{
                    'customer_name': $('#customer_name').val(),
                    'id' : id,
                    'products' : arrProduct,
                    '_token': "{{ csrf_token() }}",
                },
                success:function(data) {
                    alert(data.message);
                    window.location.href = "{{ route('order')}}";

                }
            });
        }
        function addProduct(product, products){
            if(num == 1){
                for(var i=0;i<products.length;i++){
                    arrProduct.push(products[i].product[0]);
                }
            }
            // add product to product add table
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
                        .append($("<button class='btn btn-danger' type='button'" +
                            " onClick='removeProduct("+ product.id + ","+ products+")'>Remove</button>"))
                    )
                );
            arrProduct.push(product);
            // remove item from product available table
            $('table#product_available tr#'+ product.id +'').remove();
            num ++;
        }
        function removeProduct(id,products) {
            if(num ==1){
                for(var i=0;i<products.length;i++){
                    arrProduct.push(products[i].product[0])
                }
            }

            let productTemp = arrProduct.find(x => x.id === id);
            const indexOfObject = arrProduct.findIndex(object => {
                return object.id === id;
            });
            const newArr = [
                ...arrProduct.slice(0, indexOfObject),
                ...arrProduct.slice(indexOfObject + 1),
            ];
            // remove item from product added table
            $('table#product_add tr#'+ id +'').remove();
            arrProduct = newArr;
            //add item to product available table
            $("#product_available").find('tbody')
                .append($('<tr id='+ productTemp.id+'>')
                    .append($('<td>')
                        .text(productTemp.name)
                    ) .append($('<td>')
                        .text(productTemp.unit)
                    ) .append($('<td>')
                        .text(productTemp.price)
                    ) .append($('<td>')
                        .append($("<button class='btn btn-primary'" +
                            " type='button' onClick='addProduct("+ productTemp.id + ","+ products +")'" +
                            ">Add</button>"))
                    )
                );
            num++;
        }
    </script>
@endsection
