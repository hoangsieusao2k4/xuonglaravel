@extends('master');
@section('content')
    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-danger" role="alert">

            <strong>Thao tác thất bại</strong>
        </div>
    @endif
    <table class="table">
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add</a>
        <tr>
            <th>id</th>
            <th>first_name</th>
            <th>last_name</th>
            <th>email</th>
            <th>phone</th>
            <th>date_of_birth</th>
            <th>hire_date</th>
            <th>salary</th>
            <th>is_active</th>
            <th>address</th>
            <th>department</th>
            <th>manager</th>
            <th>address</th>
            <th>profile_picture</th>
            <th>created_at</th>
            <th>updated_at</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->first_name }}</td>
                <td>{{ $item->last_name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->date_of_birth }}</td>
                <td>{{ $item->hire_date }}</td>
                <td>{{ $item->salary }}</td>
                <td>
                    @if ($item->is_active)
                        <span class="badge bg-primary">Yes</span>
                    @else
                        <span class="badge bg-danger">No</span>
                    @endif
                </td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->department->name }}</td>
                <td>{{ $item->manager->name }}</td>
                <td>{{ $item->address }}</td>
                <td><img src="{{ Storage::url($item->profile_picture) }}" width="100" alt=""></td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->updated_at }}</td>
                <td>
                    <a href="{{ route('employees.show',$item) }}" class="btn btn-info">Show</a>
                    <a href="{{ route('employees.edit', $item) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('employees.destroy',$item) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('có chắc xóa không')" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach

    </table>
    {{$data->links()}}
@endsection
