<div class="modal fade" id="AddCustomerRequirement" tabindex="-1" role="dialog" aria-labelledby="addCustomerRequirement" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCustomerRequirentLabel">Add New Customer Requirement</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" action="{{ url('new_customer_requirement') }}" onsubmit="show()">
                    @csrf
                    <div class="row">
                        {{-- <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Date Created (DD/MM/YYYY) - Hour Minute</label>
                                <input type="datetime-local" class="form-control" id="CreatedDate" name="CreatedDate" required>
                            </div>
                        </div> --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Client</label>
                                <select class="form-control js-example-basic-single" name="ClientId" id="ClientId" style="position: relative !important" title="Select Client" required>
                                    <option value="" disabled selected>Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" @if(old('ClientId') == $client->id) selected @endif>{{ $client->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Priority</label>
                                <select class="form-control js-example-basic-single" name="Priority" id="Priority" style="position: relative !important" title="Select Priority">
                                    <option value="" disabled selected>Select Priority</option>
                                    <option value="1" @if(old('Priority') == 1) selected @endif>Low</option>
                                    <option value="3" @if(old('Priority') == 3) selected @endif>Medium</option>
                                    <option value="5" @if(old('Priority') == 5) selected @endif>High</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Application</label>
                                <select class="form-control js-example-basic-single" name="ApplicationId" id="ApplicationId" style="position: relative !important" title="Select Application" required>
                                    <option value="" disabled selected>Select Application</option>
                                    @foreach($product_applications as $product_application)
                                        <option value="{{ $product_application->id }}" @if(old('ApplicationId') == $product_application->id) selected @endif>{{ $product_application->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Due Date</label>
                                <input type="date" class="form-control" id="DueDate" value="{{old('DueDate')}}" name="DueDate">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-sm-8" style="padding-right: 0px">
                                    <div class="form-group">
                                        <label>Potential Volume</label>
                                        <input type="number" step=".01" class="form-control" id="PotentialVolume" name="PotentialVolume" value="{{old('PotentialVolume', 0)}}">
                                    </div>
                                </div>
                                <div class="col-sm-4" style="padding-left: 0px">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <select class="form-control js-example-basic-single" name="UnitOfMeasureId" id="UnitOfMeasureId" style="position: relative !important" title="Select Unit">
                                            <option value="" disabled selected>Select Unit</option>
                                            @foreach ($unitOfMeasure as $unit)
                                                <option value="{{$unit->Id}}" @if(old('UnitOfMeasureId') == $unit->Id) selected @endif>{{$unit->Name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Primary Sales Person</label>
                                {{-- <input type="hidden" name="PrimarySalesPersonId" value="{{auth()->user()->id}}">
                                <input type="text" class="form-control" value="{{auth()->user()->full_name}}" readonly> --}}
                                <select class="form-control js-example-basic-single" name="PrimarySalesPersonId" style="position: relative !important" title="Select Sales Person" required>
                                    <option value="" disabled selected>Select Sales Person</option>
                                    @foreach($currentUser->groupSales as $group_sales)
                                        @php
                                            $user = $group_sales->user;
                                        @endphp
                                        <option value="{{ $user->id }}" @if($user->id == $currentUser->id) selected @endif>{{ $user->full_name }}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-sm-8" style="padding-right: 0px">
                                    <div class="form-group">
                                        <label>Target Price</label>
                                        <input type="number" step=".01" class="form-control" id="TargetPrice" name="TargetPrice" value="{{old('TargetPrice', 0)}}">
                                    </div>
                                </div>
                                <div class="col-sm-4" style="padding-left: 0px">
                                    <div class="form-group">
                                        <label>Currency</label>
                                        <select class="form-control js-example-basic-single" name="CurrencyId" id="CurrencyId" style="position: relative !important" title="Select Currency">
                                            <option value="" disabled selected>Select Currency</option>
                                            @foreach($price_currencies as $price_currency)
                                                <option value="{{ $price_currency->id }}" @if(old('CurrencyId') == $price_currency->Name) selected @endif>{{ $price_currency->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Secondary Sales Person</label>
                                {{-- <select class="form-control js-example-basic-single" name="SecondarySalesPersonId" id="SecondarySalesPersonId" style="position: relative !important" title="Select Sales Person" required>
                                    <option value="" disabled selected>Select Sales Person</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if(old('SecondarySalesPersonId') == $user->id) selected @endif>{{ $user->full_name }}</option>
                                    @endforeach
                                </select> --}}
                                <select class="form-control js-example-basic-single" name="SecondarySalesPersonId" style="position: relative !important" title="Select Sales Person" required>
                                    <option value="" disabled selected>Select Sales Person</option>
                                    @foreach($currentUser->groupSales as $group_sales)
                                        @php
                                            $user = $group_sales->user;
                                        @endphp
                                        <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Competitor</label>
                                <input type="text" class="form-control" id="Competitor" name="Competitor" value="{{old('Competitor')}}" placeholder="Enter Competitor">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Competitor Price</label>
                                <input type="number" step=".01" class="form-control" id="CompetitorPrice" value="{{old('CompetitorPrice')}}" name="CompetitorPrice" value="0">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="name">Nature of Request</label>
                            <button type="button" class="btn btn-primary btn-sm addRow">+</button>

                            <div class="natureOfRequestContainer">
                                {{-- <div class="input-group mb-3">
                                    <select class="form-control js-example-basic-single" name="NatureOfRequestId[]" required>
                                        <option value="" disabled selected>Select Nature of Request</option>
                                        @foreach($nature_requests as $nature_request)
                                            <option value="{{ $nature_request->id }}">{{ $nature_request->Name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary addRow">+</button>
                                    </div>
                                </div> --}}
                                <div class="input-group mb-3">
                                    <select class="form-control natureRequestSelect" name="NatureOfRequestId[]" required>
                                        <option value="" disabled selected>Select Nature of Request</option>
                                        @foreach($nature_requests as $nature_request)
                                            <option value="{{ $nature_request->id }}">{{ $nature_request->Name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger removeRow">-</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">REF Code</label>
                                <select name="RefCode" class="form-control js-example-basic-single" required>
                                    <option disabled selected value>Select REF Code</option>
                                    @foreach ($refCode as $key=>$code)
                                        <option value="{{$key}}" @if(old('RefCode') == $key) selected @endif>{{$code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">REF CRR Number</label>
                                <input type="text" class="form-control" id="RefCrrNumber" name="RefCrrNumber" value="{{old('RefCrrNumber')}}" placeholder="Enter CRR Number">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">REF RPE Number</label>
                                <input type="text" class="form-control" id="RefRpeNumber" name="RefRpeNumber" value="{{old('RefRpeNumber')}}" placeholder="Enter RPE Number">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Upload Files</label>
                                <input type="file" name="sales_upload_crr[]" class="form-control" multiple>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Details of Requirement</label>
                                <textarea type="text" class="form-control" id="DetailsOfRequirement" name="DetailsOfRequirement" placeholder="Enter Details of Requirement" cols="30" rows="10">{{old('DetailsOfRequirement')}}</textarea>
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
{{-- <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script>
     @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK'
            });
        @elseif(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        @endif
</script> --}}