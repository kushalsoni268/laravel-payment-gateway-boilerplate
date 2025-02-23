<?php 
use Request as Input;
use App\Helpers\Helper;
?>
@extends('layouts.master')
@section('title','Product Details')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-user.css') }}">
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
                            <h2 class="content-header-title float-left mb-0">Product Details</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a>
                                    </li>
                                    <li class="breadcrumb-item active">Product Details
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <div class="dropdown">
                            <a href="{{route('products.index')}}"> <button type="button" class="btn btn-primary"><i data-feather="arrow-left"></i> Back</button></a>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="app-user-view">
                    @include('errormessage')
                    <!-- User Card & Plan Starts -->
                    <div class="row">
                        <!-- User Card starts-->
                        <div class="col-xl-12 col-lg-8 col-md-7">
                            <div class="card user-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                            <div class="user-info-wrapper">
                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <i data-feather="aperture" class="mr-1"></i>
                                                        <span class="card-text user-info-title font-weight-bold mb-0">Name</span>
                                                    </div>
                                                    <p class="card-text mb-0">{{$data->name}}</p>
                                                </div>
                                                <div class="d-flex flex-wrap my-50">
                                                    <div class="user-info-title">
                                                        <i data-feather="dollar-sign" class="mr-1"></i>
                                                        <span class="card-text user-info-title font-weight-bold mb-0">Amount</span>
                                                    </div>
                                                    <p class="card-text mb-0">{{$data->amount}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /User Card Ends-->

               
                    </div>
                    <!-- User Card & Plan Ends -->
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->
@section('script')
<script src="{{ asset('app-assets/js/scripts/pages/app-user-view.js') }}"></script>
@endsection
@endsection
