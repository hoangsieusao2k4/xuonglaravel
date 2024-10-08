@extends('master')
@section('content')
    <h1>Cập nhật</h1>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    @if (session()->has('success') && session()->get('success'))
        <div class="alert alert-primary" role="alert">

            <strong>Thao tác thành công</strong>
        </div>
    @endif
    @if (session()->has('success') && !session()->get('success'))
    <div class="alert alert-danger" role="alert">

        <strong>Thao tác thất bại</strong>
    </div>
@endif
@if (session()->has('error') && session()->get('error'))
{{$error}}
@endif
    <form action="{{ route('employees.update',$employee) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <div>
                <label for="" class="form-label">first_name</label>
                <input type="text" name="first_name" value="{{$employee->first_name}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">last_name</label>
                <input type="text" name="last_name" value="{{$employee->last_name}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">email</label>
                <input type="email" name="email" value="{{$employee->email}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">phone</label>
                <input type="text" name="phone" value="{{$employee->phone}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">date_of_birth</label>
                <input type="date" name="date_of_birth" value="{{$employee->date_of_birth}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">hire_date</label>
                <input type="datetime-local" name="hire_date" value="{{$employee->hire_date}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>

                <label for="" class="form-label">salary</label>
                <input type="text" name="salary" value="{{$employee->salary}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">is_active</label>
                <input type="checkbox" name="is_active" value="1" @checked($employee->is_active) class="form-checkbox" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">address</label>
                <input name="address" value="{{$employee->address}}"  class="form-control"></input>
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">manager_id</label>
                <select name="manager_id"  id="">
                    @foreach ($manager as $item1)


                        <option selected value="{{ $item1->id }}" {{ $item1->id == $employee->manager_id ? 'selected' : '' }}>{{ $item1->name }}</option>


                    @endforeach

                </select>
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">department_id</label>
                <select name="department_id"  id="">
                    @foreach ($department as $item2)
                        <option value="{{ $item2->id }}" {{ $item2->id == $employee->manager_id ? 'selected' : '' }}>{{ $item2->name }}</option>
                    @endforeach

                </select>
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">profile_picture</label>
                <input type="file" name="profile_picture"  id="" class="form-control" placeholder="" />
                <img src="{{Storage::url($employee->profile_picture)}}" width="100" alt="">
            </div>

        </div>
        <div class="mb-3">
            <div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{route('employees.index')}}" class="btn btn-info">Back to list</a>

            </div>

        </div>
    </form>
@endsection
