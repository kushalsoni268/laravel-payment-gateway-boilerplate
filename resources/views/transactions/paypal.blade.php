@extends('layouts.master')
@section('title','Paypal Transactions')
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
                            <h2 class="content-header-title float-left mb-0">Transactions</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Paypal Transactions
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic table -->
                <section id="ajax-datatable">
                    <div class="row">
                        <div class="col-12">
                            @include('errormessage')
                            <div class="card">
                                <div class="card-datatable">
                                    <table class="datatables-ajax table" id="paypal-transaction-table">
                                        <thead>
                                            <tr>
                                                <th>Transaction Id</th>
                                                <th>Amount</th>  
                                                <th>Status</th>  
                                                <th>Action</th>                                  
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->
                </div>
        </div>
    </div>
    <!-- END: Content-->
@include('confirmalert')
@endsection
@section('script')
<script>
$(document).ready(function () {

    var initTable1 = function () {
        var table = $('#paypal-transaction-table');
        // begin first table
        table.DataTable({
            lengthMenu: getPageLengthDatatable(),
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: "{{route('getpaypaltransactions')}}",
                type: 'post',
                data: function (data) {
                    data.fromValues = $("#filterData").serialize();
                }
            },
            columns: [
                {data: 'transaction_id', name: 'transaction_id'},
                {data: 'amount', name: 'amount'},               
                {data: 'status', name: 'status'},      
                {data: 'action', name: 'action', searchable: false, sortable: false,responsivePriority: -1}                                  
            ],
        });
    };
    initTable1();

});
</script>
@endsection
