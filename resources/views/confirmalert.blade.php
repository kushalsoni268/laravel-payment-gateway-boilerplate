<!-- Modal -->
<div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Delete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this record ?</p>
            </div>
            <input type="hidden" name="id" id="id" value=""/>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="delete-record">Delete</button>                                               
            </div>
        </div>
    </div>
</div>                                 
<!--End::Modal-->

<!-- Modal -->
<div class="modal fade text-left" id="approve-reject-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="approve-reject-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <p id="approve-reject-body"></p>
            </div>
            <input type="hidden" name="id" id="id" value=""/>
            <input type="hidden" name="status" id="status" value=""/>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="approve-reject-property-btn">Yes</button>                                               
            </div>
        </div>
    </div>
</div>                                 
<!--End::Modal-->

<!-- Modal -->
<div class="modal fade text-left" id="display-image-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Property Image</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <img src="" id="previewImg" class="img-fluid rounded" style="max-height:300px !important" width="500" alt="avatar img') }}" />
            </div>
        </div>
    </div>
</div>                                 
<!--End::Modal-->

<!-- Modal -->
<div class="modal fade text-left" id="preview-identity-image-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Customer ID proof</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <!-- <img src="" id="identityPreviewImg" class="img-fluid rounded" style="max-height:300px !important" width="500" alt="avatar img') }}" /> -->
                <img src="" id="identityPreviewImg" class="img-fluid rounded" style="width:100%;height:auto;" alt="avatar img') }}" />
            </div>
        </div>
    </div>
</div>                                 
<!--End::Modal-->

<!-- Modal -->
<div class="modal fade text-left" id="cancel-booking-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Cancel Booking</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to cancel this booking ?</p>
            </div>
            <input type="hidden" name="booking_id" id="booking_id" value=""/>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="cancel-booking">Yes</button>                                               
            </div>
        </div>
    </div>
</div>                                 
<!--End::Modal-->

<!-- Modal -->
<div class="modal fade text-left" id="generate-payout-cycle-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Generate Payout Cycle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to generate payout cycle for this host ?</p>
            </div>
            <input type="hidden" name="host_id" id="host_id" value=""/>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="generate-payout-cycle">Yes</button>                                               
            </div>
        </div>
    </div>
</div>                                 
<!--End::Modal-->