@extends('layouts.master')
@section('title','Stripe Refund')
@section('css')
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ecommerce-application">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Transaction Refund</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('stripe-transaction') }}">Transactions</a>
                                </li>
                                <li class="breadcrumb-item active">Stripe Refund
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="bs-stepper checkout-tab-steps">
                <!-- Wizard starts -->
                <div class="bs-stepper-header">
                    <div class="step" data-target="#step-refund">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">
                                <i data-feather="shopping-cart" class="font-medium-3"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Payment</span>
                                <span class="bs-stepper-subtitle">Refund</span>
                            </span>
                        </button>
                    </div>
                </div>
                <!-- Wizard ends -->
                <div class="bs-stepper-content">                        
                    <!-- Checkout Payment Starts -->
                    <div id="step-refund" class="content">
                        <div class="row match-height mt-2">
                            <!-- Stripe Card -->
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header flex-column align-items-start">
                                        <h4 class="card-title">Transaction</h4>
                                        <p class="card-text text-muted mt-25">{{ $data->transaction_id }}</p>
                                    </div>
                                    <div class="card-body">
                                        {!! Form::open(['route' => 'post.stripe.refund','name'=>'refundform', 'id'=>"refundform",'enctype'=>'multipart/form-data']) !!} 
                                        {!! Form::hidden('total', $data->amount, array('id' => 'total')) !!}
                                        {!! Form::hidden('refund_amount', '', array('id' => 'refund_amount')) !!}
                                        {!! Form::hidden('id', $data->id, array('id' => 'id')) !!}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group mb-2">
                                                    <label for="checkout-name">Charges (%):</label>
                                                    {!! Form::text('charge',Input::old('charge'), ['class' => 'form-control','id'=>"charge",'placeholder'=>'Enter Charges']) !!} 
                                                </div>
                                            </div>                                       
                                            <div class="col-12 d-flex flex-sm-row flex-column">
                                                <button type="submit" class="btn btn-primary btn-next delivery-address waves-effect waves-float waves-light mr-1 submitbutton">Refund</button>
                                                <a href="{{ url()->previous() }}"><button type="button" class="btn btn-outline-secondary">Cancel</button></a>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                            <!--/ Stripe Card -->

                            <!-- Amount Payable -->
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="amount-payable checkout-options">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Transaction Details</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled price-details">
                                                <li class="price-detail">
                                                    <div class="details-title">Total Paid Amount</div>
                                                    <div class="detail-amt">
                                                        <strong>${{ $data->amount }}</strong>
                                                    </div>
                                                </li>
                                                <li class="price-detail">
                                                    <div class="details-title">Charges (%)</div>
                                                    <div class="detail-amt" id="charge-div">
                                                        <strong>0.00</strong>
                                                    </div>
                                                </li>
                                            </ul>
                                            <hr>
                                            <ul class="list-unstyled price-details">
                                                <li class="price-detail">
                                                    <div class="details-title">Refund Amount</div>
                                                    <div class="detail-amt font-weight-bolder" id="refund-amount-div">${{ $data->amount }}</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Amount Payable -->
                        </div>                       
                    </div>
                    <!-- Checkout Payment Ends -->
                    <!-- </div> -->
                </div>
            </div>
        </div>   
    </div>
</div>
<!-- END: Content-->
@include('confirmalert')
@endsection
@section('script')
<script>
$(document).ready(function () {
    $("#charge").on("keypress", function (event) {
      if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
      }
    });

    $("#charge").on("keyup", function () {
        var charge = this.value;
        var total = $("#total").val();
        if(charge != ''){
            var refund = total - (total*charge)/100;
            var charge_view = "<strong>" + parseFloat(charge).toFixed(2) + "</strong>";
            var refund_view = "<strong>$" + parseFloat(refund).toFixed(2) + "</strong>";
            $("#charge-div").html(charge_view);
            $("#refund-amount-div").html(refund_view);
            $('#refund_amount').val(refund);
        }else{
            var refund = total;
            var charge_view = "<strong>0.00</strong>";
            var refund_view = "<strong>$" + parseFloat(refund).toFixed(2) + "</strong>";
            $("#charge-div").html(charge_view);
            $("#refund-amount-div").html(refund_view);
            $('#refund_amount').val(refund);
        }
    });

    $("#refundform").validate({
        rules: {
            charge: {
                required: true,
                digits: true
            },
        },
        submitHandler: function (form) {
            if ($("#refundform").validate().checkForm()) {
                $(".submitbutton").addClass("disabled");
                form.submit();
            }
        },
    });
});
</script>
@endsection
