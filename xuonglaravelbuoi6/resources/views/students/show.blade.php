@extends('master')

@section('content')
    <h1>Chi tiết sinh viên{{ $students->name }}</h1>


    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Tên Trường</th>
                <th>Dữ liệu</th>

            </tr>
        </thead>
        <tbody>
            {{-- @dd($students->toArray()); --}}
            @foreach ($students->toArray() as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>
                        @switch($key)
                            @case('passport')
                                {{ $students->passport->passport_number }}
                            @break

                            @case('classroom')
                                {{ $students->classroom->name }}
                            @break

                            @case('subjects')
                                @foreach ($students->subjects as $subject)
                                    {{ $subject->name }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @break

                            @default
                                {{ $value }}
                        @endswitch
                    </td>

                </tr>
            @endforeach



        </tbody>


    </table>
    <a href="{{ route('students.index') }}" class="btn btn-primary">Quay lại</a>
@endsection
