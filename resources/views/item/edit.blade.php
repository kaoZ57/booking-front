@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('item_view') }}">Item</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
    <div class="container">
        <div class="row">
            <h5>แก้ไข</h5>
            <h5>{{ $response[0]->name }}</h5>
            <br><br><br><br><br><br><br>
        </div>
        <div class="row">
            <div class="col">

            </div>
            <div class="col">

                <br>
                @isset($massage)
                    <p class="text-danger">{{ $massage }}</p>
                @endisset

                <form action="{{ route('item_edit') }}" method="post">
                    @csrf
                    <input type="number" name="id" value={{ $response[0]->id }} hidden>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="name"
                            value={{ $response[0]->name }}>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">รายละเอียด</label>
                        <textarea class="form-control" type="text" id="exampleFormControlTextarea1" rows="3" name="description">{{ $response[0]->description }}</textarea>
                    </div>

                    <label for="exampleFormControlTextarea1" class="form-label">เปิดให้จองไหม</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active" id="flexRadioDefault1" value=1
                            {{ $response[0]->is_active == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexRadioDefault1">
                            เปิดให้จอง
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active" id="flexRadioDefault2" value=0
                            {{ $response[0]->is_active == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexRadioDefault2">
                            ไม่เปิดให้จอง
                        </label>
                    </div>

                    {{-- <br>
                    <label for="exampleFormControlTextarea2" class="form-label">สิง่ของนี้ต้องคืนไหม</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_not_return" id="flexRadioDefault1" value=0
                            {{ $response[0]->is_not_return == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexRadioDefault3">
                            คืน
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_not_return" id="flexRadioDefault2" value=1
                            {{ $response[0]->is_not_return == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexRadioDefault4">
                            ไม่คืน
                        </label>
                    </div> --}}

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
