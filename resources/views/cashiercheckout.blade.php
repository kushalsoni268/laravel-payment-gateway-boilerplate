@extends('layouts.master')
@section('title','Checkout')
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
                        <h2 class="content-header-title float-left mb-0">Checkout</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Checkout
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="bs-stepper checkout-tab-steps">
                @include('errormessage')
                <!-- Wizard starts -->
                <div class="bs-stepper-header">
                    <div class="step" data-target="#step-cart">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">
                                <i data-feather="shopping-cart" class="font-medium-3"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Cart</span>
                                <span class="bs-stepper-subtitle">Your Cart Items</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i data-feather="chevron-right" class="font-medium-2"></i>
                    </div>
                    <div class="step" data-target="#step-payment">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">
                                <i data-feather="credit-card" class="font-medium-3"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Payment</span>
                                <span class="bs-stepper-subtitle">Select Payment Method</span>
                            </span>
                        </button>
                    </div>
                </div>
                <!-- Wizard ends -->

                <div class="bs-stepper-content">
                    <!-- Checkout Place order starts -->
                    <div id="step-cart" class="content">
                        <div id="place-order" class="list-view product-checkout">
                            <!-- Checkout Place Order Left starts -->
                            <div class="checkout-items">
                                @foreach($products as $product)
                                <div class="card ecommerce-card">
                                    <div class="item-img">
                                        <a href="app-ecommerce-details.html">
                                            <img src="../../../app-assets/images/pages/eCommerce/1.png" alt="img-placeholder" />
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="item-name">
                                            <h6 class="mb-0"><a href="app-ecommerce-details.html" class="text-body">{{ $product->name }}</a></h6>
                                            <div class="item-rating">
                                                <ul class="unstyled-list list-inline">
                                                    <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                                    <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                                    <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                                    <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                                    <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <span class="text-success mb-1">In Stock</span>
                                        <span class="delivery-date text-muted">Delivery by, Wed Apr 25</span>
                                        <span class="text-success">17% off 4 offers Available</span>
                                    </div>
                                    <div class="item-options text-center">
                                        <div class="item-wrapper">
                                            <div class="item-cost">
                                                <h4 class="item-price">${{ $product->amount }}</h4>
                                                <p class="card-text shipping">
                                                    <span class="badge badge-pill badge-light-success">Free Shipping</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!-- Checkout Place Order Left ends -->

                            <!-- Checkout Place Order Right starts -->
                            <div class="checkout-options">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="price-details">
                                            <h6 class="price-title">Price Details</h6>
                                            <ul class="list-unstyled">
                                                <li class="price-detail">
                                                    <div class="detail-title">Total</div>
                                                    <div class="detail-amt">${{ $total }}</div>
                                                </li>
                                                <li class="price-detail">
                                                    <div class="detail-title">Delivery Charges</div>
                                                    <div class="detail-amt discount-amt text-success">Free</div>
                                                </li>
                                            </ul>
                                            <hr />
                                            <ul class="list-unstyled">
                                                <li class="price-detail">
                                                    <div class="detail-title detail-total">Grand Total</div>
                                                    <div class="detail-amt font-weight-bolder">${{ $total }}</div>
                                                </li>
                                            </ul>
                                            <button type="button" class="btn btn-primary btn-block btn-next place-order">Place Order</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Checkout Place Order Right ends -->
                            </div>
                        </div>
                    </div>
                    <!-- Checkout Place order Ends -->

                    <!-- Checkout Payment Starts -->
                    <div id="step-payment" class="content">
                        <div class="row match-height mt-2">
                            <!-- Stripe Card -->
                            <div class="col-lg-7 col-md-6 col-12">
                                <div class="card card-payment">
                                    <div class="card-header">
                                        <h4 class="card-title">Credit Or Debit Card</h4>
                                        <h4 class="card-title text-primary">${{ $total }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('stripe.cashier.payment') }}" method="POST" class="form" id="stripe-cashier-payment-form">
                                        @csrf  
                                            <input type="hidden" name="total" id="total" value="{{ $total }}">
                                            <input type="hidden" name="payment_method" class="payment-method">
                                            <div class="row">
                                                <div class="col-6 mt-1 mb-1 business-card">
                                                    <div class="business-items">
                                                        @if(isset($savedCards) && count($savedCards)>0)
                                                        @foreach($savedCards as $key => $value)
                                                        <div class="business-item">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="saved-card-{{ $key }}" name="select_card_btn" class="custom-control-input" value="0" data-token="{{ $value->id }}">
                                                                    <label class="custom-control-label" for="saved-card-{{ $key }}">**** **** **** {{ $value->card->last4 }}</label>
                                                                </div>
                                                                <label for="saved-card-{{ $key }}">{{ $value->card->exp_month }}/{{ $value->card->exp_year }}</label>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                        @endif
                                                        <div class="business-item">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="new-card" name="select_card_btn" class="custom-control-input" value="1" checked>
                                                                    <label class="custom-control-label" for="new-card">New Card Payment</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>  
                                                <div class="col-12 mt-1 mb-1" id="new-card-div">
                                                    <div class="form-group">
                                                        <div id="card-element"></div>
                                                    </div>
                                                    <hr class="mb-0">
                                                    <div class="card-errors" id="card-errors" role="alert"></div>
                                                </div>
                                                <div class="col-12" id="save-card-div">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="save_card" class="custom-control-input" id="save-card">
                                                            <label class="custom-control-label" for="save-card">Do you want to save card ?</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-0">
                                                    <button type="submit" id="stripe-payment-btn" class="btn btn-primary btn-block waves-effect waves-float waves-light">Make Payment</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--/ Stripe Card -->

                            <!-- Amount Payable -->
                            <div class="col-lg-5 col-md-6 col-12">
                                <div class="amount-payable checkout-options">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Price Details</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled price-details">
                                                <li class="price-detail">
                                                    <div class="details-title">Price of {{ count($products) }} items</div>
                                                    <div class="detail-amt">
                                                        <strong>${{ $total }}</strong>
                                                    </div>
                                                </li>
                                                <li class="price-detail">
                                                    <div class="details-title">Delivery Charges</div>
                                                    <div class="detail-amt discount-amt text-success">Free</div>
                                                </li>
                                            </ul>
                                            <hr />
                                            <ul class="list-unstyled price-details">
                                                <li class="price-detail">
                                                    <div class="details-title">Amount Payable</div>
                                                    <div class="detail-amt font-weight-bolder">${{ $total }}</div>
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
@endsection
@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script>
$(document).ready(function () {
    
    /* Manage New Card & Saved Card Payment */
    $("input[name$='select_card_btn']").click(function() {
        var value = $(this).val();
        if(value == 1){
            $("#new-card-div").show();
            $("#save-card-div").show();
        }else{
            $("#new-card-div").hide();
            $("#save-card-div").hide();
            $('#save-card').prop('checked', false);
        }
    });

    /* Stripe Payment Start */
    var stripe = Stripe('pk_test_51IYAIBSBdMBtLHAgGz0qDnwlqstz9lMpH2YY100yKnXUVn3cjtkxhShiggvLHSsoJxw8HJjvl7fnu9rbIFP0PU8t00uPxqKFk4');
    var elements = stripe.elements();

    var style = {
        base: {
            fontSize: '16px',
            color: '#32325d',
        },
    };

    var card = elements.create('card', {style: style});
    card.mount('#card-element');

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('stripe-cashier-payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        $("#stripe-payment-btn").addClass("disabled");
        $("#stripe-payment-btn").prop('disabled', true);

        var saveCard = $('input[name="select_card_btn"]:checked').val();
        if(saveCard == 1){
            stripe.createPaymentMethod({
                type: 'card',
                card: card
            }).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    $("#stripe-payment-btn").removeClass("disabled");
                    $("#stripe-payment-btn").prop('disabled', false);
                } else {
                    stripeTokenHandler(result.paymentMethod.id);
                }
            });  
        }else{
            var token = $('input[name="select_card_btn"]:checked').attr("data-token");
            stripeTokenHandler(token);
        }

    });

    function stripeTokenHandler(token) {
        var save_card = 0;
        if($("#save-card").prop('checked') == true){
            save_card = 1;
        }

        $.ajax({
            url: baseUrl + '/stripe/cashier-payment',
            type: "POST",
            data: {
                stripeToken : token,
                save_card : save_card,
                amount : <?php echo $total; ?>
            },
            dataType: 'json',
            success: function (response) {
                if(response.status){
                    if(response.data.status != '' && response.data.status == 'requires_action') {
                        console.log(response.data);
                        stripe.confirmCardPayment(
                            response.data.client_secret
                        ).then(handleStripeJsResult);                    
                    }else if(response.data.status != '' && response.data.status == 'succeeded'){
                        toastr.success("Payment Successful", "Success !!");
                        $("#stripe-payment-btn").removeClass("disabled");
                        $("#stripe-payment-btn").prop('disabled', false);
                        $('#save-card').prop('checked', false);
                        card.clear();
                    }
                }else{
                    toastr.error(response.msg, "Error !!");
                    $("#stripe-payment-btn").removeClass("disabled");
                    $("#stripe-payment-btn").prop('disabled', false);
                    $('#save-card').prop('checked', false);
                    card.clear();
                }
            },
            error: function (response) {
                toastr.error("Oops, something went wrong..", "Error !!");
                $("#stripe-payment-btn").removeClass("disabled");
                $("#stripe-payment-btn").prop('disabled', false);
                $('#save-card').prop('checked', false);
                card.clear();
            }
        });
    }

    function handleStripeJsResult(result) {
        console.log(result);
        if (result.error) {
            $.ajax({
                url: baseUrl + '/change-payment-status',
                type: "POST",
                data: {
                    id : result.error.payment_intent.id,
                    status: 2
                },
                dataType: 'json',
                success: function (response) {
                    if(response.status){
                        toastr.error(result.error.message, "Failed !!");
                        $("#stripe-payment-btn").removeClass("disabled");
                        $("#stripe-payment-btn").prop('disabled', false);
                    }
                },
            });
        } else {
            $.ajax({
                url: baseUrl + '/change-payment-status',
                type: "POST",
                data: {
                    id : result.paymentIntent.id,
                    status: 1
                },
                dataType: 'json',
                success: function (response) {
                    if(response.status){
                        toastr.success("Payment Successful", "Success !!");
                        $("#stripe-payment-btn").removeClass("disabled");
                        $("#stripe-payment-btn").prop('disabled', false);
                        $('#save-card').prop('checked', false);
                        card.clear();  
                    }
                },
            });
        }
    }
    /* Stripe Payment End */

});
</script>
@endsection
