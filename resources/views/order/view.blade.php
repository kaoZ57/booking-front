{{-- <script>
    window.location.reload();
</script> --}}
@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('order_view') }}">Order</a></li>
            <li class="breadcrumb-item"><a aria-current>Item in booking</a></li>
        </ol>
    </nav>
    @isset($message)
        <p class="text-danger">{{ $message }}</p>
    @endisset
    @isset($response)
        @if ($response->status == 'prepairing')
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-warning" href="{{ url('/order/view/edit/booking/' . $response->id) }}">แก้ไขวันจอง</a>
                <a class="btn btn-warning" href="{{ url('/order/add/item/' . $response->id) }}">จองเพิ่ม</a>
                <form action="{{ route('order_confirm') }}" method="post">
                    @csrf
                    <input type="number" name="id" value={{ $response->id }} hidden>
                    <input type="text" name="start_date" value='{{ $response->start_date }}' hidden>
                    <input type="text" name="end_date" value='{{ $response->end_date }}' hidden>
                    <button type="submit" class="btn btn-success">ยืนยัน</button>
                </form>
            </div>
        @else
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-warning" disabled>แก้ไขวันจอง</button>
                <button class="btn btn-warning" disabled>จองเพิ่ม</button>
                <button type="submit" class="btn btn-success" disabled>ยืนยัน</button>

            </div>
        @endif

        <h3>สถานะ {{ $response->status }}</h3>
        <h3>เริ่ม {{ $response->start_date }}</h3>
        <h3>วันคืน {{ $response->end_date }}</h3>
        <br>
        <table id="example" class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th scope="col">รหัส</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">โน้ตผู้จอง</th>
                    <th scope="col">โน้ตร้าน</th>
                    <th scope="col">จำนวน</th>
                    <th scope="col">แก้ไข</th>
                    <th scope="col">ลบ</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach ($response->booking_item as $k => $v)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $v->name }}</td>
                        <td>{{ $v->status }}</td>
                        <td>{{ $v->note_user }}</td>
                        <td>{{ $v->note_owner }}</td>
                        <td>{{ $v->amount }}</td>
                        @if ($response->status == 'prepairing')
                            <td>
                                <form action="{{ route('order_item_edit_view') }}" method="get">
                                    <input value={{ $v->id }} name="booking_item_id" hidden />
                                    <input value={{ $response->id }} name="booking_id" hidden />
                                    <button class="btn btn-warning" type="submit">แก้ไข</button>
                                </form>
                            </td>
                        @else
                            <td><button class="btn btn-warning" type="submit" disabled>แก้ไข</button> </td>
                        @endif

                        @if ($response->status == 'prepairing')
                            <td>
                                <form action="{{ route('order_item_delete') }}" method="post"
                                    onclick="return confirm('Are you sure?')">
                                    @csrf
                                    <input value={{ $v->id }} name="booking_item_id" hidden />
                                    <input value={{ $response->id }} name="booking_id" hidden />
                                    <button class="btn btn-danger" type="submit">ลบ</button>
                                </form>
                            </td>
                        @else
                            <td><button class="btn btn-danger" type="submit" disabled>ลบ</button> </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset

@endsection
