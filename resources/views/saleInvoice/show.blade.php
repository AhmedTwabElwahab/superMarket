<?php
/**
 *
 * @var SaleInvoice $saleInvoice
 */
use App\Models\SaleInvoice;
?>

@extends('layouts.app')

@section('content')

    <div class="row d-print-none">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('saleInvoice.index')}}">{{$lang->text('saleInvoice')}}</a>
                </li>
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
        <div class="invoice-wrap">
            <div class="invoice_header">
                <div class="left">
                    {{ //TODO::APP_settings}}
                    <h4>QuMarket</h4>
                    <div>ش علي بن اب طالب</div>
                    <div>قنا, قنا</div>
                </div>
                <div class="right">
                    <div>
                        <h4>فاتورة بيع</h4>
                    </div>
                </div>
            </div>
            <div class="invoice_info">
                <div class="left">
                    <div class="fw-bold">العميل:</div>
                    <div>محمد علي</div>
                    <div>01011401555</div>
                </div>
                <div class="right">
                    <div class="fw-bold">رقم فاتورة البيع# &nbsp;&nbsp; 2150</div>
                    <div class="fw-bold">التاريخ# &nbsp;&nbsp; 23/10/2023</div>
                </div>
            </div>
            <div class="invoice_body row">
                <table class="table">
                    <tbody>
                    {{ //TODO::loop product}}
                        <tr class="table-header">
                            <th>الصنف</th>
                            <th style="width: 80px">سعر الوحدة</th>
                            <th style="width: 40px">الكمية</th>
                            <th style="width: 60px">الاجمالي</th>
                        </tr>
                        <tr>
                            <td>بلح</td>
                            <td style="width: 80px">15.20</td>
                            <td style="width: 40px">5</td>
                            <td style="width: 60px">76.00</td>
                        </tr>
                        <tr>
                            <td>بلح</td>
                            <td style="width: 80px">15.20</td>
                            <td style="width: 40px">5</td>
                            <td style="width: 60px">76.00</td>
                        </tr>
                        <tr>
                            <td>بلح</td>
                            <td style="width: 80px">15.20</td>
                            <td style="width: 40px">5</td>
                            <td style="width: 60px">76.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="invoice_footer">
                <div class="space"></div>
                <div class="total_invoice">
                    <div>
                        <div class="left fw-bold">الاجمالي:</div>
                        <div class="right">15.00 ج.م</div>
                    </div>
                    <div>
                        <div class="left fw-bold">المبلغ المدفوع:</div>
                        <div class="right">-15.00 ج.م</div>
                    </div>
                    <div>
                        <div class="left fw-bold">المبلغ المستحق:</div>
                        <div class="right">0.00 ج.م</div>
                    </div>
                </div>
            </div>
        </div>
@endsection
