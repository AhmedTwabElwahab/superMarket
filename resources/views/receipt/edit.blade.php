
@extends('layouts.app')

@section('content')

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('receipt.index')}}">{{$lang->text('receipts')}}</a></li>

                @if($receipt->type_id == RECEIPT_OUT)

                    <li class="breadcrumb-item active" aria-current="page">{{$lang->text('edit_receipt_out')}}</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{$lang->text('edit_receipt_in')}}</li>

                @endif
            </ol>
        </nav>
    </div>
    
    <div class="row container-body p-3">
        <div class="col-12">
            <div class="col-12 p-0 row">
                <div class="col-12 col-lg-4 py-3 px-3">
                @if($receipt->type_id == RECEIPT_OUT)
                    {{$lang->text('edit_receipt_out')}}
                @else
                    {{$lang->text('edit_receipt_in')}}
                @endif
                </div>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>
        <form class="form" id ='updateReceipt' action="{{route('receipt.update',$receipt->id)}}"
                method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
            <div class="row mt-2">
                <div class="form-group col-md-6">
                    <label for="account_type_id">
                        {{$lang->text('account_type')}}
                    </label>
                    <select id="account_type_id" class="form-control js-select">
                        <option value="">--</option>
                        @if($receipt->type_id == RECEIPT_IN)
                            <option value="{{CLIENTS_ACCOUNT}}" >{{$lang->text('clients')}}</option>
                        @else($receipt->type_id == RECEIPT_OUT)
                            <option value="{{SUPPLIERS_ACCOUNT}}" >{{$lang->text('suppliers')}}</option>
                            <option value="{{SUB_MISCELLANEOUS_EXPENSES}}" >{{$lang->text('expensess')}}</option>
                        @endif
                        <option value="{{ALL_ACCOUNT}}" >{{$lang->text('other_account')}}</option>
                    </select>
                </div>{{--end of form-group--}}
            </div>


            <div class="row mt-2">
                <div class="form-group col-md-6">
                    <label for="account_id">
                        {{$lang->text('account')}}
                    </label>
                    <select id="account_id" name="account_id" class="form-control js-select">
                        <option value="{{$receipt->account->id}}"  selected >{{$receipt->account->name}}</option>
                    </select>
                </div>{{--end of form-group--}}
            </div>

            <div class="row mt-2">
                <div class="form-group col-md-6">
                    <label for="cash_box_id">
                        {{$lang->text('cash_box')}}
                    </label>
                    <select id="cash_box_id" name="cash_box_id" class="form-control js-select">
                        @if(!empty($cash_box))
                            <option value="">--</option>
                            @foreach($cash_box as $box)
                                <option value="{{$box->id}}"  @if($box->id == $receipt->cash_box_id ) selected @endif>{{$box->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>{{--end of form-group--}}

                <div class="form-group col-md-4">
                    <label for  = "balance_input">
                        {{$lang->text('balance')}}
                    </label>
                    <input type = "number" class="form-control" step='0.0001'
                            name = "balance"
                            value = '{{ $receipt->balance}}'
                            id   = "balance_input">
                    @error("balance")
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}
            </div>

            <div class="row mt-2">
                <div class="form-group col-md-12">
                    <label for  = "notes_input">
                        {{$lang->text('notes')}}
                    </label>
                    <input type = "text" class="form-control" 
                            name = "notes"
                            value = '{{ $receipt->notes}}'
                            id   = "notes_input">
                    @error("notes")
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}
            </div>
        </form>{{--end of form--}}
    </div>
    
    <div class="row mt-4">
        <div class="form-group col-md-2">
            <button type="submit" form ="updateReceipt" class="btn btn-primary">
                {{$lang->text('Receipt_save')}}
            </button>
        </div>
    </div>{{--end of row--}}

@endsection