@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a aria-current>Dashboard</a></li>
        </ol>
    </nav>
    {{-- <div class="d-grid gap-2 col-6 mx-auto">
        <a class="btn btn-primary" href="{{ route('dashboard_add_staff') }}" type="button">เพิ่มสตาฟ</a>
    </div> --}}
    @isset($message)
        <p class="text-danger">{{ $message }}</p>
    @endisset
    @isset($response)
        <br>
        <table id="example" class="table">
            <thead class="bg-light">
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">email</th>
                    <th scope="col">เพื่มสตาฟ</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach ($response as $k => $v)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $v->name }}</td>
                        <td>{{ $v->email }}</td>
                        <td>
                            <form action="{{ route('dashboard_add_staff') }}" method="post">
                                @csrf
                                <input type="number" name="user_id" value={{ $v->id }} hidden>
                                <button type="submit" class="btn btn-success">เพื่ม</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset

@endsection
