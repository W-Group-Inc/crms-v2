@extends('layouts.header')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card border border-1 border-primary rounded-0">
        <div class="card-header bg-primary">
            <p class="m-0 text-white font-weight-bold">Customer Satisfaction List</p>
        </div>
        <div class="card-body">
            <div class="form-group">
                <form method="GET">
                    <label>Show : </label>
                    <label class="checkbox-inline">
                        <input name="open" class="activity_status" type="checkbox" value="10" @if(request('open', $open) == '10') checked @endif> Open
                    </label>
                    <label class="checkbox-inline">
                        <input name="close" class="activity_status" type="checkbox" value="30" @if(request('close') == '30') checked @endif> Closed
                    </label>
                    <button type="submit" class="btn btn-sm btn-primary">Filter Status</button>
                </form>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <span>Showing</span>
                    <form method="GET" class="d-inline-block" onsubmit="show()">
                        <select name="entries" class="form-control">
                            <option value="10"  @if($entries == 10) selected @endif>10</option>
                            <option value="25"  @if($entries == 25) selected @endif>25</option>
                            <option value="50"  @if($entries == 50) selected @endif>50</option>
                            <option value="100" @if($entries == 100) selected @endif>100</option>
                        </select> 
                    </form>
                    <span>Entries</span>
                </div>
                <div class="col-lg-6">
                    <form method="GET" class="custom_form mb-3" enctype="multipart/form-data">
                        <div class="row height d-flex justify-content-end align-items-end">
                            <div class="col-md-9">
                                <div class="search">
                                    <i class="ti ti-search"></i>
                                    <input type="text" class="form-control" placeholder="Search Customer Satisfaction" name="search" value="{{$search}}">
                                    <button class="btn btn-sm btn-info">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="spe_table" width="100%">
                    <thead>
                        <tr>
                            <th>CSR #</th>
                            <th>Date Requested</th>
                            <th>Company Name</th>
                            <th>Contact Name</th>
                            <th>Department Concerned</th>
                            <th>Category</th>
                            <!-- <th>Status</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($data) > 0)
                            @foreach ($data as $cs_data)
                            <tr>
                                <td>
                                    <a href="{{ url('customer_satisfaction/view/' . $cs_data->id) }}" title="View Customer Satisfaction">{{ $cs_data->CsNumber }}</a>
                                </td>
                                <td>{{ date('M. d, Y', strtotime($cs_data->created_at)) }}</td>
                                <td>{{ $cs_data->CompanyName }}</td>
                                <td>{{ $cs_data->ContactName }}</td>
                                <td>{{ $cs_data->concerned->Name ?? 'N/A' }}</td>
                                <td>{{ $cs_data->category->Name }}</td>
                                <!-- <td>
                                    @if($cs_data->Status == 10)
                                        <div class="badge badge-success">Open</div>
                                    @else
                                        <div class="badge badge-warning">Closed</div>
                                    @endif
                                </td> -->
                            </tr>   
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" align="center">No data available.</td>
                            </tr>
                        @endif                 
                    </tbody>
                </table>
            </div>
            {{ $data->appends(request()->query())->links() }}
            @php
                $total = $data->total();
                $currentPage = $data->currentPage();
                $perPage = $data->perPage();

                $from = ($currentPage - 1) * $perPage + 1;
                $to = min($currentPage * $perPage, $total);
            @endphp
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>Showing {{ $from }} to {{ $to }} of {{ $total }} entries</div>
            </div>
        </div>
    </div>
</div>
@endsection