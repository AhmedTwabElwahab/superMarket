@extends('layouts.app')

@section('content')

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">الاقسام</li>
            </ol>
        </nav>
    </div>
    <div class="row container-body">


        <div class="col-12">
            <div class="col-12 p-0 row">
                <div class="col-12 col-lg-4 py-3 px-3">
                    الأقسام
                </div>
                <div class="col"></div>
                <div class="col-12 col-lg-4 p-2 d-flex justify-content-end">
                    <a href="#">
                        <span class="btn btn-primary"><span class="fas fa-plus"></span> إضافة جديد</span>
                    </a>
                </div>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>
        <div>
            <div class="w-50">
                <div class="col-12 col-lg-6 p-2">
                    <div class="col-12">
                        الرابط
                    </div>
                    <div class="col-12 pt-3">
<input type="text" name="slug" required  maxlength="190" class="form-control" value="{{old('slug')}}" >
                    </div>
                </div>
                <div class="col-12 col-lg-6 p-2">
                    <div class="col-12">
                        العنوان
                    </div>
                    <div class="col-12 pt-3">
<input type="text" name="title" required   maxlength="190" class="form-control" value="{{old('title')}}" >
                    </div>
                </div>
                <div class="col-12 p-2">
                    <div class="col-12">
                        الشعار
                    </div>
                    <div class="col-12 pt-3">
                        <input type="file" name="image"    class="form-control" accept="image/*">
                    </div>
                    <div class="col-12 pt-3">
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
