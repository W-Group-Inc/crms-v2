<div class="modal fade" id="approveSrf{{ $sampleRequest->Id }}" tabindex="-1" role="dialog" aria-labelledby="SRF Approval" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SRFApproval">Approve Sample Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_sample_request" enctype="multipart/form-data" action="{{ url('ApproveSrf/'.$sampleRequest->Id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="ApprovalRemark">Comment/Remark</label>
                        <input type="text" class="form-control" name="Remarks" placeholder="Enter Approval Remarks">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="submitbutton" value="Approve_to_{{ $sampleRequest->RefCode }}" class="btn btn-success">
                            Approve to 
                            @if ($sampleRequest->RefCode == 1)
                                RND
                            @elseif ($sampleRequest->RefCode == 2)
                                QCD-WHI
                            @elseif ($sampleRequest->RefCode == 3)
                                QCD-PBI
                            @elseif ($sampleRequest->RefCode == 4)
                                QCD-MRDC
                            @elseif ($sampleRequest->RefCode == 5)
                                QCD-CCC
                            @endif
                        </button>
                        <button type="submit" class="btn btn-success" name="submitbutton" value="Approve_to_sales">Approve to Sales</button>
                        {{-- <button type="submit" name="submitbutton" value="Approve to QCD" class="btn btn-success">Approve to QCD</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
