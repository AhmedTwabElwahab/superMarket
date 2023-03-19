<?php
/**
 *
 * @var \App\Models\SaleInvoice $saleInvoice
 */
?>


@extends('layouts.app')

@section('content')

    <div class="row d-print-none">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('saleInvoice.index')}}">{{$lang->text('saleInvoice')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('show_invoice')}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body" id="Invoice">

        <div class="row d-print-none">
            <div class="col-md-6">
                <div class="col-12 col-lg-4 py-3 px-3">
                    {{$lang->text('saleInvoice')}}
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a id="printInvoice" class="btn" onclick="printableDiv('Invoice')">
                    <i class="fa-solid fa-print px-4"></i>
                </a>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>

        <div class="row pb-2">
            <div class="col-md-4">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>{{$lang->text('client')}}</td>
                        <td>{{$saleInvoice->client->name}}</td>
                    </tr>
                    <tr>
                        <td>{{$lang->text('invoice_date')}}</td>
                        <td>{{DateFormat($saleInvoice->created_at)}}</td>
                    </tr>
                    <tr>
                        <td>{{$lang->text('payment_type')}}</td>
                        <td>{{$saleInvoice->PaymentType->name}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 company_info">

            </div>
        </div>

        <table class="table table-bordered table-sm text-center">
            <thead>
            <tr>
                <th>{{'م'}}</th>
                <th>{{__('saleInvoice/create.barcode')}}</th>
                <th>{{__('saleInvoice/create.name_product')}}</th>
                <th>{{__('saleInvoice/create.product_unit')}}</th>
                <th>{{__('saleInvoice/create.quantity')}}</th>
                <th>{{__('saleInvoice/create.sale_price')}}</th>
                <th>{{__('saleInvoice/create.total')}}</th>
            </tr>
            </thead>
            <tbody>
            @isset($saleInvoice->Details)
                @foreach($saleInvoice->Details as $index => $Detail)
                    <tr>
                        <td>{{$index}}</td>
                        <td>{{$Detail -> barcode}}</td>
                        <td>{{$Detail -> Product->name}}</td>
                        <td>{{$Detail -> Product->unit->name}}</td>
                        <td>{{floatval($Detail -> quantity)}}</td>
                        <td>{{floatval($Detail -> price)}}</td>
                        <td>{{floatval($Detail -> price * $Detail ->quantity)}}</td>
                    </tr>
                @endforeach
            @endisset
            </tbody>
        </table>
        <div class="row justify-content-between pt-2">
            <div class="col-md-4">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>{{$lang->text('total_bill_discount')}}</td>
                        <td>
                            {{$saleInvoice->discount + $saleInvoice->total_bill}}
                        </td>
                    </tr>
                    <tr>
                        <td>{{$lang->text('discount')}}</td>
                        <td>{{$saleInvoice->discount}}</td>
                    </tr>
                    <tr>
                        <td>{{$lang->text('total_bill')}}</td>
                        <td>{{$saleInvoice->total_bill}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h5><td>{{$lang->text('notes')}}</td></h5>
                <div style = "border: 1px solid #ccc;height: 93px;border-radius:4px">
                    <p class="px-2">
                        {{$saleInvoice->notes}}
                    </p>
                </div>
            </div>
        </div>
    </div>



@endsection



