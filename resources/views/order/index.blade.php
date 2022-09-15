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
            @isset(request()->massage)
                <p class="text-danger">{{ request()->massage }}</p>
            @endisset
        </div>
    </div>
    @isset($response)
        <table id="example" class="table">
            <thead>
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">start_date</th>
                    <th scope="col">end_date</th>
                    <th scope="col">verify_date</th>
                    <th scope="col">จองเพิ่ม</th>
                    <th scope="col">ดู</th>
                    <th scope="col">ยืนยัน</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($response as $k => $v)
                    <tr>
                        <th scope="row">{{ $v->id }}</th>
                        <td>{{ $v->status }}</td>
                        <td>{{ substr($v->start_date, 0, 10) }}</td>
                        <td>{{ substr($v->end_date, 0, 10) }}</td>
                        <td>{{ substr($v->verify_date, 0, 10) }}</td>
                        @if ($v->status != 'prepairing')
                            <td><button class="btn btn-warning" disabled>จองเพิ่ม</button></td>
                        @else
                            <td><a class="btn btn-warning" href="{{ url('/order/add/item/' . $v->id) }}">จองเพิ่ม</a></td>
                        @endif
                        <td><a class="btn btn-primary" href="{{ url('/order/view/item/' . $v->id) }}">ดู</a></td>
                        @if ($v->status != 'prepairing')
                            <td> <button type="submit" class="btn btn-success" disabled>ยืนยันแล้ว</button> </td>
                        @else
                            <td>
                                <form action="{{ route('order_confirm') }}" method="post">
                                    @csrf
                                    <input type="number" name="id" value={{ $v->id }} hidden>
                                    <input type="datetime" name="start_date" value={{ $v->start_date }} hidden>
                                    <input type="datetime" name="end_date" value={{ $v->end_date }} hidden>
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
