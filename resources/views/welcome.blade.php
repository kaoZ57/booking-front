@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a aria-current="page">Home</a></li>
                </ol>
            </nav>
        </div>
        <div class="col">
            <h3>
                @isset($storedata)
                    {{ $storedata[0]->name }}
                @endisset
            </h3>
        </div>
        <div class="col"></div>
    </div>

    @isset($message)
        <p class="text-danger">{{ $message }}</p>
    @endisset
    @isset($itemdata)
        <table id="example" class="table">
            <thead>
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">รายละเอียด</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">สถานะการคืน</th>
                    <th scope="col">จำนวน</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach ($itemdata as $k => $v)
                    <tr class="item{{ $v->id }}">
                        <th scope="row">{{ $i++ }}</th>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset

@endsection
