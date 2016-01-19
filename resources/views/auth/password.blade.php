@extends('profile.master')

@section('title', 'This is SuyaBay #TISb')

@endsection

@section('content')
<div>
    @if(session('status'))
        <div class="alert alert-success" style="text-align: center; margin-top: -20px;">
            {{ session('status') }}
        </div>
    @endif
</div>
<form method="POST" action="/password/email">
    {!! csrf_field() !!}

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        <button type="submit">
            Send Password Reset Link
        </button>
    </div>
</form>