@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('order_view') }}">Order</a></li>
            <li class="breadcrumb-item"><a aria-current>Add in booking</a></li>
        </ol>
    </nav>
    @isset($message)
        <p class="text-danger">{{ $message }}</p>
    @endisset
    @isset($booking)
        <h4>ที่เลือกไว้</h4>
        <table class="table">
            <thead class="bg-light">
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
                @php($i = 1)
                @foreach ($booking->booking_item as $k => $v)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
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
    <br><br>
    <hr>
    <br><br>
    @isset($response)
        <h4>เลือกที่ต้องการเพื่ม</h4>
        <br>
        <table id="example" class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">รายละเอียด</th>
                    <th scope="col">จำนวน</th>
                    <th scope="col">สถานะคืน</th>
                    <th scope="col">เพิ่ม</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach ($response as $k => $v)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $v->name }}</td>
                        <td> {{ Str::limit($v->description, 70) }}</td>
                        <td>{{ $v->amount }}</td>
                        @if ($v->is_not_return == 1)
                            <td class="text-primary">ไม่ต้องคืน</td>
                        @else
                            <td class="text-success">คืน </td>
                        @endif
                        <td>
                            <form action="{{ route('order_item_add_view') }}" method="post">
                                @csrf
                                <input type="number" name="id" value={{ $v->id }} hidden>
                                <input type="number" name="bookingid" value={{ $bookingid }} hidden>
                                <button type="submit" class="btn btn-warning">เพื่ม</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset



@endsection
