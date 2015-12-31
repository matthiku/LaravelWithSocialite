@extends('layouts.main')

@section('title', "Create or Update Task")

@section('create', 'active')



@section('content')

    @include('layouts.sidebar')

    @include('layouts.flashing')


    @if (isset($task))
        <h2>Update Task</h2>
        {!! Form::model( $task, array('route' => array('tasks.update', $task->id), 'method' => 'patch') ) !!}
    @else
        <h2>Create Task</h2>
        {!! Form::open(array('action' => 'TaskController@store')) !!}
    @endif
        <p>{!! Form::text('name'); !!}</p>
        <p>{!! Form::select('category_id', $categories); !!}</p>

    @if (isset($task))
        <p>{!! Form::date('date', $task->date ); !!}</p>
        <p>{!! Form::submit('Update'); !!}</p>
        <hr>
        <a class="btn btn-danger"  role="button" href="/tasks/{{ $task->id }}/delete">
            <i class="fa fa-trash" > </i> &nbsp; Delete
        </a>
    @else
        <p>{!! Form::date('date'); !!}</p>
        <p>{!! Form::submit('Submit'); !!}
    @endif
        <a href="/tasks">{!! Form::button('Cancel'); !!}</a></p>

    {!! Form::close() !!}
    
@stop