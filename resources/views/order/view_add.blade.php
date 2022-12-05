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
    @if ($booking->status == 'prepairing')
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-warning" href="{{ url('/order/view/edit/booking/' . $booking->id) }}">แก้ไขวันจอง</a>
            <form action="{{ route('order_confirm') }}" method="post">
                @csrf
                <input type="number" name="id" value={{ $booking->id }} hidden>
                <input type="text" name="start_date" value='{{ $booking->start_date }}' hidden>
                <input type="text" name="end_date" value='{{ $booking->end_date }}' hidden>
                <button type="submit" class="btn btn-success">ยืนยัน</button>
            </form>
        </div>
    @else
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-warning" disabled>แก้ไขวันจอง</button>
            <button type="submit" class="btn btn-success" disabled>ยืนยัน</button>
        </div>
    @endif
    @isset($booking)
        <h4>ที่เลือกไว้</h4>
        <table class="table">
            <thead class="bg-light">
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">โน้ตผู้จอง</th>
                    <th scope="col">โน้ตร้าน</th>
                    <th scope="col">สถานะคืน</th>
                    <th scope="col">จำนวน</th>
                    <th scope="col">แก้ไข</th>
                    <th scope="col">ลบ</th>
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
                        @if ($v->is_not_return == 1)
                            <td>
                                <span class="badge badge-danger rounded-pill d-inline">ไม่คืน</span>
                            </td>
                        @else
                            <td>
                                <span class="badge badge-success rounded-pill d-inline">คืน</span>
                            </td>
                        @endif
                        <td>{{ $v->amount }}</td>
                        @if ($booking->status == 'prepairing')
                            <td>
                                <form action="{{ route('order_item_edit_view') }}" method="get">
                                    <input value={{ $v->id }} name="booking_item_id" hidden />
                                    <input value={{ $booking->id }} name="booking_id" hidden />
                                    <button class="btn btn-warning" type="submit">แก้ไข</button>
                                </form>
                            </td>
                        @else
                            <td><button class="btn btn-warning" type="submit" disabled>แก้ไข</button> </td>
                        @endif

                        @if ($booking->status == 'prepairing')
                            <td>
                                <form action="{{ route('order_item_delete') }}" method="post"
                                    onclick="return confirm('Are you sure?')">
                                    @csrf
                                    <input value={{ $v->id }} name="booking_item_id" hidden />
                                    <input value={{ $booking->id }} name="booking_id" hidden />
                                    <button class="btn btn-danger" type="submit">ลบ</button>
                                </form>
                            </td>
                        @else
                            <td><button class="btn btn-danger" type="submit" disabled>ลบ</button> </td>
                        @endif
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
                            <td>
                                <center><span class="badge badge-danger rounded-pill d-inline">ไม่คืน</span>
                            </td>
                        @else
                            <td>
                                <center><span class="badge badge-success rounded-pill d-inline">คืน</span>
                            </td>
                        @endif

                        @php($is_have = false)
                        @foreach ($booking->booking_item as $k => $vv)
                            @if ($vv->item_id == $v->id)
                                @php($is_have = true)
                            @endif
                        @endforeach

                        @if ($booking->status != 'prepairing')
                            <td> <button type="submit" class="btn btn-warning" disabled>เพื่ม</button></td>
                        @elseif ($is_have)
                            <td> <button type="submit" class="btn btn-warning" disabled>เพื่ม</button></td>
                        @else
                            <td>
                                <form action="{{ route('order_item_add_view') }}" method="post">
                                    @csrf
                                    <input type="number" name="id" value={{ $v->id }} hidden>
                                    <input type="number" name="bookingid" value={{ $bookingid }} hidden>
                                    <button type="submit" class="btn btn-warning"> เพื่ม</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset



@endsection
