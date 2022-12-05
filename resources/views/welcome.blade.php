@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-6 col-md-1">
            {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a aria-current="page">Home</a></li>
                    </ol>
                </nav> --}}
        </div>
        <div class="col-6 col-md-10">
            <h3>
                @isset($storedata)
                    <center>
                        {{ $storedata[0]->name }}
                    </center>
                @endisset
            </h3>
        </div>
        <div class="col-6 col-md-1"></div>
    </div>

    @isset($message)
        <p class="text-danger">{{ $message }}</p>
    @endisset
    @isset($itemdata)
        <br>
        <table id="example" class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">รายละเอียด</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">สถานะคืน</th>
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
                        <td>{{ $v->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset

@endsection
