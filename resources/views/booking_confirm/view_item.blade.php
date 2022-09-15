@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Booking Confirm</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </nav>
        </div>
        <div class="col">

            {{-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-success me-md-2" href="{{ route('item_add_view') }}" type="button">เพิ่มสิ่งของ</a>
            </div> --}}
        </div>
    </div>
    @isset($massage)
        <p class="text-danger">{{ $massage }}</p>
    @endisset
    @isset($response)
        <h3>สถานะ {{ $response->status }}</h3>
        <h3>เริ่ม {{ $response->start_date }}</h3>
        <h3>วันคืน {{ $response->end_date }}</h3>
        <table id="example" class="table">
            <thead>
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">status</th>
                    <th scope="col">โน้ตผู้จอง</th>
                    <th scope="col">โน้ตร้าน</th>
                    <th scope="col">จำนวน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($response->booking_item as $k => $v)
                    <tr>
                        <th scope="row">{{ $v->id }}</th>
                        <td>{{ $v->name }}</td>
                        <td>{{ $v->status }}</td>
                        <td>{{ $v->note_user }}</td>
                        <td>{{ $v->note_owner }}</td>
                        <td>{{ $v->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset

@endsection
