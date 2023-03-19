<?php
use App\Models\Client;
/**
 * @var Client $client
 */
?>
@extends('layouts.app')

@section('content')

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('client.index')}}">{{$lang->text('clients')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('add_client')}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body p-3">
        <div class="col-12">
            <div class="col-12 p-0 row">
                <div class="col-12 col-lg-4 py-3 px-3">
                    {{$lang->text('add_client')}}
                </div>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>
        <form class="form" id ='CreateClient' action="{{route('client.store')}}"
                method="POST"
                enctype="multipart/form-data">
            @csrf

            <div class="row mt-2">
                <div class="form-group col-md-4">
                    <label for  = "client_name_input">
                        {{$lang->text('client_name')}}
                    </label>
                    <input type = "text" class="form-control"
                            name = "name"
                            id   = "client_name_input">
                    @error("name")
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}

                <div class="form-group col-md-4">
                    <label for  = "email_input">
                        {{$lang->text('email')}}
                    </label>
                    <input type  = "email" class="form-control"
                            name = "email"
                            id   = "email_input">
                    @error("email")
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}
            </div>{{--end of row--}}

            <div class="row">
                <div class="form-group col-md-4">
                    <label for  = "number_input">
                        {{$lang->text('number')}}
                    </label>
                    <input type = "text" class="form-control"
                            name = "number"
                            id   = "number_input">
                    @error("number")
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}
                <div class="form-group col-md-4">
                    <label for  = "phone_input">
                        {{$lang->text('phone')}}
                    </label>
                    <input type = "text" class="form-control"
                            name = "phone"
                            id   = "phone_input">
                    @error("phone")
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}
                <div class="form-group col-md-4">
                    <label for  = "whatsApp_input">
                        {{$lang->text('whatsApp')}}
                    </label>
                    <input type = "text" class="form-control"
                            name = "whatsApp"
                            id   = "whatsApp_input">
                    @error("whatsApp")
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}
            </div>

            <div class="row mt-2">
                <div class="form-group col-md-12">
                    <label for="address_input">{{$lang->text('address')}}</label>
                    <input type="text" class="form-control"
                            name="address" id="address_input">
                    @error("address")
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}
            </div>{{--end of row--}}
            
        </form>{{--end of form--}}
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-2">
            <button type="submit" form ="CreateClient" class="btn btn-primary">
                {{$lang->text('client_save')}}
            </button>
        </div>
    </div>{{--end of row--}}

@endsection