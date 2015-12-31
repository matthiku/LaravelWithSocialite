@extends('layouts.main')

@section('title', "Reset Password")


@section('content')

    @include('layouts.flashing')

    <div class="container signin-body">


        <form class="form-signin" method="POST" action="/password/email">

        	{{ csrf_field() }}

            <h2 class="form-signin-heading">Reset your password</h2>


            <label for="email" class="sr-only">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control" placeholder="Email address" required>

            <label for="password" class="sr-only">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            <label for="confirmPassword" class="sr-only">Confirm Password</label>
            <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" placeholder="Confirm password" required>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>

        </form>


    </div> <!-- /container -->

@stop
