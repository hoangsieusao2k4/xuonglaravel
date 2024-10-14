@extends('master')
@section('content')

    @if (session()->has('succes') && !session()->get('succes'))
        <div class="alert alert-danger" role="alert">
            <strong>Thao tác thất bại</strong>
        </div>
    @endif
    <h1>Thêm sinh viên</h1>
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach ($errors->all() as $error)
      <li>{{$error}}</li>

      @endforeach
    </div>
@endif
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <label class="form-label">Tên:</label>
        <input type="text" name="name" class="form-control">
        <label class="form-label">Email:</label>
        <input type="email" name="email" class="form-control">
        <label class="form-label">Lớp học:</label>
        <select class="form-control" name="classroom_id">
            @foreach ($classrooms as $classroom)
                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
            @endforeach
        </select>
        <label class="form-label">Số hộ chiếu:</label>
        <input type="text" class="form-control" name="passport_number">
        <label class="form-label">Ngày cấp:</label>
        <input type="date" class="form-control" name="issued_date">
        <label class="form-label">Ngày hết hạn:</label>
        <input type="date" class="form-control" name="expiry_date">
        <label class="form-label">Môn học:</label>
        <select class="form-control" name="subject_ids[]" multiple>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>
        <div class="mt-2">
            <a class="btn btn-info " href="{{ route('students.index') }}">Quay lại</a>

            <button class="btn btn-primary " type="submit">Lưu</button>
        </div>
    </form>
@endsection
