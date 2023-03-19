
@extends('layouts.app')

@section('content')
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('accounts')}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body">
        <div class="row">
            <div class="col-md-6">
                {{$lang->text('accounts')}}
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a href="{{route('account.create')}}">
                    <span class="btn btn-primary">
                        <span class="fas fa-plus"></span>
                        {{$lang->text('add_account')}}
                    </span>
                </a>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>

        <table class="table text-center" id="DataTable">
            <thead>
                <tr>
                    <th>{{$lang->text('num')}}</th>
                    <th>{{$lang->text('name')}}</th>
                    <th>{{$lang->text('sub_account')}}</th>
                    <th>{{$lang->text('total_Debit_balance')}}</th>
                    <th>{{$lang->text('total_credit_balance')}}</th>
                    <th>{{$lang->text('debit_balance')}}</th>
                    <th>{{$lang->text('credit_balance')}}</th>
                    <th>{{$lang->text('control')}}</th>
                </tr>
            </thead>
            <tbody>
                @isset($accounts)
                    @foreach($accounts as $index => $account)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$account ->name}}</td>
                            <td>{{$account ->subAccount->name}}</td>
                            <td>{{number_format($account -> total_Debit_balance,2.00)}}</td>
                            <td>{{number_format($account -> total_credit_balance,2.00)}}</td>
                            <td>
                                @if($account -> debit_balance != 0)
                                    <span class="badge text-bg-success">
                                        {{number_format($account -> debit_balance,2.00)}}
                                    </span>
                                @else
                                    {{number_format($account -> debit_balance,2.00)}}
                                @endif
                            </td>
                            <td>
                                @if($account -> credit_balance != 0)
                                    <span class="badge text-bg-danger">
                                        {{number_format($account -> credit_balance,2.00)}}
                                    </span>
                                @else
                                    {{number_format($account -> credit_balance,2.00)}}
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{route('account.show',$account -> id)}}"
                                       class="btn box-shadow-3 ">
                                        <i class="fa-solid fa-list" style="color:#0048ff"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
        <div class="d-flex justify-content-center" id="paginate">
            {!! $accounts->links() !!}
        </div>
    </div>

@endsection


