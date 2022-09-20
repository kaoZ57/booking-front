@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('confirm_view') }}">Booking Confirm</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </nav>
        </div>
        <div class="col">

            {{-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-success me-md-2" href="{{ route('item_add_view') }}" type="button">เพิ่มสิ่งของ</a>
            </div> --}}
        </div>
    </div>
    {{-- @isset(session('message'))
        <h3 class="text-danger">{{ session('message') }}</h3>
    @endisset --}}
    @isset($response)
        <div class="row">
            <div class="col">
                <h3>สถานะ {{ $response->status }}</h3>
                <h3>เริ่ม {{ $response->start_date }}</h3>
                <h3>วันคืน {{ $response->end_date }}</h3>
            </div>
            <div class="col">

                {{-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-success me-md-2" href="{{ route('item_add_view') }}" type="button">เพิ่มสิ่งของ</a>
                </div> --}}
            </div>
        </div>
        <br>
        <form action="{{ route('confirm_status_item') }}" method="post">
            @csrf
            <table id="example" class="table align-middle mb-0 bg-white">
                <thead class="bg-light">
                    <tr>
                        <th scope="col">รหัส</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">โน้ตผู้จอง</th>
                        <th scope="col">โน้ตร้าน</th>
                        <th scope="col">จำนวน</th>
                        <th scope="col">โน้ต</th>
                        <th scope="col">อนุญาติ</th>
                        <th scope="col">ไม่อนุญาติ</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i = 1)
                    @php($o = 1)
                    @php($n = 1)
                    @foreach ($response->booking_item as $k => $v)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $v->name }}</td>
                            <td>{{ $v->status }}</td>
                            <td>{{ Str::limit($v->note_user, 20) }}</td>
                            <td>{{ $v->note_owner }}</td>
                            <td>{{ $v->amount }}</td>
                            @if ($v->status == 'reject')
                                <td>
                                    <input type="number" name={{ 'id' . strval($n) }} value={{ $v->id }} hidden>
                                    <input type="number" name={{ 'status_id' . strval($n) }} value={{ $v->status_id }}
                                        hidden>
                                    {{-- <input type="number" name="status_id" value={{ $v->status_id }} hidden> --}}
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        name={{ 'note_owner' . strval($n) }} value={{ $v->note_owner }} readonly>
                                </td>
                                <div class="form-check form-check-inline">
                                    <td>
                                        <input class="form-check-input" type="radio" name={{ 'radio' . strval($n) }}
                                            id={{ 'inlineRadio' . strval($o) }} value="1" disabled />
                                        <label class="form-check-label" for={{ 'inlineRadio' . strval($o) }}>อนุญาติ</label>
                                        {{-- {{ 'inlineRadio' . strval($o) }} --}}
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name={{ 'radio' . strval($n) }}
                                            id={{ 'inlineRadio' . strval($o + 1) }} value="0" checked disabled />
                                        <label class="form-check-label"
                                            for={{ 'inlineRadio' . strval($o + 1) }}>ไม่อนุญาติ</label>
                                        {{-- {{ 'option' . strval($o + 1) }} --}}
                                        <input value={{ $o++ }} hidden>
                                    </td>
                                </div>
                            @elseif ($v->status == 'returned')
                                <td>
                                    <input type="number" name={{ 'id' . strval($n) }} value={{ $v->id }} hidden>
                                    <input type="number" name={{ 'status_id' . strval($n) }} value={{ $v->status_id }}
                                        hidden>
                                    {{-- <input type="number" name="status_id" value={{ $v->status_id }} hidden> --}}
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        name={{ 'note_owner' . strval($n) }} value={{ $v->note_owner }} readonly>
                                </td>
                                <div class="form-check form-check-inline">
                                    <td>
                                        <input class="form-check-input" type="radio" name={{ 'radio' . strval($n) }}
                                            id={{ 'inlineRadio' . strval($o) }} value="1" checked disabled />
                                        <label class="form-check-label" for={{ 'inlineRadio' . strval($o) }}>อนุญาติ</label>
                                        {{-- {{ 'inlineRadio' . strval($o) }} --}}
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name={{ 'radio' . strval($n) }}
                                            id={{ 'inlineRadio' . strval($o + 1) }} value="0" disabled />
                                        <label class="form-check-label"
                                            for={{ 'inlineRadio' . strval($o + 1) }}>ไม่อนุญาติ</label>
                                        {{-- {{ 'option' . strval($o + 1) }} --}}
                                        <input value={{ $o++ }} hidden>
                                    </td>
                                </div>
                            @elseif ($v->status == 'approve' || $v->status == 'lending')
                                <td>
                                    <input type="number" name={{ 'id' . strval($n) }} value={{ $v->id }} hidden>
                                    <input type="number" name={{ 'status_id' . strval($n) }} value={{ $v->status_id }}
                                        hidden>
                                    {{-- <input type="number" name="status_id" value={{ $v->status_id }} hidden> --}}
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        name={{ 'note_owner' . strval($n) }} value={{ $v->note_owner }} readonly>
                                </td>
                                <div class="form-check form-check-inline">
                                    <td>
                                        <input class="form-check-input" type="radio" name={{ 'radio' . strval($n) }}
                                            id={{ 'inlineRadio' . strval($o) }} value="1" checked />
                                        <label class="form-check-label" for={{ 'inlineRadio' . strval($o) }}>อนุญาติ</label>
                                        {{-- {{ 'inlineRadio' . strval($o) }} --}}
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name={{ 'radio' . strval($n) }}
                                            id={{ 'inlineRadio' . strval($o + 1) }} value="0" disabled />
                                        <label class="form-check-label"
                                            for={{ 'inlineRadio' . strval($o + 1) }}>ไม่อนุญาติ</label>
                                        {{-- {{ 'option' . strval($o + 1) }} --}}
                                        <input value={{ $o++ }} hidden>
                                    </td>
                                </div>
                            @else
                                <td>
                                    <input type="number" name={{ 'id' . strval($n) }} value={{ $v->id }} hidden>
                                    <input type="number" name={{ 'status_id' . strval($n) }} value={{ $v->status_id }}
                                        hidden>
                                    {{-- <input type="number" name="status_id" value={{ $v->status_id }} hidden> --}}
                                    <input type="text" class="form-control" id="exampleFormControlInput1"
                                        name={{ 'note_owner' . strval($n) }} value={{ $v->note_owner }}>
                                </td>
                                <div class="form-check form-check-inline">
                                    <td>
                                        <input class="form-check-input" type="radio" name={{ 'radio' . strval($n) }}
                                            id={{ 'inlineRadio' . strval($o) }} value="1" checked />
                                        <label class="form-check-label" for={{ 'inlineRadio' . strval($o) }}>อนุญาติ</label>
                                        {{-- {{ 'inlineRadio' . strval($o) }} --}}
                                    </td>
                                    <td>
                                        <input class="form-check-input" type="radio" name={{ 'radio' . strval($n) }}
                                            id={{ 'inlineRadio' . strval($o + 1) }} value="0" />
                                        <label class="form-check-label"
                                            for={{ 'inlineRadio' . strval($o + 1) }}>ไม่อนุญาติ</label>
                                        {{-- {{ 'option' . strval($o + 1) }} --}}
                                        <input value={{ $o++ }} hidden>
                                    </td>
                                </div>
                            @endif

                            {{ $o++ }}
                            {{ $n++ }}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($response->status == 'complete')
            @else
                <br>
                <div class="row">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <td><button type="submit" class="btn btn-primary">ยืนยัน</button></td>
                    </div>
                </div>
            @endif

        </form>
    @endisset

@endsection
