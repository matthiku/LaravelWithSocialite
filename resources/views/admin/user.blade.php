@extends('layouts.main')

@section('title', "Create or Update a User")




@section('content')

    @include('layouts.sidebar')

    @include('layouts.flashing')


    @if (isset($user))
        <h2>Update User</h2>
        {!! Form::model( $user, array('route' => array('users.update', $user->id), 'method' => 'put') ) !!}
    @else
        <h2>Create User</h2>
        {!! Form::open(array('action' => 'UserController@store')) !!}
    @endif
        <!-- problem with checkboxes not being sent when unchecked! -->
        <input name="is_admin" type="hidden" value="0">
        <!-- https://stackoverflow.com/questions/1809494/post-the-checkboxes-that-are-unchecked -->

        <p>{!! Form::label('name', 'User Name'); !!}<br>
           {!! Form::text('name'); !!}</p>
        <p>{!! Form::label('email', 'Email Address'); !!}<br>
           {!! Form::text('email'); !!}</p>
        <p>{!! Form::label('is_admin', 'Administator?'); !!}
           {!! Form::checkbox('is_admin'); !!}</p>


    @if (isset($user))
        <p>{!! Form::submit('Update'); !!}</p>
        <hr>
        <a class="btn btn-danger btn-sm"  role="button" href="/users/{{ $user->id }}/delete">
            <i class="fa fa-trash" > </i> &nbsp; Delete
        </a>
    @else
        <p>{!! Form::submit('Submit'); !!}
    @endif

    <a href="/users">{!! Form::button('Cancel'); !!}</a></p>
    {!! Form::close() !!}
    
@stop

