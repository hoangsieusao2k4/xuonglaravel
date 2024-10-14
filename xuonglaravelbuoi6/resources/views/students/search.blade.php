@extends('master')

@section('content')
    <h1>Danh sách sinh viên</h1>
   <div>
    <div>
        <a href="{{ route('students.create') }}" class="btn btn-primary">Thêm sinh viên</a>
    </div>


    <div class="d-flex justify-content-end">
    <form method="post" action="{{ route('students.search') }}" class="mb-4">
        @csrf
        <div class="input-group ">
            <div class="m-2">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sinh viên" value="{{ request('search') }}">
            </div>
           <div class="m-2">
            <select class="form-control" name="classroom_id">
                @foreach ($classrooms as $classroom)
                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                @endforeach
            </select>
           </div>
           <div class="m-2">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
           </div>
        </div>
    </form>
   </div>
   </div>


    @if (session()->has('succes') && session()->get('succes'))
        <div class="alert alert-primary" role="alert">
            <strong>Thao tác thành công</strong>
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Lớp</th>
                <th>Hộ chiếu</th>
                <th>Ngày cấp</th>
                <th>Ngày hết hạn</th>
                <th>Môn học</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id}}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->classroom->name }}</td>
                    <td>{{ $student->passport->passport_number ?? 'chưa có' }}</td>
                    <td>{{ $student->passport->issued_date ?? 'chưa có' }}</td>
                    <td>{{ $student->passport->expiry_date ?? 'chưa có'}}</td>


                    <td>
                        @foreach ($student->subjects as $subject)
                            {{ $subject->name }}@if (!$loop->last)
                                ,
                            @endif
                        @endforeach

                    </td>
                    <td>
                        <a href="{{ route('students.show', $student) }}" class="btn btn-info">Show</a>

                        <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('có chắc xóa không')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$students->links()}}
@endsection
