@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('order_view') }}">Order</a></li>
            <li class="breadcrumb-item"><a aria-current>Add in booking</a></li>
        </ol>
    </nav>
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
                    <th scope="col">จำนวน</th>
                    <th scope="col">สถานะการคืน</th>
                    <th scope="col">เพิ่ม</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($response as $k => $v)
                    <tr>
                        <th scope="row">{{ $v->id }}</th>
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
