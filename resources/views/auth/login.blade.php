@extends('layouts.main')

@section('title', "Login User")

@section('login', 'active')

@section('content')

    @include('layouts.flashing')

    <div class="container signin-body">


        <form class="form-signin" method="POST" action="/auth/login">

        	{{ csrf_field() }}

            <h2 class="form-signin-heading">Please sign in</h2>

            <label for="email" class="sr-only">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control" placeholder="Email address" required autofocus>

            <label for="password" class="sr-only">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

            <div class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

            <a href="/password/email" class="btn btn-sm btn-secondary btn-block" role="button">Reset Password</a>

            <br><br>
            <h4>Or Log in Using a Provider:</h4>

            <a href="/login/github" class="btn btn-lg btn-secondary" role="button"><i class="fa fa-github"></i> Github</a>
            <a href="/login/google" class="btn btn-lg btn-secondary" role="button"><i class="fa fa-google"></i> Google</a>
            <a href="/login/twitter" class="btn btn-lg btn-secondary" role="button"><i class="fa fa-twitter"></i> Twitter</a>
            <a href="/login/facebook" class="btn btn-lg btn-secondary" role="button"><i class="fa fa-facebook"></i> Facebook</a>
            <a href="/login/linkedin" class="btn btn-lg btn-secondary" role="button"><i class="fa fa-linkedin"></i> LinkedIn</a>

        </form>


    </div> <!-- /container -->

@stop
