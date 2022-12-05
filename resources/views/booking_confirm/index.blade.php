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
                    {{-- <th scope="col">อนุญาต</th>
                    <th scope="col">ไม่อนุญาต</th> --}}
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset
@endsection
