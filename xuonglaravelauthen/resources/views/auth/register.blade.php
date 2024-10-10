@extends('master');
@section('content')
<div class="fxt-content">
    <h2>Register for new account</h2>
    <div class="fxt-form">
        <form method="POST" action="{{route('register')}}">
            @csrf
            <div class="form-group">
                <div class="fxt-transformY-50 fxt-transition-delay-1">
                    <input type="text" id="name" class="form-control" name="name" placeholder="Name" required="required">
                </div>
            </div>
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
                            <input id="checkbox1" type="checkbox">
                            <label for="checkbox1">Keep me logged in</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="fxt-transformY-50 fxt-transition-delay-4">
                    <button type="submit" class="fxt-btn-fill">Register</button>
                </div>
            </div>
        </form>
    </div>
    <div class="fxt-footer">
        <div class="fxt-transformY-50 fxt-transition-delay-9">
            <p>Already have an account?<a href="login-9.html" class="switcher-text2 inline-text">Log in</a></p>
        </div>
    </div>
</div>

@endsection
