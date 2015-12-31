@extends('layouts.main')

@section('title', "Create or Update a Category")




@section('content')

    @include('layouts.sidebar')

    @include('layouts.flashing')


    @if (isset($category))
        <h2>Update Category</h2>
        {!! Form::model( $category, array('route' => array('categories.update', $category->id), 'method' => 'put') ) !!}
    @else
        <h2>Create Category</h2>
        {!! Form::open(array('action' => 'CategoryController@store')) !!}
    @endif
        <p>{!! Form::label('name', 'Category Name'); !!}<br>
           {!! Form::text('name'); !!}</p>

    @if (isset($category))
        <p>{!! Form::submit('Update'); !!}</p>
        <hr>
        <a class="btn btn-danger btn-sm"  role="button" href="/categories/{{ $category->id }}/delete">
            <i class="fa fa-trash" > </i> &nbsp; Delete
        </a>
    @else
        <p>{!! Form::submit('Submit'); !!}
    @endif

    <a href="/categories">{!! Form::button('Cancel'); !!}</a></p>
    {!! Form::close() !!}
    
@stop