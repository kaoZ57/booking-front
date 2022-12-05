@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a aria-current>Dashboard</a></li>
                </ol>
            </nav>
        </div>
        <div class="col">
            <center>
                <h3>เพิ่มผู้ช่วยจัดการ</h3>
        </div>
        <div class="col">
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
                    <th scope="col">ชื่อ</th>
                    <th scope="col">
                        สตาฟ
                    </th>
                    <th scope="col">อีเมล์</th>
                    <th scope="col">
                        เพื่มสตาฟ
                    </th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach ($response as $k => $v)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $v->name }}</td>
                        @if ($v->is_staff == 'true')
                            <td> <span class="badge badge-success rounded-pill d-inline">ใช่</span></td>
                        @else
                            <td> <span class="badge badge-danger rounded-pill d-inline">ไม่</span></td>
                        @endif
                        <td>{{ $v->email }}</td>
                        @if ($v->is_staff == 'true')
                            <td> <button type="submit" class="btn btn-success" disabled>เพื่ม</button> </td>
                        @else
                            <td>
                                <form action="{{ route('dashboard_add_staff') }}" method="post">
                                    @csrf
                                    <input type="number" name="user_id" value={{ $v->id }} hidden>
                                    <button type="submit" class="btn btn-success">เพื่ม</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset
@endsection
