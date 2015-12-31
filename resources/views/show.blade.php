@extends('layouts.main')

@section('title', "My Task")

@section('listall', 'active')

@section('content')

	@include('layouts.sidebar')

    <h2>{{ $task->name }}</h2>
    <p>Category: {{ $task->category->name }}</p>
    <p>Date due: {{ $task->date }}</p>
    <p>Date created: {{ $task->created_at->toDateTimeString() }}</p>

    <hr>

    <a class="btn btn-primary-outline" role="button" href="/tasks/{{ $task->id }}/edit"  ><i class="fa fa-pencil"></i> Edit</a>
    <a class="btn btn-danger"          role="button" href="/tasks/{{ $task->id }}/delete"><i class="fa fa-trash" ></i> Delete</a>
    
@stop
