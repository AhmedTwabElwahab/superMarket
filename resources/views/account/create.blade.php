
@extends('layouts.app')


@section('content')

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('account.index')}}">{{$lang->text('accounts')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('add_account')}}</li>
            </ol>
        </nav>
    </div>

    <div class="row container-body p-3">
        <div class="col-12">
            <div class="col-12 p-0 row">
                <div class="col-12 col-lg-4 py-3 px-3">
                    {{$lang->text('add_account')}}
                </div>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>
        <form class="form" id ='CreateAccount' action="{{route('account.store')}}"
                method="POST"
                enctype="multipart/form-data">
            @csrf

            <div class="row mt-2">
                <div class="form-group col-md-4">
                    <label for="account_type_id">
                        {{$lang->text('account_type')}}
                    </label>
                    <select id="account_type_id" class="form-control js-select">
                        <option value="NULL">--</option>
                        @if(!empty($accountType))
                            @foreach($accountType as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>{{--end of form-group--}}

                <div class="form-group col-md-4">
                    <label for="main_account_id">
                        {{$lang->text('main_account')}}
                    </label>
                    <select id="main_account_id" name="main_account_id" disabled class="form-control js-select">
                        <option value="NULL">--</option>
                    </select>
                </div>{{--end of form-group--}}

                <div class="form-group col-md-4">
                    <label for="sub_account_id">
                        {{$lang->text('sub_account')}}
                    </label>
                    <select id="sub_account_id" name="sub_account_id" disabled class="form-control js-select">
                        <option value="NULL">--</option>
                    </select>
                </div>{{--end of form-group--}}
            </div>

            <div class="row mt-2">
                <table class="table text-center" id="DataTable">
                    <thead>
                        <tr>
                            <th>{{$lang->text('num')}}</th>
                            <th>{{$lang->text('account_name')}}</th>
                            <th>{{$lang->text('notes')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="form-group col-md-3 input-account-name" style="display: none;">
                    <label for="account_name">
                        {{$lang->text('account_name')}}
                    </label>
                    <input type = "text" class="form-control" name="account_name" id= "account_name">
                </div>{{--end of form-group--}}
            </div>

        </form>{{--end of form--}}
    </div>

    <div class="row mt-4">
        <div class="form-group col-md-2">
            <button type="submit" form ="CreateAccount" class="btn btn-primary">
                {{$lang->text('save')}}
            </button>
        </div>
    </div>{{--end of row--}}

@endsection
