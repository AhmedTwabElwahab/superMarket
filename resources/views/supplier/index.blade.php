
@extends('layouts.app')

@section('content')
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('supplier')}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body">
        <div class="row">
            <div class="col-md-6">
                {{$lang->text('supplier')}}
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a href="{{route('supplier.create')}}">
                    <span class="btn btn-primary">
                        <span class="fas fa-plus"></span>
                        {{$lang->text('add_supplier')}}
                    </span>
                </a>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>

        <table class="table text-center" id="DataTable">
            <thead>
                <tr>
                    <th>{{$lang->text('num')}}</th>
                    <th>{{$lang->text('supplier_name')}}</th>
                    <th>{{$lang->text('email')}}</th>
                    <th>{{$lang->text('phone')}}</th>
                    <th>{{$lang->text('number')}}</th>
                    <th>{{$lang->text('whatsApp')}}</th>
                    <th>{{$lang->text('address')}}</th>
                    <th>{{$lang->text('control')}}</th>
                </tr>
            </thead>
            <tbody>
                @isset($suppliers)
                    @foreach($suppliers as $index => $supplier)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$supplier -> name}}</td>
                            <td>{{$supplier -> email}}</td>
                            <td>{{$supplier -> phone}}</td>
                            <td>{{$supplier -> number}}</td>
                            <td>{{$supplier -> whatsApp}}</td>
                            <td>{{$supplier -> address}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{route('supplier.edit',$supplier -> id)}}"
                                       class="btn box-shadow-3 ">
                                        <i class="fa fa-edit" style="color:#0048ff"></i>
                                    </a>
                                    <a href="{{route('supplier.show',$supplier -> id)}}"
                                       class="btn box-shadow-3 ">
                                        <i class="fa-solid fa-file-invoice" title="show" style="color:#67b01e"></i>
                                    </a>
                                    <form method="POST" action="{{ route('supplier.destroy', $supplier -> id) }}">
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
            {!! $suppliers->links() !!}
        </div>
    </div>

@endsection


