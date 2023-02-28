<div class="modal modal-slide-in data-modal fade" id="modals-slide-in">
    <div class="modal-dialog">
        <form class="add-data-modal modal-content pt-0" id="modelForm" name="modelForm">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1"><h5 class="modal-title" id="exampleModalLabel">Add New</h5></div>
            <div class="modal-body flex-grow-1">
                <div class="form-group">
                    <label class="form-label" for="name" id="caption"></label>
                    <input type="text" class="form-control dt-full-name" id="name" placeholder="Please Enter" name="name" aria-label="Asia" aria-describedby="basic-icon-default-fullname2" />
                </div>
                <input type="hidden" id="id" name="id" value=""/>
                <input type="hidden" id="references" name="references" value=""/>
                <input type="hidden" id="module" name="module" value=""/>
                <input type="hidden" id="mode" name="mode" value=""/>
                <input type="hidden" id="dealer_id_modal" name="dealer_id" value=""/>
                <button type="button" class="btn btn-primary mr-1 data-submit" onclick="___saveRightPanelModalData();">Submit</button>
                <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>