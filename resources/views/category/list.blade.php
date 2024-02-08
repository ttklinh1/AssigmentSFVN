@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('category-create') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Create</a>
    @if($message)
        <p>{{$message}}</p>
    @endif
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
						</tr>
					</thead>
					<tbody>
                    @foreach($categories as $category)
                        <tr>
                            <th scope="row">{{ $loop->index }}</th>
                            <td>{{$category->name}}</td>
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
