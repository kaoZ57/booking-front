@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h5>จอง {{ $response[0]->name }}</h5>
            <br><br><br><br><br><br><br>
        </div>
        <div class="row">
            <div class="col">

            </div>
            <div class="col">
                @isset($message)
                    <p class="text-danger">{{ $message }}</p>
                @endisset

                <form action="{{ route('order_item_add') }}" method="post">
                    @csrf
                    <div class="row g-3 align-items-center">
                        <label for="inputPassword5" class="form-label">{{ $response[0]->description }}</label>
                        <label for="inputPassword5" class="form-label">จำนวนปัจจุบัน {{ $response[0]->amount }} ชิ้น</label>

                        @csrf
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">จำนวน</label>
                        </div>
                        <div class="col-auto">
                            <input type="number" id="inputPassword6" class="form-control"
                                aria-describedby="passwordHelpInline" name="amount" min="1"
                                max='{{ $response[0]->amount }}' required>
                        </div>
                        <div class="col-auto">
                            <span id="passwordHelpInline" class="form-text">
                                ชิ้น
                            </span>
                        </div>
                        <input type="number" name="id" value={{ $response[0]->id }} hidden>
                        <input type="number" name="bookingid" value={{ $bookingid }} hidden>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">note</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="note">
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">จอง</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection
