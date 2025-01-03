<div class="modal fade" id="returnToPurch{{$data->id }}" tabindex="-1" role="dialog" aria-labelledby="ReturnToSalesModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Return to Purchasing</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" action="{{ url('return_spe_purch/'.$data->id ) }}" onsubmit="show()">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea name="ReturnRemarksPurch" class="form-control" cols="50" rows="10" placeholder="Enter remarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit"  class="btn btn-success" value="Save">
                    </div>
                </form>
            </div>
		</div>
	</div>
</div>