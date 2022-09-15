@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a aria-current="page">Booking</a></li>
                </ol>
            </nav>
        </div>
        <div class="col">
            @isset(request()->massage)
                <p class="text-danger">{{ request()->massage }}</p>
            @endisset
        </div>
    </div>
    @isset($response)
        <div class="container">
            <div class="row">
                <h5>เพิ่มรายการ จอง</h5>
                <br><br><br><br><br><br><br>
            </div>
            <div class="row">
                <div class="col">

                </div>
                <div class="col">

                    @isset($massage)
                        <p class="text-danger">{{ $massage }}</p>
                    @endisset

                    <form action="{{ route('booking_add') }}" method="post">
                        @csrf
                        <label for="birthday">เริ่ม:</label>
                        <input type="date" id="birthday" name="start_date">
                        <br>
                        <br>
                        <label for="birthday">คืน:</label>
                        <input type="date" id="birthday" name="end_date">

                        <br> <br>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="col"></div>
            </div>
        </div>
    @endisset

@endsection
