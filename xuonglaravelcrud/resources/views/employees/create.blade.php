@extends('master')
@section('content')
    <h1>Thêm mới</h1>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-danger" role="alert">

            <strong>Thao tác thất bại</strong>
        </div>
    @endif
    <form action="{{ route('employees.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div>
                <label for="" class="form-label">first_name</label>
                <input type="text" name="first_name" value="{{old('first_name')}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">last_name</label>
                <input type="text" name="last_name" value="{{old('last_name')}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">email</label>
                <input type="email" name="email" value="{{old('email')}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">phone</label>
                <input type="text" name="phone" value="{{old('phone')}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">date_of_birth</label>
                <input type="date" name="date_of_birth" value="{{old('date_of_birth')}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">hire_date</label>
                <input type="datetime-local" name="hire_date" value="{{old('hire_date')}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>

                <label for="" class="form-label">salary</label>
                <input type="text" name="salary" value="{{old('salary')}}" id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">is_active</label>
                <input type="checkbox" name="is_active" value="1" class="form-checkbox" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">address</label>
                <input name="address" value="{{old('address')}}"  class="form-control"></input>
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">manager_id</label>
                <select name="manager_id"  id="">
                    @foreach ($manager as $item1)
                        <option value="{{ $item1->id }}">{{ $item1->name }}</option>
                    @endforeach

                </select>
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">department_id</label>
                <select name="department_id"  id="">
                    @foreach ($department as $item2)
                        <option value="{{ $item2->id }}">{{ $item2->name }}</option>
                    @endforeach

                </select>
            </div>

        </div>
        <div class="mb-3">
            <div>
                <label for="" class="form-label">profile_picture</label>
                <input type="file" name="profile_picture"  id="" class="form-control" placeholder="" />
            </div>

        </div>
        <div class="mb-3">
            <div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
    </form>
@endsection
