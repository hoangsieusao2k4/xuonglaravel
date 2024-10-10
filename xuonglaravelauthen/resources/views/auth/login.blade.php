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
        <form method="POST" action="{{route('login')}}" >
            @csrf
            <div class="form-group">
                <div class="fxt-transformY-50 fxt-transition-delay-1">
                    <input type="email" id="email" class="form-control" name="email" placeholder="Email" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="fxt-transformY-50 fxt-transition-delay-2">
                    <input id="password" type="password" class="form-control" name="password" placeholder="********" required="required">
                    <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                </div>
            </div>
            <div class="form-group">
                <div class="fxt-transformY-50 fxt-transition-delay-3">
                    <div class="fxt-checkbox-area">
                        <div class="checkbox">
                            <input id="checkbox1" name="remember" type="checkbox">
                            <label for="checkbox1">Keep me logged in</label>
                        </div>
                        <a href="{{route('showformforgot')}}" class="switcher-text">Forgot Password</a>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="fxt-transformY-50 fxt-transition-delay-4">
                    <button type="submit" class="fxt-btn-fill">Log in</button>
                </div>
            </div>
        </form>
    </div>
    <div class="fxt-footer">
        <div class="fxt-transformY-50 fxt-transition-delay-9">
            <p>Don't have an account?<a href="register-9.html" class="switcher-text2 inline-text">Register</a></p>
        </div>
    </div>
</div>

@endsection
