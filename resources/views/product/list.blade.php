@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('product-create') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Create</a>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('List') }}</div>

                <div class="card-body">
                <table class="table">
					<thead>
						<tr>
						<th scope="col">#</th>
						<th scope="col">Name</th>
						<th scope="col">Unit</th>
						<th scope="col">Price</th>
						<th scope="col">Category</th>
						</tr>
					</thead>
					<tbody>
                    @foreach($products as $product)
                        <tr>
                            <th scope="row">{{ $loop->index }}</th>
                            <td>{{$product['name']}}</td>
                            <td>{{$product['unit']}}</td>
                            <td>{{$product['price']}}</td>
                            <td>{{$product['category']['name']}}</td>
                        </tr>
                    @endforeach
					</tbody>
				</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
