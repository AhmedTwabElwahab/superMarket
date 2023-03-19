
@extends('layouts.app')

@section('content')
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('receipts')}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body">
        <div class="row">
            <div class="col-md-6">
                {{$lang->text('receipts')}}
            </div>
            <div class="col-md-3 d-flex justify-content-end">
                <a href="{{route('receipt.create','rec='.RECEIPT_IN)}}">
                    <span class="btn btn-primary">
                        <span class="fas fa-plus"></span>
                        {{$lang->text('receipt_in')}}
                    </span>
                </a>
            </div>
            <div class="col-md-3 d-flex justify-content-end">
                <a href="{{route('receipt.create','rec='.RECEIPT_OUT)}}">
                    <span class="btn btn-danger">
                        <span class="fas fa-plus"></span>
                        {{$lang->text('receipt_out')}}
                    </span>
                </a>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>

        <table class="table text-center" id="DataTable">
            <thead>
                <tr>
                    <th>{{$lang->text('num')}}</th>
                    <th>{{$lang->text('status')}}</th>
                    <th>{{$lang->text('account')}}</th>
                    <th>{{$lang->text('balance')}}</th>
                    <th>{{$lang->text('cash_box')}}</th>
                    <th>{{$lang->text('notes')}}</th>
                    <th>{{$lang->text('created_by')}}</th>
                    <th>{{$lang->text('control')}}</th>
                </tr>
            </thead>
            <tbody>
                @isset($receipts)
                    @foreach($receipts as $index => $receipt)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$receipt -> type ->name}}</td>
                            <td>{{$receipt -> account -> name}}</td>
                            <td>{{$receipt -> balance}}</td>
                            <td>{{$receipt -> cashBox -> name}}</td>
                            <td>{{$receipt -> notes}}</td>
                            <td>{{$receipt -> user -> name}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{route('receipt.edit',$receipt -> id)}}"
                                       class="btn box-shadow-3 ">
                                        <i class="fa fa-edit" style="color:#0048ff"></i>
                                    </a>
                                    <a href="{{route('receipt.show',$receipt -> id)}}"
                                       class="btn box-shadow-3 ">
                                        <i class="fa-solid fa-file-invoice" title="show" style="color:#67b01e"></i>
                                    </a>
                                    <form method="POST" action="{{ route('receipt.destroy', $receipt -> id) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn">
                                            <i class="fa fa-trash" style="color: red"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
        <div class="d-flex justify-content-center" id="paginate">
            {!! $receipts->links() !!}
        </div>
    </div>

@endsection


