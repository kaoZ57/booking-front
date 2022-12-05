@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a aria-current>Order</a></li>
                </ol>
            </nav>
        </div>
        <div class="col">
            <center>
                <h3>รายการจอง</h3>
        </div>
        <div class="col">
            @isset(request()->message)
                <p class="text-danger">{{ request()->message }}</p>
            @endisset
        </div>
    </div>
    @isset($response)
        <br>
        <table id="example" class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">
                        <center>สถานะ
                    </th>
                    <th scope="col">
                        <center>วันเริ่มยืม
                    </th>
                    <th scope="col">
                        <center>วันที่ยืม
                    </th>
                    <th scope="col">
                        <center>วันอนุมัติ
                    </th>
                    <th scope="col">
                        <center>จำนวนที่จอง
                    </th>
                    <th scope="col">
                        <center>จองเพิ่ม
                    </th>
                    <th scope="col">
                        <center>ดู
                    </th>
                    <th scope="col">
                        <center>ยืนยัน
                    </th>

                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach ($response as $k => $v)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $v->status }}</td>
                        <td>{{ $v->start_date }}</td>
                        <td>{{ $v->end_date }}</td>
                        <td>{{ $v->verify_date }}</td>
                        <td>
                            <center>{{ count($v->booking_item) }}
                        </td>
                        @if ($v->status != 'prepairing')
                            <center>
                                <td><button class="btn btn-warning" disabled>จองเพิ่ม</button></td>
                            @else
                                <center>
                                    <td><a class="btn btn-warning" href="{{ url('/order/add/item/' . $v->id) }}">จองเพิ่ม</a>
                                    </td>
                        @endif
                        <center>
                            <td><a class="btn btn-primary" href="{{ url('/order/view/item/' . $v->id) }}">ดู</a></td>
                            @if ($v->status != 'prepairing')
                                <center>
                                    <td> <button type="submit" class="btn btn-success" disabled>ยืนยันแล้ว</button> </td>
                                @else
                                    <center>
                                        <td>
                                            <form action="{{ route('order_confirm') }}" method="post">
                                                @csrf
                                                <input type="number" name="id" value={{ $v->id }} hidden>
                                                <input type="text" name="start_date" value='{{ $v->start_date }}' hidden>
                                                <input type="text" name="end_date" value='{{ $v->end_date }}' hidden>
                                                <button type="submit" class="btn btn-success">ยืนยัน</button>
                                            </form>
                                        </td>
                            @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset

@endsection
