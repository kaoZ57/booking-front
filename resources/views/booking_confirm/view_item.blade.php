@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('confirm_view') }}">Booking Confirm</a></li>
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
    {{-- @isset(session('message'))
        <h3 class="text-danger">{{ session('message') }}</h3>
    @endisset --}}
    @isset($response)
        <div class="row">
            <div class="col">
                <h3>สถานะ {{ $response->status }}</h3>
                <h3>เริ่ม {{ $response->start_date }}</h3>
                <h3>วันคืน {{ $response->end_date }}</h3>
            </div>
            <div class="col">

                {{-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-success me-md-2" href="{{ route('item_add_view') }}" type="button">เพิ่มสิ่งของ</a>
                </div> --}}
            </div>
        </div>
        <table id="example" class="table">
            <thead>
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">status</th>
                    <th scope="col">โน้ตผู้จอง</th>
                    <th scope="col">โน้ตร้าน</th>
                    <th scope="col">จำนวน</th>
                    {{-- <th scope="col">โน้ต</th> --}}
                    <th scope="col">อนุญาติ</th>
                    <th scope="col">ไม่อนุญาติ</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach ($response->booking_item as $k => $v)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $v->name }}</td>
                        <td>{{ $v->status }}</td>
                        <td>{{ Str::limit($v->note_user, 20) }}</td>
                        <td>{{ $v->note_owner }}</td>
                        <td>{{ $v->amount }}</td>
                        @if ($v->status == 'pending')
                            <form action="{{ route('confirm_status_item') }}" method="post">
                                @csrf
                                <td>
                                    <input type="number" name="id" value={{ $v->id }} hidden>
                                    <input type="number" name="status_id" value={{ $v->status_id }} hidden>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="note"
                                        value={{ $v->note_owner }}>
                                </td>
                                <td><button type="submit" class="btn btn-success">อนุญาติ</button></td>
                            </form>
                            <form action="{{ route('confirm_reject_item') }}" method="post">
                                @csrf
                                <td>
                                    <input type="number" name="id" value={{ $v->id }} hidden>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="note"
                                        value={{ $v->note_owner }}>
                                    <input type="number" name="status_id" value={{ $v->status_id }} hidden>
                                </td>
                                <td><button type="submit" class="btn btn-danger">ไม่อนุญาติ</button></td>
                            </form>
                            </form>
                        @elseif ($v->status == 'reject')
                            <td><input type="text" class="form-control" id="exampleFormControlInput1" name="note"
                                    value={{ $v->note_owner }} disabled> </td>
                            <td><button type="submit" class="btn btn-success" disabled>ไม่อนุญาติ</button></td>
                            <td><button type="submit" class="btn btn-danger" disabled>ไม่อนุญาติ</button></td>
                        @elseif ($v->status == 'approve')
                            <form action="{{ route('confirm_status_item') }}" method="post">
                                @csrf
                                <td>
                                    <input type="number" name="id" value={{ $v->id }} hidden>
                                    <input type="number" name="status_id" value={{ $v->status_id }} hidden>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="note"
                                        value={{ $v->note_owner }}>
                                </td>
                                <td><button type="submit" class="btn btn-success">กำลังยืม</button></td>
                            </form>
                            <td><button type="submit" class="btn btn-danger" disabled>ไม่อนุญาติ</button></td>
                        @elseif ($v->status == 'lending')
                            <form action="{{ route('confirm_status_item') }}" method="post">
                                @csrf
                                <td>
                                    <input type="number" name="id" value={{ $v->id }} hidden>
                                    <input type="number" name="status_id" value={{ $v->status_id }} hidden>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="note"
                                        value={{ $v->note_owner }}>
                                </td>
                                <td><button type="submit" class="btn btn-success">เสร็จสิ้น</button></td>
                            </form>
                            <td><button type="submit" class="btn btn-danger" disabled>ไม่อนุญาติ</button></td>
                        @elseif ($v->status == 'returned')
                            <td><input type="text" class="form-control" id="exampleFormControlInput1" name="note"
                                    value={{ $v->note_owner }} disabled> </td>
                            <td><button type="submit" class="btn btn-success" disabled>คืนแล้ว</button></td>
                            <td><button type="submit" class="btn btn-danger" disabled>คืนแล้ว</button></td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset

@endsection
