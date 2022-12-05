@extends('layouts.app')

@section('content')
    <br><br><br><br><br>
    <div class="container">
        <div class="row">
        </div>
        <div class="row">
            <div class="col">

            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Register
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="form-outline">
                                <input type="text" class="form-control" name="name" required>
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                            </div>
                            <br>
                            <div class="form-outline">
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="email" required>
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                @isset($message)
                                    <div id="emailHelp" class="form-text">
                                        {{ $message }}
                                    </div>
                                @endisset
                            </div>
                            <br>
                            <div class="form-outline">
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                                    required>
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                            </div>
                            <br>
                            <div class="form-outline">
                                <input type="password" class="form-control" id="exampleInputPassword1"
                                    name="password_confirmation" required>
                                <label for="exampleInputPassword1" class="form-label">Password Confirmation</label>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">

            </div>
        </div>
    </div>
    <br><br><br><br><br><br>
@endsection
