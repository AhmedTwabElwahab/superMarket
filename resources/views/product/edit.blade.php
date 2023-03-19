<?php

use App\Models\Product;
/**
 * @var Product $product
 */
?>
@extends('layouts.app')

@section('content')

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('product.index')}}">{{$lang->text('products')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('edit_product')}}</li>
            </ol>
        </nav>
    </div>
    <form class="form" id ='CreateProduct' action="{{route('product.update',$product->id)}}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="row container-body m-0 p-3">
                    <div class="col-12">
                        <div class="col-12 p-0 row">
                            <div class="col-12 col-lg-4 py-3 px-3">
                                {{$lang->text('edit_product')}}
                            </div>
                        </div>
                        <div class="col-12 divider" style="min-height: 2px;"></div>
                    </div>
                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <label for="category_id_input">{{$lang->text('category')}}</label>
                                <select id="category_id_input" class="form-control" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" @if($category->id == $product->category_id ) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error("category_id")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>{{--end of form-group--}}
                            <div class="form-group col-md-4">
                                <label for  = "barcode_input">
                                    {{$lang->text('barcode')}}
                                </label>
                                <input type = "text" class="form-control"
                                       id   = "barcode_input">
                                @error("barcode")
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>{{--end of form-group--}}
                            <div class="form-group col-md-2">
                                <label for  = "add_barcode_input">
                                    {{$lang->text('add_barcode')}}
                                </label>
                                <a  class="btn btn-primary form-control" id="add_barcode">
                                    <i class="fa-solid fa-barcode"></i>
                                </a>
                            </div>{{--end of form-group--}}
                        </div>

                        <div class="row mt-3">
                            <div class="form-group col-md-7">
                                <label for  = "product_name_input">
                                    {{$lang->text('product_name')}}
                                </label>
                                <input type = "text" class="form-control"
                                       name = "name"
                                       value= "{{$product->name}}"
                                       id   = "product_name_input">
                                @error("name")
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>{{--end of form-group--}}
                            <div class="form-group col-md-5">
                                <label for="unit_id_input">{{$lang->text('unit')}}</label>
                                <select id="unit_id_input" class="form-control" name="unit_id" required>
                                    @foreach($units as $unit)
                                        <option value="{{$unit->id}}" @if($unit->id == $product->unit_id ) selected @endif>{{$unit->name}}</option>
                                    @endforeach
                                </select>
                                @error("unit_id")
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>{{--end of form-group--}}
                        </div>{{--end of row--}}

                        <div class="row mt-3">
                            <div class="form-group col-md-3">
                                <label for  = "purchase_price_input">
                                    {{$lang->text('purchase_price')}}
                                </label>
                                <input type = "number" class="form-control"
                                       name = "purchase_price"
                                       step = "0.01"
                                       min  = "0"
                                       value= "{{$product->purchase_price}}"
                                       id   = "purchase_price_input">
                                @error("purchase_price")
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>{{--end of form-group--}}
                            <div class="form-group col-md-3">
                                <label for  = "sale_price_input">
                                    {{$lang->text('sale_price')}}
                                </label>
                                <input type = "number" class="form-control"
                                       name = "sale_price"
                                       step = "0.01"
                                       min  = "0"
                                       value= "{{$product->sale_price}}"
                                       id   = "sale_price_input">
                                @error("sale_price")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>{{--end of form-group--}}
                            <div class="form-group col-md-3">
                                <label for  = "wholesale_price_input">
                                    {{$lang->text('wholesale_price')}}
                                </label>
                                <input type = "number" class="form-control"
                                       name = "wholesale_price"
                                       step = "0.01"
                                       min  = "0"
                                       value= "{{$product->wholesale_price}}"
                                       id   = "wholesale_price_input">
                                @error("wholesale_price")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>{{--end of form-group--}}
                            <div class="form-group col-md-3">
                                <label for  = "half_price_input">
                                    {{$lang->text('half_price')}}
                                </label>
                                <input type = "number" class="form-control"
                                       name = "half_price"
                                       step = "0.01"
                                       min  = "0"
                                       value= "{{$product->half_price}}"
                                       id   = "half_price_input">
                                @error("half_price")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>{{--end of form-group--}}
                        </div>{{--end of row--}}

                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <label for  = "expiry_date_input">
                                    {{$lang->text('expiry_date')}}
                                </label>
                                <input type = "date" class="form-control"
                                       name = "expiry_date"
                                       value= "{{$product->expiry_date}}"
                                       id   = "expiry_date_input">
                                @error("expiry_date")
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>{{--end of form-group--}}
                            <div class="form-group col-md-6">
                                <label for  = "order_limit_input">
                                    {{$lang->text('order_limit')}}
                                </label>
                                <input type = "number" class="form-control"
                                       name = "order_limit"
                                       min  = "2"
                                       value= "{{$product->order_limit}}"
                                       id   = "order_limit_input">
                                @error("order_limit")
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>{{--end of form-group--}}
                        </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="row container-body m-0 p-3">
                    <div class="col-12">
                        <div class="col-12 p-0 row">
                            <div class="col-12  py-3 px-3">
                                {{$lang->text('barcodes')}}
                            </div>
                        </div>
                        <div class="col-12 divider" style="min-height: 2px;"></div>
                    </div>
                    <table
                        class="table display nowrap table-striped text-center" id="barcodeTable">
                        <thead>
                            <tr>
                                <th style="width: 80%">
                                    <i class="fa-solid fa-barcode"></i>
                                </th>
                                <th>
                                    <i class="fa-solid fa-gear"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @isset($product->barcode)
                            @foreach($product->barcode as $index => $code)
                                <tr>
                                    <td>{{$code->barcode}}</td>
                                    <td>
                                            <i class="fa-solid fa-ban"></i>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>{{--end of form--}}
    <div class="row mt-4">
        <div class="form-group col-md-2">
            <button type="submit" form ="CreateProduct" class="btn btn-primary">
                {{$lang->text('save')}}
            </button>
        </div>
    </div>{{--end of row--}}

@endsection
