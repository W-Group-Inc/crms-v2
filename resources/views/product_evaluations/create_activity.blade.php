<div class="modal fade" id="createRpeActivity" tabindex="-1" role="dialog" aria-labelledby="RPE Activity" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Prf Acitivity">New Activity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_price_request" enctype="multipart/form-data" action="{{ url('new_activity') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control form-control-sm js-example-basic-single" name="Type" id="Type" style="position: relative !important" title="Select Type" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="10">Task</option>
                                    <option value="20">Call</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Related To</label>
                                <select class="form-control form-control-sm js-example-basic-single" name="RelatedTo" id="RelatedTo" style="position: relative !important" title="Select Type" required>
                                    <option value="" disabled selected>Select Related Entry Type</option>
                                    <option value="10">Customer Requirement</option>
                                    <option value="20">Request Product Evaluation</option>
                                    <option value="30">Sample Request</option>
                                    <option value="35">Price Request</option>
                                    <option value="40">Complaint</option>
                                    <option value="50">Feedback</option>
                                    <option value="60">Collection</option>
                                    <option value="70">Account Targeting</option>
                                    <option value="91">Follow-up Sample/Projects</option>
                                    <option value="92">Sample Dispatch</option>
                                    <option value="93">Technical Presentation</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Client</label>
                                <select class="form-control js-example-basic-single ClientId" name="ClientId"  style="position: relative !important" title="Select Client" required>
                                    <option value="" disabled selected>Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Transaction Number</label>
                                <input type="text" class="form-control form-control-sm" name="TransactionNumber" value="{{ $requestEvaluation->RpeNumber }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Contact</label>
                                <select class="form-control form-control-sm js-example-basic-single ClientContactId" name="ClientContactId" id="ClientContactId" style="position: relative !important" title="Select Contact" required>
                                    <option value="" disabled selected>Select Contact</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Schedule</label>
                                <input type="date" class="form-control form-control-sm ScheduleFrom" id="ScheduleFrom" name="ScheduleFrom" required value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Primary Responsible</label>
                                <select class="form-control js-example-basic-single" name="PrimarySalesPersonId" id="PrimarySalesPersonId" style="position: relative !important" title="Select Sales Person">
                                    <option value="" disabled selected>Select Sales Person</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->user_id }}">{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Due Date</label>
                                <input type="date" class="form-control ScheduleTo" id="ScheduleTo" name="ScheduleTo" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Secondary Responsible</label>
                                <select class="form-control js-example-basic-single" name="SecondarySalesPersonId" id="SecondarySalesPersonId" style="position: relative !important" title="Select Sales Person">
                                    <option value="" disabled selected>Select Sales Person</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->user_id }}">{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control form-control-sm" id="Title" name="Title" placeholder="Enter Title" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Attachments</label>
                                <input type="file" class="form-control form-control-sm" name="path[]" multiple required>
                                <small><b style="color:red">Note:</b> The file must be a type of: jpg, jpeg, png, pdf, doc, docx.</small>
                                <div class="col-sm-9">
                                    <ul id="fileList"></ul>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-6 edit-status" style="display: none;">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control form-control-sm js-example-basic-single" name="Status" id="Status" style="position: relative !important" title="Select Type" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="10">Open</option>
                                    <option value="20">Closed</option>
                                </select>
                            </div>
                        </div> --}}
                        {{-- <div class="col-lg-6 edit-status" style="display: none;">
                            <div class="form-group">
                                <label>Date Closed</label>
                                <input type="date" class="form-control form-control-sm" id="DateClosed" name="DateClosed" required>
                            </div>
                        </div> --}}
                        <div class="col-lg-12">
                            <div class="form-group">
                            <label for="Description" class="form-label">Description</label>
                            <textarea class="form-control form-control-sm" id="Description" name="Description" rows="3" placeholder="Enter Description" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.ClientId').change(function() {
            var clientId = $(this).val();
            if (clientId) {
                $.ajax({
                    url: '{{ url("client-contact") }}/' + clientId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#ClientContactId').empty();
                        $('#ClientContactId').append('<option value="" disabled selected>Select Contact</option>');
                        $.each(data, function(key, value) {
                            $('#ClientContactId').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            } else {
                $('#ClientContactId').empty();
                $('#ClientContactId').append('<option value="" disabled selected>Select Contact</option>');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var scheduleInput = document.querySelector('.ScheduleFrom');
        var DueDateInput = document.querySelector('.ScheduleTo');

        var today = new Date().toISOString().split('T')[0];

            scheduleInput.setAttribute('min', today);
            DueDateInput.setAttribute('min', today);
    });
</script>
    