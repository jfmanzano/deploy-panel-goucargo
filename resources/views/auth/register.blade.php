@extends('templates.template1')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center my-5">
                <h1 class="heading-section">REGISTER USER</h1>
            </div>
        </div>
        <div class = "col-5 mx-auto">
            <form class="signin-form" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" name='user' id="inputEmail" required>
                </div>
                <div class="form-group my-3">
                    <input id="password-field" style="background-color: none;" type="password" class="form-control"
                        placeholder="Password" name="password" id="inputPassword" required>
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="API-Key" name='key' id="key" required>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="form-control btn btn-primary submit px-3">REGISTER</button>
                </div>
            </form>
        </div>
    </div>
@endsection
