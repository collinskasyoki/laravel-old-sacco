@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card card-signup">
                <div class="card-header text-center" data-background-color="rose">
                    <h3 class="card-title">Register</h3>
                </div>

                <div class="card-content">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-12 control-label" style="color:black">Name</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('id_no') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-12 control-label" style="color:black">ID NUMBER</label>

                            <div class="col-md-12">
                                <input id="id_no" type="text" class="form-control" name="id_no" value="{{ old('id_no') }}" required autofocus>

                                @if ($errors->has('id_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-12 control-label" style="color:black">Phone</label>

                            <div class="col-md-12">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-12 control-label" style="color:black">E-Mail Address</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-12 control-label" style="color:black">Password</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-12 control-label" style="color:black">Confirm Password</label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                      </div>

                        <div class="">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-rose btn-simple btn-wd btn-lg">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
