<div class="modal fade" id="editActivity-{{$a->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Activity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_activity" enctype="multipart/form-data" action="{{url('update_activity/'.$a->id)}}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control form-control-sm js-example-basic-single" name="Type" style="position: relative !important" title="Select Type" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="30" @if($a->Type == 30) selected @endif>OB</option>
                                    <option value="40" @if($a->Type == 40) selected @endif>Plant Visit</option>
                                    {{-- <option value="10" @if($a->Type == 10) selected @endif>Task</option> --}}
                                    <option value="20" @if($a->Type == 20) selected @endif>Call</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-lg-6">
                            <div class="form-group">
                                <label>Related To</label>
                                <select class="form-control form-control-sm js-example-basic-single" name="RelatedTo" style="position: relative !important" title="Select Type" required>
                                    <option value="" disabled selected>Select Related Entry Type</option>
                                    <option value="10" @if($a->RelatedTo == 10) selected @endif>Customer Requirement</option>
                                    <option value="20" @if($a->RelatedTo == 20) selected @endif>Request Product Evaluation</option>
                                    <option value="30" @if($a->RelatedTo == 30) selected @endif>Sample Request</option>
                                    <option value="35" @if($a->RelatedTo == 35) selected @endif>Price Request</option>
                                    <option value="40" @if($a->RelatedTo == 40) selected @endif>Complaint</option>
                                    <option value="50" @if($a->RelatedTo == 50) selected @endif>Feedback</option>
                                    <option value="60" @if($a->RelatedTo == 60) selected @endif>Collection</option>
                                    <option value="70" @if($a->RelatedTo == 70) selected @endif>Account Targeting</option>
                                    <option value="91" @if($a->RelatedTo == 91) selected @endif>Follow-up Sample/Projects</option>
                                    <option value="92" @if($a->RelatedTo == 92) selected @endif>Sample Dispatch</option>
                                    <option value="93" @if($a->RelatedTo == 93) selected @endif>Technical Presentation</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Client</label>
                                <select class="form-control form-control-sm js-example-basic-single ClientId" name="ClientId" style="position: relative !important" title="Select Client" required>
                                    <option value="" disabled selected>Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" @if($client->id == $a->ClientId) selected @endif>{{ $client->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Transaction Number</label>
                                <input type="text" class="form-control form-control-sm" id="TransactionNumber" name="TransactionNumber" placeholder="Enter Transaction Number" value="{{$a->TransactionNumber}}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Contact</label>
                                <select class="form-control form-control-sm js-example-basic-single ClientContactId" name="ClientContactId" style="position: relative !important" title="Select Contact" required>
                                    <option value="" disabled selected>Select Contact</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Schedule</label>
                                <input type="date" class="form-control form-control-sm" id="ScheduleFrom" name="ScheduleFrom" required value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Primary Responsible</label>
                                <select class="form-control form-control-sm js-example-basic-single" name="PrimaryResponsibleUserId" style="position: relative !important" title="Select Contact" required>
                                    <option value="" disabled selected>Select Primary Responsible</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" 
                                            {{ $currentUser && ($currentUser->id == $user->id || $currentUser->user_id == $user->id) ? 'selected' : '' }}>
                                            {{ $user->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Due Date</label>
                                <input type="date" class="form-control" id="ScheduleTo" name="ScheduleTo" value="{{$a->ScheduleTo}}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Secondary Responsible</label>
                                <select class="form-control form-control-sm js-example-basic-single" name="SecondaryResponsibleUserId" style="position: relative !important" title="Select Contact" required>
                                    <option value="" disabled selected>Select Secondary Responsible</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if($user->id == $a->SecondaryResponsibleUserId) selected @endif>
                                            {{ $user->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control form-control-sm" id="Title" name="Title" placeholder="Enter Title" value="{{$a->Title}}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Attachments</label>
                                <input type="file" class="form-control form-control-sm" name="path[]" multiple>
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
                            <textarea class="form-control form-control-sm" id="Description" name="Description" rows="3" placeholder="Enter Description" required>{!! nl2br(e($a->Description)) !!}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                            <label for="Description" class="form-label">Action Response</label>
                            <textarea class="form-control form-control-sm" id="Response" name="Response" rows="3" placeholder="Enter Description" required>{!! nl2br(e($a->Response)) !!}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                            <label for="Description" class="form-label">Date Closed</label>
                            <input type="date" name="DateClosed" class="form-control" value="{{$a->DateClosed}}" min="{{date('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                            <label for="Description" class="form-label">Status</label>
                            <select name="Status" class="form-control js-example-basic-single" required>
                                <option value="">-Status-</option>
                                <option value="10" @if($a->Status == 10) selected @endif>Open</option>
                                <option value="20" @if($a->Status == 20) selected @endif>Close</option>
                            </select>
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