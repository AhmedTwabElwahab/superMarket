
@extends('layouts.app')

@section('content')
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('account.index')}}">{{$lang->text('accounts')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('inf_account',['name' => $account->name])}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body">
        <div class="row">
            <div class="col-md-6">
                {{$lang->text('inf_account',['name' => $account->name])}}
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                @if($account->debit_balance != 0)
                    <span class="badge_d">
                        {{$lang->text('Debit_balance',['balance' => number_format($account->debit_balance,2.00)])}}
                    </span>
                @else
                    <span  class="badge_c">
                        {{$lang->text('credit_balance',['balance' => number_format($account->credit_balance,2.00)])}}
                    </span>
                @endif

            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>

        <table class="table text-center" id="DataTable">
            <thead>
                <tr>
                    <th>{{$lang->text('num')}}</th>
                    <th>{{$lang->text('date')}}</th>
                    <th>{{$lang->text('Debit')}}</th>
                    <th>{{$lang->text('credit')}}</th>
                    <th>{{$lang->text('dec')}}</th>
                    <th>{{$lang->text('create_by')}}</th>
                    <th>{{$lang->text('des')}}</th>
                </tr>
            </thead>
            <tbody>
                @isset($trans)
                    @foreach($trans as $index => $transaction)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{DateFormat($transaction->journal->created_at)}}</td>
                            {{--  check if this transacion type DEBIT || CREDIT     --}}
                            @if($transaction instanceof App\Models\JournalEntryDebit)
                                <td>{{$transaction->balance}}</td>
                                <td>{{"---"}}</td>
                            @else
                                <td>{{"---"}}</td>
                                <td>{{$transaction->balance}}</td>
                            @endif
                            @if($transaction->journal->doc_type_id == SALES_INVOICE)
                                <td>
                                    <a href="{{route('saleInvoice.edit',$transaction->journal->doc_id)}}"><i class="fa-regular fa-file-lines"></i></a>
                                </td>
                            @elseif($transaction->journal->doc_type_id == PURCHASE_INVOICE)
                                <td>
                                    <a href="{{route('purchaseInvoice.edit',$transaction->journal->doc_id)}}"><i class="fa-regular fa-file-lines"></i></a>
                                </td>
                            @elseif($transaction->journal->doc_type_id == RECEIPT_IN ||$transaction->journal->doc_type_id == RECEIPT_OUT)
                                <td>
                                    <a href="{{route('receipt.edit',$transaction->journal->doc_id)}}"><i class="fa-regular fa-file-lines"></i></a>
                                </td>
                            @elseif($transaction->journal->doc_type_id == SALES_RETURN)
                                <td>
                                    <a href="{{route('saleReturn.edit',$transaction->journal->doc_id)}}"><i class="fa-regular fa-file-lines"></i></a>
                                </td>
                            @elseif($transaction->journal->doc_type_id == PURCHASE_RETURN)
                                <td>
                                    <a href="{{route('purchaseReturn.edit',$transaction->journal->doc_id)}}"><i class="fa-regular fa-file-lines"></i></a>
                                </td>
                            @else
                                <td>
                                    <a href="{{route('openBalance.edit',$transaction->journal->doc_id)}}"><i class="fa-regular fa-file-lines"></i></a>
                                </td>
                            @endif
                            <td>{{$transaction->journal->user->name}}</td>
                            <td>{{$transaction->journal->dec}}</td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>

@endsection


