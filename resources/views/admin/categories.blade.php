@extends('layouts.main')

@section('title', $heading)

@section('categories', 'active')



@section('content')

	@include('layouts.sidebar')

	@include('layouts.flashing')

    <h2>{{ $heading }}</h2>


	@if (count($categories))

		<table class="table table-striped table-bordered 
					@if(count($categories)>5)
					 table-sm
					@endif
					 ">
			<thead class="thead-default">
				<tr>
					<th>#</th>
					<th>Name</th>
					 @if(Auth::user()->id===1 || Auth::user()->is_admin)
					<th>Action</th>
					@endif
				</tr>
			</thead>
			<tbody>
	        @foreach( $categories as $category )
				<tr>
					<th scope="row">{{ $category->id }}</th>
					<td>{{ $category->name }}</td>
					<td>
						<a class="btn btn-secondary btn-sm" title="Show Tasks" href='/tasks/category/{{$category->id}}'><i class="fa fa-filter"></i></a>
						 @if(Auth::user()->id===1 || Auth::user()->is_admin)
						<a class="btn btn-primary-outline btn-sm" title="Edit" href='/categories/{{$category->id}}/edit'><i class="fa fa-pencil"></i></a>
						<a class="btn btn-danger btn-sm" title="Delete!" href='/categories/{{$category->id}}/delete'><i class="fa fa-trash"></i></a>
						@endif
					</td>
				</tr>
	        @endforeach
			</tbody>
		</table>

    @else

    	No categories found!

	@endif

	@if(Auth::user()->id===1 || Auth::user()->is_admin)
	<a class="btn btn-primary-outline" href='/categories/create'>
		<i class="fa fa-plus"> </i> &nbsp; Add a category
	</a>
	@endif

	
@stop
