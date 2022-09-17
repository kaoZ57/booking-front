@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a aria-current>Out of service</a></li>
        </ol>
    </nav>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        {{-- <a class="btn btn-success me-md-2" href="{{ route('item_add_view') }}" type="button">เพิ่มสิ่งของ</a> --}}
    </div>
    @isset($message)
        <p class="text-danger">{{ $message }}</p>
    @endisset
    @isset($response)
        <table id="example" class="table">
            <thead>
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">item</th>
                    <th scope="col">โน้ต</th>
                    <th scope="col">จำนวน</th>
                    <th scope="col">นำกลับมาใช้งาน</th>
                </tr>
            </thead>
            <tbody>

                @php($i = 1)
                @foreach ($response as $k => $v)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $v->name }}</td>
                        <td> {{ Str::limit($v->note, 70) }}</td>
                        <td>{{ $v->amount }}</td>
                        <td>
                            <form action="{{ route('outOfService_edit') }}" method="post">
                                @csrf
                                <input type="number" name="id" value={{ $v->id }} hidden>
                                <button type="submit" class="btn btn-success">เพื่มกลับ</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endisset

@endsection
