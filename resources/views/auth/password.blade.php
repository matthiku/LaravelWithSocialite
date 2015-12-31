@extends('layouts.main')

@section('title', "Reset Password")


@section('content')

    @include('layouts.flashing')

    <div class="container signin-body">


        <form class="form-signin" method="POST" action="/password/email">

        	{{ csrf_field() }}

            <h4 class="form-signin-heading">To reset your password, enter your email address</h4>

            <label for="email" class="sr-only">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control" placeholder="Email address" required autofocus>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Send Password Reset Link</button>

        </form>


    </div> <!-- /container -->

@stop
