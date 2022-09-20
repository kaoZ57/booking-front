@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('item_view') }}">Item</a></li>
            <li class="breadcrumb-item active" aria-current="page">Out of service</li>
        </ol>
    </nav>
    <div class="container">
        <div class="row">
            <h5>ส่งซ่อม</h5>
            <h5>{{ $response[0]->name }}</h5>
            <br><br><br><br><br><br><br>
        </div>
        <div class="row">
            <div class="col">

            </div>
            <div class="col">
                @isset($message)
                    <p class="text-danger">{{ $message }}</p>
                @endisset

                <form action="{{ route('outOfService_add') }}" method="post">
                    @csrf
                    <div class="row g-3 align-items-center">
                        <label for="inputPassword5"
                            class="form-label">รายละเอียด:&nbsp;{{ $response[0]->description }}</label><br>
                        <label for="inputPassword5" class="form-label">จำนวนปัจจุบัน:&nbsp;{{ $response[0]->amount }}
                            ชิ้น</label>

                        <input type="number" name="id" value={{ $response[0]->id }} hidden>
                        <div class="form-outline">
                            <textarea class="form-control" data-mdb-showcounter="true" maxlength="255" type="text"
                                id="exampleFormControlTextarea1" rows="3" name="note" required></textarea>
                            <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                            <div class="form-helper"></div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="inputPassword6" class="col-form-label">จำนวน</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" id="inputPassword6" class="form-control"
                                    aria-describedby="passwordHelpInline" name="amount" required>
                            </div>
                            <div class="col-auto">
                                <span id="passwordHelpInline" class="form-text">
                                    ชิ้น
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection
