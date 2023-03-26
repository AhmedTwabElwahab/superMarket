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
        <div class="invoice-wrap">
            <div class="invoice-inner">
                <table>
                    <tbody>
                    <tr>
                        <td class="text-left" valign="top">
                            <p>
                                <span class="bussines-name">ququMrket</span><br>
                                ش علي بن اب طالب <br>
                                قنا, قنا <br>
                            </p>
                        </td>
                        <td class="text-right" valign="top">


                            <h1>فاتورة شراء</h1>
                        </td>

                    </tr>
                    </tbody>
                </table>
                <div class="invoice-address">
                    <table>
                        <tbody>
                        <tr>
                            <td id="second_left" width="50%" class="text-left" valign="top">
                                <p>
                                    <strong>العميل:</strong><br/>
                                    علي محمح<br/>
                                    01011401564<br/>
                                </p>
                            </td>

                            <td id="second_right" class="text-right">

                                <table id="invoice_fields" border="0" cellspacing="0" cellpadding="0" class="text-right float-right">
                                    <tbody>
                                    <tr>
                                        <td class="text-right"><strong>رقم فاتورة البيع#</strong></td>
                                        <td style="padding-left:20px;" class="text-left">
                                            1
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>التاريخ</strong></td>
                                        <td style="padding-left:20px;" class="text-left">23/01/2023</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <table cellspacing="0" cellpadding="2" border="0" width="100%" id="listing_table"
                       class="invoice-listing-table total-table" style="">
                    <tbody>
                    <tr>

                        <th width="" bgcolor="#E5E5E5" style="border-left:1px solid #555;">البند</th>
                        <th width="80" bgcolor="#E5E5E5">سعر الوحدة</th>
                        <th width="40" bgcolor="#E5E5E5">الكمية</th>
                        <th width="60" bgcolor="#E5E5E5">المجموع</th>
                    </tr>
                    <tr>
                        <td width="">بلح</td>
                        <td width="80">15.20</td>
                        <td width="40">5</td>
                        <td width="60">76.00</td>
                    </tr>


                    <tr class="total-row">
                        <td style="border:none" bgcolor="#FFF" colspan="1"></td>
                        <td style="border-left:none;border-right:none;" colspan="2"><strong>الإجمالي:</strong></td>
                        <td style="border-left:none;border-right:none;" class="text-left">76.00&nbsp;ج.م</td>
                    </tr>

                    <tr>
                        <td style="border:none" bgcolor="#FFF" colspan="1"></td>
                        <td style="border-left:none;border-right:none;" colspan="2"><strong>مدفوعة:</strong></td>
                        <td style="border-left:none;border-right:none;" class="text-left"><span dir="ltr">-76.00</span>&nbsp;ج.م
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none" bgcolor="#FFF" colspan="1"></td>
                        <td style="border-left:none;border-right:none;" colspan="2"><strong>المبلغ المستحق:</strong></td>
                        <td style="border-left:none;border-right:none;" class="text-left">0.00&nbsp;ج.م</td>
                    </tr>

                    </tbody>
                </table>

                <br>
                <br>
                <div class="notes-block">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <br>
                <br>
            </div>
        </div>

    </div>



@endsection



