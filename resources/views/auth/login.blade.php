<?php
use App\helper\Language;
/**
 * @var Language $lang
 *
 */
?>
@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="width: 100%;height: 100%">
        <div class="row justify-content-around">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header">{{ $lang->sideMenu('Login') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="">
                                <div class="form-group row justify-content-around mb-3">
                                    <div class="col-md-6">
                                        <input id="username" type="text"
                                               placeholder="{{ $lang->sideMenu('username')}}"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="username"
                                               value="{{ old('username') }}"
                                               required
                                               autocomplete="email"
                                               autofocus>
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row justify-content-around mb-3">
                                    <div class="col-md-6">
                                        <input id="password"
                                               type="password"
                                               placeholder="{{ $lang->sideMenu('Password')}}"
                                               name="password"
                                               required
                                               autocomplete="current-password"
                                               class="form-control @error('password') is-invalid @enderror" >
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ $lang->sideMenu('Login')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
