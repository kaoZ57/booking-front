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

        </div>
    </div>

    <div class="container">
        <div class="row">
            <h5>เพิ่มรายการ จอง</h5>

        </div>
        <div class="row">
            <div class="col">

            </div>
            <div class="col">
                <br><br><br><br><br><br><br>
                <form action="{{ route('booking_add') }}" method="post">
                    @csrf
                    <label for="start_date">เริ่ม:</label>
                    <input type="datetime-local" id="myDatetimeField" name="start_date" required>
                    <br>
                    <br>
                    <label for="end_date">คืน:</label>
                    <input type="datetime-local" name="end_date" required>
                    <br><br>
                    @isset(request()->message)
                        <p class="text-danger">{{ request()->message }}</p>
                    @endisset
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
    <br><br><br><br><br><br><br>
@endsection

<script>
    window.addEventListener("load", function() {
        var now = new Date();
        var offset = now.getTimezoneOffset() * 60000;
        var adjustedDate = new Date(now.getTime() - offset);
        var formattedDate = adjustedDate.toISOString().substring(0, 16); // For minute precision
        var datetimeField = document.getElementById("myDatetimeField");
        datetimeField.value = formattedDate;
        console.log(formattedDate);
    });
</script>
