@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a aria-current>history</a></li>
                </ol>
            </nav>
        </div>
        <div class="col">
            @isset(request()->message)
                <p class="text-danger">{{ request()->message }}</p>
            @endisset
        </div>
    </div>
    @isset($response)
        <table id="example" class="table">
            <thead>
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">ผู้จอง</th>
                    <th scope="col">status</th>
                    <th scope="col">start_date</th>
                    <th scope="col">end_date</th>
                    <th scope="col">verify_date</th>
                    <th scope="col">ดู</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach ($response as $k => $v)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ Str::limit($v->name, 20) }}</td>
                        <td>{{ $v->status }}</td>
                        <td>{{ $v->start_date }}</td>
                        <td>{{ $v->end_date }}</td>
                        <td>{{ $v->verify_date }}</td>
                        <td><a class="btn btn-primary" href="{{ url('/confirm/view/item/' . $v->id) }}">ดู</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset
@endsection