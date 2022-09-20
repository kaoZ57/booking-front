@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a aria-current>Out of service</a></li>
                </ol>
            </nav>
        </div>
        <div class="col">
            <center>
                <h3>จัดการรายการเซอร์วิส</h3>
        </div>
        <div class="col">
            @isset(request()->message)
                <p class="text-danger">{{ request()->message }}</p>
            @endisset
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
