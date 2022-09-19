@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('item_view') }}">Item</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Item</li>
        </ol>
    </nav>
    <div class="container">
        <div class="row">
            <h5>ADD Item</h5>
            <br><br><br><br><br><br><br>
        </div>
        <div class="row">
            <div class="col">

            </div>
            <div class="col">
                @isset($message)
                    <p class="text-danger">{{ $message }}</p>
                @endisset

                <form action="{{ route('item_add') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="name"
                            maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                        <textarea class="form-control" type="text" id="exampleFormControlTextarea1" rows="3" name="description"
                            maxlength="100"></textarea>
                    </div>

                    <label for="exampleFormControlTextarea1" class="form-label">เปิดให้จองไหม</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active" id="flexRadioDefault1" value=1
                            checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            เปิดให้จอง
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active" id="flexRadioDefault2" value=0>
                        <label class="form-check-label" for="flexRadioDefault2">
                            ไม่เปิดให้จอง
                        </label>
                    </div>

                    <br>
                    <label for="exampleFormControlTextarea2" class="form-label">สิง่ของนี้ต้องคืนไหม</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_not_return" id="flexRadioDefault1" value=0
                            checked>
                        <label class="form-check-label" for="flexRadioDefault3">
                            คืน
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_not_return" id="flexRadioDefault2" value=1>
                        <label class="form-check-label" for="flexRadioDefault4">
                            ไม่คืน
                        </label>
                    </div>

                    <br>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection
