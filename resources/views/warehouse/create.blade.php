@extends('layouts.app')

@section('content')

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('warehouse.index')}}">{{$lang->text('warehouse')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('add_warehouse')}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body p-3">
        <div class="col-12">
            <div class="col-12 p-0 row">
                <div class="col-12 col-lg-4 py-3 px-3">
                    {{$lang->text('add_warehouse')}}
                </div>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>
        <form class="form" id ='Createwarehouse' action="{{route('warehouse.store')}}"
                method="POST"
                enctype="multipart/form-data">
            @csrf

            <div class="row mt-2">
                <div class="form-group col-md-4">
                    <label for  = "warehouse_name_input">
                        {{$lang->text('warehouse_name')}}
                    </label>
                    <input type = "text" class="form-control"
                            name = "name"
                            id   = "warehouse_name_input">
                    @error("name")
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}

                <div class="form-group col-md-4">
                    <label for  = "warehouse_address_input">
                        {{$lang->text('warehouse_address')}}
                    </label>
                    <input type = "text" class="form-control"
                            name = "address"
                            id   = "warehouse_address_input">
                    @error("address")
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}
            </div>{{--end of row--}}

            
        </form>{{--end of form--}}
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-2">
            <button type="submit" form ="Createwarehouse" class="btn btn-primary">
                {{$lang->text('warehouse_save')}}
            </button>
        </div>
    </div>{{--end of row--}}

@endsection