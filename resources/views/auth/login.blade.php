@extends('layouts.app')

@section('content')
            <div class="containter">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="card card-login">
                                    <div class="card-header text-center" data-background-color="rose">
                                        <h4 class="card-title">Demo Account Login</h4>
                                        <h5>ID: 1000000, Password: demo1234</h5>
                                    </div>
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group{{ $errors->has('id_no') ? ' has-error' : '' }} label-floating">
                                                <label for="id_no" class="control-label">ID</label>
                                                <input id="id_no" name="id_no" type="text" number="true" required="true" class="form-control" value="{{old('id_no')}}" number="true">
                                                @if ($errors->has('id_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('id_no') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group{{$errors->has('password')?' has-error':''}} label-floating">
                                                <label for="password" class="control-label">Password</label>
                                                <input id="password" required="true" name="password" type="password" class="form-control">
                                                @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="input-group">
                                          <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me
                                                    </label>
                                                </div>
                                          </div>
                                        </div>

                                    </div>
                                    <div class="footer text-center">
                                        <button type="submit" class="btn btn-rose btn-simple btn-wd btn-lg">Go</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
@stop
