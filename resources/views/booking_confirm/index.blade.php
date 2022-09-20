@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a aria-current>Confirm</a></li>
                </ol>
            </nav>
        </div>
        <div class="col">
            <center>
                <h3>อนุมัติรายการจอง</h3>
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
                    <th scope="col">
                        <center>รหัส
                    </th>
                    <th scope="col">
                        <center>ผู้จอง
                    </th>
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
                        <center>ดู
                    </th>
                    {{-- <th scope="col">อนุญาติ</th>
                    <th scope="col">ไม่อนุญาติ</th> --}}
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach ($response as $k => $v)
                    <tr>
                        {{-- @if ($v->status != 'complete' && $v->status != 'prepairing') --}}
                        <th scope="row">
                            <center>{{ $i++ }}
                        </th>
                        <td>
                            <center>{{ Str::limit($v->name, 20) }}
                        </td>
                        <td>
                            <center>{{ $v->status }}
                        </td>
                        <td>
                            <center>{{ $v->start_date }}
                        </td>
                        <td>
                            <center>{{ $v->end_date }}
                        </td>
                        <td>
                            <center>{{ $v->verify_date }}
                        </td>
                        <td>
                            <center>{{ count($v->booking_item) }}
                        </td>
                        <td>
                            <center><a class="btn btn-primary" href="{{ url('/confirm/view/item/' . $v->id) }}">ดู</a>
                        </td>
                        {{-- @else
                        @endif --}}


                        {{-- @if ($v->status == 'complete')
                            <td> <button type="submit" class="btn btn-success" disabled>เสร็จสิ้น</button></td>
                        @elseif ($v->status == 'approve')
                            <td>
                                <form action="{{ route('confirm_status') }}" method="post">
                                    @csrf
                                    <input type="number" name="id" value={{ $v->id }} hidden>
                                    <input type="number" name="status_id" value={{ $v->status_id }} hidden>
                                    <button type="submit" class="btn btn-success">กำลังยืม</button>
                                </form>
                            </td>
                        @elseif ($v->status == 'pending')
                            <td>
                                <form action="{{ route('confirm_status') }}" method="post">
                                    @csrf
                                    <input type="number" name="id" value={{ $v->id }} hidden>
                                    <input type="number" name="status_id" value={{ $v->status_id }} hidden>
                                    <button type="submit" class="btn btn-success">อนุญาติ</button>
                                </form>
                            </td>
                        @elseif ($v->status == 'prepairing')
                            <td> <button type="submit" class="btn btn-success" disabled>รอผู้จองยืนยัน</button></td>
                        @else
                            <td>
                                <form action="{{ route('confirm_status') }}" method="post">
                                    @csrf
                                    <input type="number" name="id" value={{ $v->id }} hidden>
                                    <input type="number" name="status_id" value={{ $v->status_id }} hidden>
                                    <button type="submit" class="btn btn-success">เปลี่ยนสถานะ</button>
                                </form>
                            </td>
                        @endif

                        @if ($v->status == 'complete')
                            <td> <button type="submit" class="btn btn-danger" disabled>เสร็จสิ้น</button></td>
                        @elseif ($v->status == 'prepairing')
                            <td> <button type="submit" class="btn btn-danger" disabled>รอผู้จองยืนยัน</button></td>
                        @else
                            <td>
                                <form action="{{ route('confirm_reject') }}" method="post">
                                    @csrf
                                    <input type="number" name="id" value={{ $v->id }} hidden>
                                    <input type="number" name="status_id" value={{ $v->status_id }} hidden>
                                    <button type="submit" class="btn btn-danger">ไม่อนุญาติ</button>
                                </form>
                            </td>
                        @endif --}}

                        {{-- <td>{{ print_r($v->booking_item) }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset
@endsection
