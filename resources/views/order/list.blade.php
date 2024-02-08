@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('order-create') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Create</a>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('List') }}</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Customer name</th>
                                <th scope="col">Total</th>
                                <th scope="col">Create at</th>
                                <th scope="col">Update at</th>
                            </tr>
                            </thead>
                            <form>
                                @csrf
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{$order->customer_name}}</td>
                                    <td>{{$order->total}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->updated_at}}</td>
                                    <td><a href="{{ route('order-edit' , $order->id) }}"
                                           class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">
                                            Edit</a>
                                    </td>
                                    <td><button  type="button" class="btn btn-primary" onClick="deleteOrder({{$order->id}})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            </form>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteOrder(id){
            if (confirm('Do you want delete this item')) {
                var url = '{{ route('order-delete', ":id") }}';
                url = url.replace(':id', id);
                $.ajax({
                    type:'DELETE',
                    url:url,
                    data:{
                        '_token': "{{ csrf_token() }}",
                    },
                    success:function(data) {
                        alert(data.message);
                        window.location.href = "{{ route('order')}}";
                }});
            }
        }
    </script>
@endsection
