@extends('layouts.app')

@section('content')

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{$lang->text('dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('category.index')}}">{{$lang->text('categories')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$lang->text('edit_category')}}</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body p-3">
        <div class="col-12">
            <div class="col-12 p-0 row">
                <div class="col-12 col-lg-4 py-3 px-3">
                    {{$lang->text('edit_category')}}
                </div>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>
        <form class="form" id ='editcategory' action="{{route('category.update',$category->id)}}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

            <div class="row mt-2">
                <div class="form-group col-md-4">
                    <label for  = "category_name_input">
                        {{$lang->text('name')}}
                    </label>
                    <input type = "text" class="form-control"
                            name = "name"
                            value = "{{$category->name}}"
                            id   = "category_name_input">
                    @error("name")
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>{{--end of form-group--}}
            </div>{{--end of row--}}

            
        </form>{{--end of form--}}
    </div>
    <div class="row mt-4">
        <div class="form-group col-md-2">
            <button type="submit" form ="editcategory" class="btn btn-primary">
                {{$lang->text('save')}}
            </button>
        </div>
    </div>{{--end of row--}}

@endsection