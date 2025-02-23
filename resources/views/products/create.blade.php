@extends('layouts.master')
@section('title','Create Product')
@section('css')
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Products</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a>
                                    </li>
                                    <li class="breadcrumb-item active">Create Product
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- users edit start -->
                <section class="app-user-edit">
                    @include('errormessage')
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Account Tab starts -->
                                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                    <!-- users edit account form start -->
                                    {!! Form::open(['route' => 'products.store','name'=>'createform', 'id'=>"createform",'enctype'=>'multipart/form-data']) !!} 
                                    @include('products.common')
                                    {!! Form::close() !!}
                                    <!-- users edit account form ends -->
                                </div>
                                <!-- Account Tab ends -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->
            </div>
        </div>
    </div>
<!-- END: Content-->
@endsection
@section('script')
<script type="text/javascript">
    $("#createform").validate({
        rules: {
            name: {
                required: true,
            },
            amount: {
                required: true,
            },
        },
        submitHandler: function (form) {
            if ($("#createform").validate().checkForm()) {
                $(".submitbutton").addClass("disabled");
                form.submit();
            }
        },
    });
</script>
@endsection
