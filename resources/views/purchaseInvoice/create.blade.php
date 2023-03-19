@extends('layouts.app')

@section('content')

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('saleInvoice.index')}}">{{$lang->text('purchaseInvoices')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('create_Invoice')}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body">

        <div class="col-12">
            <div class="col-12 p-0 row">
                <div class="col-12 col-lg-4 py-3 px-3">
                    {{$lang->text('create_Invoice')}}
                </div>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>

        <div class="col-md-12">
            <div class="row ">
                <form class="form" action="{{route('purchaseInvoice.store')}}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row mt-3" id="app">
                        <div class="form-group col-md-2">
                            <label>{{$lang->text('supplier_balance')}}</label>
                            <div class="p-2">
                                <span id="Supplier_balacnce" class="">0.00</span>
                            </div>
                        </div>{{--end of form-group--}}
                        <div class="form-group col-md-4">
                            <label for="supplier_id_input">{{$lang->text('supplier')}}</label>
                            <select id="supplier_id_input" class="form-control"
                                    name="supplier_id" required>
                                @if(!empty($suppliers))
                                    @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}"
                                                data-accountD="{{$supplier->account->debit_balance}}"
                                                data-accountC="{{$supplier->account->credit_balance}}"
                                        >{{$supplier->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>{{--end of form-group--}}
                        <div class="form-group col-md-2">
                            <label for="num_invoice_input">{{$lang->text('num_invoice')}}</label>
                            <input type = "text" class="form-control" name="num_invoice" id = "num_invoice_input">
                        </div>{{--end of form-group--}}
                        <div class="form-group col-md-2">
                            <label for="payment_type_id_input">{{$lang->text('payment_type')}}</label>
                            <select id="payment_type_id_input" class="form-control" name="payment_type_id" required>
                                @foreach($payments as $payment)
                                    <option value="{{$payment->id}}">{{$payment->name}}</option>
                                @endforeach
                            </select>
                            @error("payment_type_id")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>{{--end of form-group--}}
                        <div class="form-group col-md-2">
                            <label for="warehouse_input">{{$lang->text('warehouse')}}</label>
                            <select id="warehouse_input" class="form-control" name="warehouse" required>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                            @error("warehouse")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>{{--end of form-group--}}
                    </div>

                    <div class="row mt-2">
                        <div class="form-group col-md-3">
                            <label for="barcode">
                                {{$lang->text('barcode')}}
                            </label>
                            <input type = "text" class="form-control"
                                   id   = "barcode">
                        </div>{{--end of form-group--}}
                        <div class="form-group col-md-4">
                            <label for="name_product">
                                {{$lang->text('name_product')}}
                            </label>
                            <select id="product_id" class="form-control">
                                @if(!empty($stocks))
                                    @foreach($stocks as $stock)
                                        <option value="{{$stock->product->id}}">{{$stock->product->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>{{--end of form-group--}}
                        <div class="form-group col-md-1">
                            <label for="product_unit_id">
                                {{$lang->text('product_unit')}}
                            </label>
                            <input type = "text" class="form-control" id   = "product_unit_id" readonly>
                        </div>{{--end of form-group--}}
                        <div class="form-group col-md-1">
                            <label for="quantity">
                                {{$lang->text('quantity')}}
                            </label>
                            <input type = "number" min="0" step="0.01" class="form-control"
                                   id   = "quantity">
                        </div>{{--end of form-group--}}
                        <div class="form-group col-md-1">
                            <label for="product_price">
                                {{$lang->text('product_price')}}
                            </label>
                            <input type = "number" min="0" step="0.01" class="form-control"
                                   id   = "product_price">
                        </div>{{--end of form-group--}}
                        <div class="form-group col-md-2">
                            <label>
                                {{$lang->text('add')}}
                            </label>
                            <a  class="btn btn-primary form-control btn-add" >
                                {{$lang->text('add')}}
                            </a>
                        </div>{{--end of form-group--}}
                        <input type="hidden" name="sale_price" id="sale_price">
                    </div>{{--end of row--}}

                    <div class="row mt-2" style="overflow: scroll;">
                        <table
                            class="table display nowrap table-striped table-bordered scroll-horizontal" id="saleInvoices">
                            <thead>
                            <tr>
                                <th>{{$lang->text('barcode')}}</th>
                                <th>{{$lang->text('name_product')}}</th>
                                <th>{{$lang->text('sale_price')}}</th>
                                <th>{{$lang->text('product_unit')}}</th>
                                <th>{{$lang->text('quantity')}}</th>
                                <th>{{$lang->text('product_price')}}</th>
                                <th>{{$lang->text('total')}}</th>
                                <th>{{$lang->text('control')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>{{--end of row--}}

                    <div class="row mt-3">
                        <div class="form-group col-md-8">
                            <label for="notes_input">{{$lang->text('notes')}}</label>
                            <textarea id="notes_input" aria-label="With textarea"
                                      class="form-control"
                                      name ="notes"> </textarea>
                            @error("description")
                                <span class="text-danger"> {{$message}}</span>
                            @enderror
                        </div>{{--end of form-group--}}
                        <div class="form-group col-md-4 mt-3">
                            <table class="table">
                                <tr>
                                    <td>{{$lang->text('amount_required')}}</td>
                                    <td>
                                        <input id="amount_required" type="number" min="0" step="0.1" onchange="TotalBill()" name="total_bill" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td >{{$lang->text('discount')}}</td>
                                    <td>
                                        <input id="discount" type="number" min="0" step="0.1" onchange="TotalBill()" name="discount" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{$lang->text('amount_paid')}}</td>
                                    <td>
                                        <input id="amount_paid" type="number" min="0" step="0.1" onchange="TotalBill()" name="amount_paid">
                                    </td>
                                    @error("amount_paid")
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </tr>
                                <tr>
                                    <td>{{$lang->text('amount_')}}</td>
                                    <td>
                                        <input id="amount_" type="text"  value="0" readonly>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>{{--end of row--}}

                    <div class="row mt-3">
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-primary">
                                {{$lang->text('saleInvoice_save')}}
                            </button>
                        </div>
                    </div>{{--end of row--}}
                </form>{{--end of form--}}
            </div>
        </div>
    </div>

@endsection
