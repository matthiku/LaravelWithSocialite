@extends('layouts.main')

@section('title', "My Tasks")

@section('tasks', 'active')



@section('content')

	@include('layouts.sidebar')

	@include('layouts.flashing')

    <h2>{{ $heading }}</h2>


	@if (count($tasks))

		<table class="table table-striped table-bordered 
					@if(count($tasks)>5)
					 table-sm
					@endif
					 ">
			<thead class="thead-default">
				<tr>
					<th>#</th>
					<th>User</th>
					<th>Name</th>
					<th>Cat.</th>
					<th>Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
	        @foreach( $tasks as $task )
				<tr>
					<th scope="row">{{ $task->id }}</th>
					<td>{{ $task->user->name }}</td>
					<td><a href='/tasks/{{$task->id}}'>{{ $task->name }}</a></td>
					<td>{{ isset($task->category->name) ? $task->category->name : 'missing' }}</td>
					<td>{{ date('d/m/Y', strtotime($task->date))  }}</td>
					<td>
						<a class="btn btn-warning btn-sm" title="Done!" href='/tasks/{{$task->id}}/delete'><i class="fa fa-check"></i></a>
						<a class="btn btn-primary-outline btn-sm" title="Edit" href='/tasks/{{$task->id}}/edit'><i class="fa fa-pencil"></i></a>
					</td>
				</tr>
	        @endforeach
			</tbody>
		</table>

    @else

    	<p>No tasks found!</p>

	@endif


	<a class="btn btn-primary-outline" href='/tasks/create'>
		<i class="fa fa-plus"> </i> &nbsp; Add a task
	</a>


	<br><hr><br>

	@if (count($trashed))

			<h3>Finished Tasks</h3>

		<table class="table table-striped table-bordered">
			<thead class="thead-default">
				<tr>
					<th>#</th>
					<th>User</th>
					<th>Name</th>
					<th>Category</th>
					<th>Finished at</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
	        @foreach( $trashed as $trash )
				<tr>
					<th scope="row">{{ $trash->id }}</th>
					<td>{{ $trash->user->name     }}</td>
					<td>{{ $trash->name           }}</td>
					<td>{{ $trash->category->name }}</td>
					<td>{{ $trash->deleted_at     }}</td>
					<td>
						<a class="btn btn-primary btn-sm" title="Recover" href='/tasks/{{$trash->id}}/restore'><i class="fa fa-undo" ></i></a>
						<a class="btn btn-danger  btn-sm" title="Permanently Delete!" href='/tasks/{{$trash->id}}/forceDelete'><i class="fa fa-trash" ></i></a>
					</td>
				</tr>
	        @endforeach
			</tbody>
		</table>

    @else

    	<p>No deleted tasks found!</p>

	@endif

	
@stop

