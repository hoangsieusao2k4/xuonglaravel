@extends('master');
@section('content')
<div class="fxt-content">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <h2>Login into your account</h2>
    <div class="fxt-form">
        {{session()->get('otp')}}
        <form method="POST" action="{{route('Otp')}}" >
            @csrf
            <div class="form-group">
                <div class="fxt-transformY-50 fxt-transition-delay-1">
                    <input type="text"  class="form-control" name="otp" placeholder="Otp" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="fxt-transformY-50 fxt-transition-delay-4">
                    <button type="submit" class="fxt-btn-fill">Xác nhận</button>
                </div>
            </div>
        </form>

</div>

@endsection
