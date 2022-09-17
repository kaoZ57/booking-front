@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('order_view') }}">Order</a></li>
                    <li class="breadcrumb-item"><a aria-current="page">Order Edit</a></li>
                </ol>
            </nav>
        </div>
        <div class="col">
            @isset(request()->message)
                <p class="text-danger">{{ request()->message }}</p>
            @endisset
        </div>
    </div>

    <div class="container">
        <div class="row">
            <h5>แก้ไขเวลาจอง</h5>
            <br><br><br><br><br><br><br>
        </div>
        <div class="row">
            <div class="col">

            </div>
            <div class="col">

                @isset($message)
                    <p class="text-danger">{{ $message }}</p>
                @endisset

                <form action="{{ route('order_edit_booking') }}" method="post">
                    @csrf
                    <input type="number" name="id" value={{ $response->id }} hidden>
                    <label for="birthday">เริ่ม:</label>
                    <input type="datetime-local" value={{ $response->start_date }} name="start_date">
                    <br>
                    <br>
                    <label for="birthday">คืน:</label>
                    <input type="datetime-local" value={{ $response->end_date }} name="end_date">

                    <br> <br>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection
