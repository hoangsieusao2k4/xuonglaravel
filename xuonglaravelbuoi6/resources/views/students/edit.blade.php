@extends('master')
@section('content')
    <h1>Cập nhật sinh viên {{ $students->name }}</h1>
    <br>
    @if (session()->has('succes') && session()->get('succes'))
        <div class="alert alert-primary" role="alert">
            <strong>Thao tác thành công</strong>
        </div>
    @endif
    @if (session()->has('succes') && !session()->get('succes'))
        <div class="alert alert-danger" role="alert">
            <strong>Thao tác thất bại</strong>
        </div>
    @endif
    <form action="{{ route('students.update', $students) }}" method="POST">
        @csrf
        @method('PUT')
        <label class="form-label">Tên:</label>
        <input type="text" name="name" value="{{ $students->name }}" class="form-control">
        <label class="form-label">Email:</label>
        <input type="email" name="email" value="{{ $students->email }}" class="form-control">
        <label class="form-label">Lớp học:</label>
        <select class="form-control" name="classroom_id">
            @foreach ($classrooms as $classroom)
                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
            @endforeach
        </select>
        <label class="form-label">Số hộ chiếu:</label>
        <input type="text" class="form-control" value="{{ $students->passport->passport_number ?? 0 }}"
            name="passport_number">
        <label class="form-label">Ngày cấp:</label>
        <input type="date" class="form-control" value="{{ $students->passport->issued_date ?? 0 }}" name="issued_date">
        <label class="form-label">Ngày hết hạn:</label>
        <input type="date" class="form-control" value="{{ $students->passport->expiry_date ?? 0 }}" name="expiry_date">
        <label class="form-label">Môn học:</label>
        <select name="subject_ids[]" class="form-select" multiple>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" {{ $students->subjects->contains($subject->id) ? 'selected' : '' }}>
                    {{ $subject->name }}</option>
            @endforeach
        </select>
        <div class="mt-2">
            <a class="btn btn-info " href="{{route('students.index')}}" >Quay lại</a>

        <button class="btn btn-primary " type="submit">Lưu</button>
        </div>
    </form>
@endsection
