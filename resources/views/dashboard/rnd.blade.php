@extends('layouts.header')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <h3 class="font-weight-bold">Welcome back,&nbsp;{{auth()->user()->full_name}}!</h3>
            <h4 class="font-weight-normal mb-0" style="color: #7d7373">{{ date('l, d F') }} | <p style="font-size: 1.125rem;display: contents;" id="demo"></p></h4>
        </div>
    </div>
    <div class="row">
        @if ((optional($role)->name == 'Staff L2' || optional($role)->name == 'Department Admin') && (optional($role)->type == 'RND'))
            <div class="col-md-3 grid-margin transparent">
                <div class="card mb-2 card-tale">
                    <div class="card-body">
                        <p class="card-title text-white">Initial Review</p>
                        <div class="d-flex justify-content-between">
                            <div class="mb-3 mt-2">
                                <h3 class="fs-30 font-weight-medium text-white">
                                    {{ $totalInitialReview ?? '0' }}
                                    <i class="ti ti-check"></i>
                                </h3>
                            </div>
                            <!-- <div class="mt-3">
                                <a href="#" class="text-info">View all</a>
                            </div> -->
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>CRR</p>
                            <h5 class="font-weight-medium text-white">
                                <a href="{{ route('customer_requirement.index', ['progress' => 57]) }}" class="text-white" onclick="show()">
                                    {{ $crrRNDInitialReview ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>RPE</p>
                            <h5 class="font-weight-medium text-white">
                                <a href="{{ route('product_evaluation.index', ['progress' => 57]) }}" class="text-white" onclick="show()">
                                    {{ $rpeRNDInitialReview ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>SRF</p>
                            <h5 class="font-weight-medium text-white">
                                <a href="{{ route('sample_request.index', ['progress' => 57]) }}" class="text-white" onclick="show()">
                                    {{ $srfRNDInitialReview ?? '0' }}
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card card-light-blue">
                    <div class="card-body">
                        <p class="card-title text-white">Final Review</p>
                        <div class="d-flex justify-content-between">
                            <div class="mb-3 mt-2">
                                <h3 class="fs-30 font-weight-medium">
                                    {{ $totalFinalReview ?? '0'}}
                                    <i class="ti ti-check-box"></i>
                                </h3>
                            </div>
                            <!-- <div class="mt-3">
                                <a href="{{ url('/activities?open=10') }}" class="text-info">View all</a>
                            </div> -->
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>CRR</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('customer_requirement.index', ['progress' => 81]) }}" class="text-white" onclick="show()">
                                    {{ $crrRNDFinalReview ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>RPE</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('product_evaluation.index', ['progress' => 81]) }}" class="text-white" onclick="show()">
                                    {{ $rpeRNDFinalReview ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>SRF</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('sample_request.index', ['progress' => 81]) }}" class="text-white" onclick="show()">
                                    {{ $srfRNDFinalReview ?? '0' }}
                                </a>
                            </h5>
                            <!-- <h5 class="text-primary font-weight-medium">{{ $srfSalesApproval ?? '0' }}</h5> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin transparent">
                <div class="card mb-2 card-dark-blue">
                    <div class="card-body">
                        <p class="card-title text-white">New Request</p>
                        <div class="d-flex justify-content-between">
                            <div class="mb-3 mt-2">
                                <h3 class="fs-30 font-weight-medium text-white">
                                    {{ $totalNewRequest ?? '0' }}
                                    <i class="ti ti-file"></i>
                                </h3>
                            </div>
                            <!-- <div class="mt-3">
                                <a href="#" class="text-info">View all</a>
                            </div> -->
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>CRR</p>
                            <h5 class="font-weight-medium text-white">
                                <a href="{{ route('customer_requirement.index', ['progress' => 30]) }}" class="text-white" onclick="show()">
                                    {{ $crrRNDNew ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>RPE</p>
                            <h5 class="font-weight-medium text-white">
                                <a href="{{ route('product_evaluation.index', ['progress' => 30]) }}" class="text-white" onclick="show()">
                                    {{ $rpeRNDNew ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>SRF</p>
                            <h5 class="font-weight-medium text-white">
                                <a href="{{ route('sample_request.index', ['progress' => 30]) }}" class="text-white" onclick="show()">
                                    {{ $srfRNDNew ?? '0' }}
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="card-title text-white">Due Today</p>
                        <div class="d-flex justify-content-between">
                            <div class="mb-3 mt-2">
                                <h3 class="fs-30 font-weight-medium">
                                    {{ $totalDueToday ?? '0'}}
                                    <i class="ti ti-bell"></i>
                                </h3>
                            </div>
                            <!-- <div class="mt-3">
                                <a href="{{ url('/activities?open=10') }}" class="text-info">View all</a>
                            </div> -->
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>CRR</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('customer_requirement.index', ['DueDate' => 'past']) }}" class="text-white">
                                    {{ $crrDueToday ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>RPE</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('product_evaluation.index', ['DueDate' => 'past']) }}" class="text-white">
                                    {{ $rpeDueToday ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>SRF</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('sample_request.index', ['DateRequired' => 'past']) }}" class="text-white">
                                    {{ $srfDueToday ?? '0' }}
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">New Products</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless tables">
                                <thead>
                                    <tr>
                                        <th width="25%">DDW Number</th>
                                        <th width="25%">Code</th>
                                        <th width="25%">Created By</th>
                                        <th width="25%">Date Created</th>
                                    </tr>  
                                </thead>
                                <tbody>
                                    @foreach($newProducts as $product)
                                        <tr>
                                            <td>{{ $product->ddw_number }}</td>
                                            <td>
                                                <a href="{{url('view_new_product/'.$product->id)}}"  title="View Products">
                                                    {{ $product->code }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $product->userByUserId ? $product->userByUserId->full_name : ($product->userById ? $product->userById->full_name : 'N/A') }}
                                            </td>
                                            <td>{{date('m/d/Y', strtotime($product->created_at))}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ((optional($role)->name == 'Staff L1') && (optional($role)->type == 'RND'))
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal">
                            <h4 class="d-flex justify-content-between font-weight-bold mb-4">Account Information</h4>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label"><b>System Role</b></label>
                                <div class="col-sm-9">
                                    <label>{{ auth()->user()->role->name ?? 'No Role Assigned' }}</label>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label"><b>Company</b></label>
                                <div class="col-sm-9">
                                    <label>{{auth()->user()->company->name}}</label>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label"><b>Department</b></label>
                                <div class="col-sm-9">
                                    <label>{{auth()->user()->department->name}}</label>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label"><b>Username</b></label>
                                <div class="col-sm-9">
                                    <label>{{auth()->user()->username}}</label>
                                </div>
                            </div>
                            <div class="form-group row mb-2" style="margin-top: 2.5em">
                                <div class="col-md-12">
                                    <a href="{{ route('change_password') }}" class="btn btn-info">
                                        <i style="color: #fff" class="ti ti-unlock"></i>&nbsp;Change Password
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin transparent">
                <div class="card mb-2 card-tale">
                    <div class="card-body">
                        <p class="card-title text-white">Open Transactions</p>
                        <div class="d-flex justify-content-between">
                            <div class="mb-3 mt-2">
                                <h3 class="text-white fs-30 font-weight-medium">
                                    {{ $totalOpenRND ?? '0' }}
                                    <i class="ti ti-check-box"></i>
                                </h3>
                            </div>
                            <!-- <div class="mt-3">
                                <a href="#" class="text-info">View all</a>
                            </div> -->
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>CRR</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('customer_requirement.index', ['status' => 10]) }}" class="text-white" onclick='show()'>
                                    {{ $rndCrrOpen ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>RPE</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('product_evaluation.index', ['status' => 10]) }}" class="text-white" onclick='show()'>
                                    {{ $rndRpeOpen ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>SRF</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('sample_request.index', ['status' => 10]) }}" class="text-white" onclick='show()'>
                                    {{ $rndSrfOpen ?? '0' }}
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card card-light-blue">
                    <div class="card-body">
                        <p class="card-title text-white">Closed Transactions</p>
                        <div class="d-flex justify-content-between">
                            <div class="mb-3 mt-2">
                                <h3 class="text-white fs-30 font-weight-medium">
                                    {{ $totalClosedRND ?? '0'}}
                                    <i class="ti ti-folder"></i>
                                </h3>
                            </div>
                            <!-- <div class="mt-3">
                                <a href="{{ url('/activities?open=10') }}" class="text-info">View all</a>
                            </div> -->
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>CRR</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('customer_requirement.index', ['status' => 30]) }}" class="text-white" onclick='show()'>
                                    {{ $rndCrrClosed ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>RPE</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('product_evaluation.index', ['status' => 30]) }}" class="text-white" onclick='show()'>
                                    {{ $rndRpeClosed ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>SRF</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('sample_request.index', ['status' => 30]) }}" class="text-white" onclick='show()'>
                                    {{ $rndSrfClosed ?? '0' }}
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin transparent">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="card-title text-white">Due Today</p>
                        <div class="d-flex justify-content-between">
                            <div class="mb-3 mt-2">
                                <h3 class="text-white fs-30 font-weight-medium">
                                    {{ $totalDue ?? '0'}}
                                    <i class="ti ti-bell"></i>
                                </h3>
                            </div>
                            <!-- <div class="mt-3">
                                <a href="{{ url('/activities?open=10') }}" class="text-info">View all</a>
                            </div> -->
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>CRR</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('customer_requirement.index', ['status' => 10, 'DueDate' => 'past']) }}" class="text-white" onclick="show()">
                                    {{ $crrDue ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>RPE</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('product_evaluation.index', ['status' => 10, 'DueDate' => 'past']) }}" class="text-white" onclick="show()">
                                    {{ $rpeDue ?? '0' }}
                                </a>
                            </h5>
                        </div>
                        <div class="mb-1 d-flex justify-content-between">
                            <p>SRF</p>
                            <h5 class="text-primary font-weight-medium">
                                <a href="{{ route('sample_request.index', ['status' => 10, 'DateRequired' => 'past']) }}" class="text-white" onclick="show()">
                                    {{ $srfDue ?? '0' }}
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
    </div>
</div>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap4.js"></script>
<script>
    $('.tables').dataTable( {
        "dom": 'rtip'
    });
</script>
@endsection