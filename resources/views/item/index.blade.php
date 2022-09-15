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

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-success me-md-2" href="{{ route('item_add_view') }}" type="button">เพิ่มสิ่งของ</a>
            </div>
        </div>
    </div>

    @isset($massage)
        <p class="text-danger">{{ $massage }}</p>
    @endisset
    @isset($response)
        <table id="example" class="table">
            <thead>
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">รายละเอียด</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">สถานะการคืน</th>
                    <th scope="col">จำนวน</th>
                    @if (Session::get('staff') == 'true')
                        <th scope="col">แก้ไข</th>
                        <th scope="col">เพิ่มจำนวน</th>
                        <th scope="col">ส่งซ่อม</th>
                    @else
                    @endif

                </tr>
            </thead>
            <tbody>
                @foreach ($response as $k => $v)
                    <tr class="item{{ $v->id }}">
                        <th scope="row">{{ $v->id }}</th>
                        <td>{{ $v->name }}</td>
                        <td> {{ Str::limit($v->description, 70) }}</td>
                        @if ($v->is_active == 1)
                            <td class="text-success">เปิดจอง</td>
                        @else
                            <td class="text-danger">ปิดจอง</td>
                        @endif
                        @if ($v->is_not_return == 1)
                            <td class="text-primary">ไม่ต้องคืน</td>
                        @else
                            <td class="text-success">คืน </td>
                        @endif
                        <td>{{ $v->amount }}</td>
                        @if (Session::get('staff') == 'true')
                            <td><a class="btn btn-warning" href="{{ url('/item/edit/' . $v->id) }}">แก้ไข</a></td>
                            <td><a class="btn btn-primary" href="{{ url('/item/add/stock/' . $v->id) }}">เพิ่ม</a></td>
                            <td><a class="btn btn-danger" href="{{ url('/outOfService/add/' . $v->id) }}">ส่งซ่อม</a></td>
                        @else
                        @endif

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset

@endsection
