@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('item_view') }}">Item</a></li>
            <li class="breadcrumb-item active" aria-current="page">AddStock</li>
        </ol>
    </nav>
    <div class="container">
        <div class="row">
            <h5>เพิ่มจำนวน {{ $response[0]->name }}</h5>
            <br><br><br><br><br><br><br>
        </div>
        <div class="row">
            <div class="col">

            </div>
            <div class="col">
                @isset($message)
                    <p class="text-danger">{{ $message }}</p>
                @endisset

                <form action="{{ route('item_add_stock') }}" method="post">
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
                                aria-describedby="passwordHelpInline" name="amount" min="1" required>
                        </div>
                        <div class="col-auto">
                            <input type="number" name="id" value={{ $response[0]->id }} hidden>
                            <span id="passwordHelpInline" class="form-text">
                                ชิ้น
                            </span>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection
