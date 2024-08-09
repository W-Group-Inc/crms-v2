@extends('layouts.header')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between align-items-center">Client List (Archived)</h4>
            <form method="GET" class="custom_form mb-3" enctype="multipart/form-data">
                <div class="height d-flex justify-content-between align-items-between">
                    <a href="{{url('export_archived_client')}}" class="btn btn-md btn-success mb-1">Export</a>
                    <div class="col-md-5">
                        <div class="search">
                            <i class="ti ti-search"></i>
                            <input type="text" class="form-control" placeholder="Search Client" name="search" value="{{ $search }}"> 
                            <button class="btn btn-sm btn-info" type="submit">Search</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="client_archived">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Type</th>
                            <th>Industry</th>
                            <th>Buyer Code</th>
                            <th>Name</th>
                            <th>Account Manager</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($clients->count() > 0)
                            @foreach($clients as $client)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" title="View Client" onclick="viewClient({{ $client->id }})">
                                            <i class="ti-eye"></i>
                                        </button>
                                        <button type="button" class="prospectClient btn btn-sm btn-warning" title="Prospect Client" data-id="{{ $client->id }}">
                                            <i class="ti ti-control-record"></i>
                                        </button>
                                        <button type="button" class="deleteClient btn btn-sm btn-danger" title="Delete Client" data-id="{{ $client->id }}">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                    <td>
                                        @if($client->Type == "1")
                                            <label>Local</label>
                                        @elseif($client->Type == "2")
                                            <label>International</label>
                                        @else
                                            <label>N/A</label>
                                        @endif
                                    </td>
                                    <td>{{ $client->industry->Name ?? 'N/A' }}</td>
                                    <td>{{ $client->BuyerCode ?? 'N/A' }}</td>
                                    <td>{{ $client->Name ?? 'N/A' }}</td>
                                    <td>
                                        {{ $client->userByUserId->full_name ?? $client->userById->full_name ?? 'N/A' }} / 
                                        {{ $client->userByUserId2->full_name ?? $client->userById2->full_name ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">No matching records found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {!! $clients->appends(['search' => $search])->links() !!}

            @php
                $total = $clients->total();
                $currentPage = $clients->currentPage();
                $perPage = $clients->perPage();
                $from = ($currentPage - 1) * $perPage + 1;
                $to = min($currentPage * $perPage, $total);
            @endphp

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>Showing {{ $from }} to {{ $to }} of {{ $total }} entries</div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        // $('#client_archived').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: {
        //         url: "{{ route('client.archived') }}"
        //     },
        //     columns: [
        //         {
        //             data: 'Type',
        //             name: 'Type',
        //             render: function(data, type, row) {
        //                 // Display "Local" for type 1 and "International" for type 2
        //                 return data == 1 ? 'Local' : 'International';
        //             }
        //         },
        //         {
        //             data: 'industry.Name',
        //             name: 'industry.Name'
        //         },
        //         {
        //             data: 'BuyerCode',
        //             name: 'BuyerCode'
        //         },
        //         {
        //             data: 'Name',
        //             name: 'Name'
        //         },
        //         // {
        //         //     data: '',
        //         //     name: ''
        //         // },
        //         {
        //             data: 'action',
        //             name: 'action',
        //             orderable: false
        //         }
        //     ],
        //     columnDefs: [
        //         {
        //             targets: [0, 1, 2, 3], 
        //             render: function(data, type, row) {
        //                 return '<div style="white-space: break-spaces; width: 100%;">' + data + '</div>';
        //             }
        //         }
        //     ]
        // });
        $(".prospectClient").on('click', function() {
            var clientId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to pursue this prospect client!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirmed it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('prospect_client') }}/" + clientId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.responseJSON.error
                            });
                        }
                    });
                }
            });
        });

        $(".deleteClient").on('click', function() {
            var clientId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('delete_client') }}/" + clientId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.responseJSON.error
                            });
                        }
                    });
                }
            });
        });
    });

    function viewClient(clientId) {
        window.location.href = "{{ url('view_client') }}/" + clientId;
    }
</script>
@endsection
