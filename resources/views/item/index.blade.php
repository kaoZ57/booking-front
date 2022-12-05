@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Item</li>
                </ol>
            </nav>
        </div>
        <div class="col">
            <center>
                <h3>จัดการสิ่งของ</h3>
        </div>
        <div class="col">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-success me-md-2" href="{{ route('item_add_view') }}" type="button">เพิ่มสิ่งของ</a>
            </div>
        </div>
    </div>

    @isset($message)
        <p class="text-danger">{{ $message }}</p>
    @endisset
    @isset($response)
        <br>
        <table id="example" class="table align-middle mb-0 bg-white">

            <thead class="bg-light">
                <tr>
                    <th scope="col">
                        รหัส
                    </th>
                    <th scope="col">
                        ชื่อ
                    </th>
                    <th scope="col">
                        รายละเอียด
                    </th>
                    <th scope="col">
                        <center>สถานะ
                    </th>
                    <th scope="col"style="width: 8%">
                        <center>สถานะคืน
                    </th>
                    <th scope="col">
                        <center>จำนวน
                    </th>
                    @if (Session::get('staff') == 'true')
                        <th scope="col">
                            <center>เพิ่มจำนวน
                        </th>
                        <th scope="col">
                            <center>แก้ไข
                        </th>
                        <th scope="col">
                            <center>ส่งซ่อม
                        </th>
                    @else
                    @endif
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @php($i = 1)
                @foreach ($response as $k => $v)
                    <tr class="item{{ $v->id }}">
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $v->name }}</td>
                        <td> {{ Str::limit($v->description, 70) }}</td>
                        @if ($v->is_active == 1)
                            <td class="text-success">
                                <span class="badge badge-success rounded-pill d-inline">เปิดจอง</span>
                            </td>
                        @else
                            <td class="text-danger">
                                <span class="badge badge-danger rounded-pill d-inline">ปิดจอง</span>
                            </td>
                        @endif
                        @if ($v->is_not_return == 1)
                            <td class="text-primary">
                                <center><span class="badge badge-danger rounded-pill d-inline">ไม่คืน</span>
                            </td>
                        @else
                            <td class="text-success">
                                <center><span class="badge badge-success rounded-pill d-inline">คืน</span>
                            </td>
                        @endif
                        <td>
                            {{ $v->amount }}
                        </td>
                        <td>
                            <center><a class="btn btn-primary" href="{{ url('/item/add/stock/' . $v->id) }}">เพิ่ม</a>
                        </td>
                        <td>
                            <center><a class="btn btn-warning" href="{{ url('/item/edit/' . $v->id) }}">แก้ไข</a>
                        </td>
                        <td>
                            <center><a class="btn btn-danger" href="{{ url('/outOfService/add/' . $v->id) }}">ซ่อม</a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset

@endsection
