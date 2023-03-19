
@extends('layouts.app')

@section('content')
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('products')}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body">
        <div class="row">
            <div class="col-md-6">
                {{$lang->text('products')}}
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a href="{{route('product.create')}}">
                    <span class="btn btn-primary">
                        <span class="fas fa-plus"></span>
                        {{$lang->text('add_product')}}
                    </span>
                </a>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>

        <table class="table text-center" id="DataTable">
            <thead>
                <tr>
                    <th>{{$lang->text('num')}}</th>
                    <th>{{$lang->text('barcodes')}}</th>
                    <th>{{$lang->text('product_name')}}</th>
                    <th>{{$lang->text('unit')}}</th>
                    <th>{{$lang->text('sale_price')}}</th>
                    <th>{{$lang->text('order_limit')}}</th>
                    <th>{{$lang->text('control')}}</th>
                </tr>
            </thead>
            <tbody>
                @isset($products)
                    @foreach($products as $index => $product)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$product -> barcode[0]->barcode}}</td>
                            <td>{{$product -> name}}</td>
                            <td>{{$product -> unit ->name}}</td>
                            <td>{{$product -> sale_price}}</td>
                            <td>{{$product -> order_limit}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{route('product.edit',$product -> id)}}"
                                       class="btn box-shadow-3 ">
                                        <i class="fa fa-edit" style="color:#0048ff"></i>
                                    </a>
                                    <form method="POST" action="{{ route('product.destroy', $product -> id) }}">
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
            {!! $products->links() !!}
        </div>
    </div>

@endsection


