
@extends('layouts.app')

@section('content')
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('all_saleInvoice')}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body">
        <div class="row">
            <div class="col-md-6">
                {{$lang->text('all_saleInvoice')}}
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a href="{{route('purchaseInvoice.create')}}">
                    <span class="btn btn-primary">
                        <span class="fas fa-plus"></span>
                        {{$lang->text('add_saleInvoice')}}
                    </span>
                </a>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>

        <table class="table text-center" id="DataTable">
            <thead>
                <tr>
                    <th>{{$lang->text('num')}}</th>
                    <th>{{$lang->text('supplier')}}</th>
                    <th>{{$lang->text('payment_type')}}</th>
                    <th>{{$lang->text('discount')}}</th>
                    <th>{{$lang->text('notes')}}</th>
                    <th>{{$lang->text('total_bill')}}</th>
                    <th>{{$lang->text('control')}}</th>
                </tr>
            </thead>
            <tbody>
                @isset($invoices)
                    @foreach($invoices as $index => $purchaseInvoice)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$purchaseInvoice ->supplier-> name}}</td>
                            <td>
                                @if($purchaseInvoice -> PaymentType->id == PAYMENT_CASH)
                                    <span class="badge bg-success">
                                        {{$purchaseInvoice -> PaymentType -> name}}
                                    </span>
                                @elseif($purchaseInvoice -> PaymentType->id == PAYMENT_CREDIT)
                                    <span class="badge bg-danger">
                                        {{$purchaseInvoice -> PaymentType -> name}}
                                    </span>
                                @else
                                    <span class="badge bg-info text-dark">
                                        {{$purchaseInvoice -> PaymentType -> name}}
                                    </span>
                                @endif

                            </td>
                            <td>{{$purchaseInvoice -> discount}}</td>
                            <td>{{$purchaseInvoice -> notes === null ? '---' : $purchaseInvoice -> notes}}</td>
                            <td>{{$purchaseInvoice -> total_bill}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{route('purchaseInvoice.edit',$purchaseInvoice -> id)}}"
                                       class="btn box-shadow-3 ">
                                        <i class="fa fa-edit" style="color:#0048ff"></i>
                                    </a>
                                    <a href="{{route('purchaseInvoice.show',$purchaseInvoice -> id)}}"
                                       class="btn box-shadow-3 ">
                                        <i class="fa-solid fa-file-invoice" style="color:#67b01e"></i>
                                    </a>
                                    <form method="POST" action="{{ route('purchaseInvoice.destroy', $purchaseInvoice -> id) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn">
                                            <i class="fa fa-trash" style="color: red"></i>
                                        </button>
                                    </form>

                                    <a href="{{route('purchaseInvoice.show',$purchaseInvoice -> id)}}"
                                       class="btn box-shadow-3 " target="print_frame">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    <iframe name="print_frame" width=0 height=0></iframe>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
        <div class="d-flex justify-content-center" id="paginate">
            {!! $invoices->links() !!}
        </div>
    </div>

@endsection


