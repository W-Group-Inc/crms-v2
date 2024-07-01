@extends('layouts.header')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between align-items-center">
            Area List
            <button type="button" class="btn btn-md btn-primary" name="add_area" id="add_area">Add Area</button>
            </h4>
            <table class="table table-striped table-hover" id="area_table" width="100%">
                <thead>
                    <tr>
                        <th width="20%">Type</th>
                        <th width="20%">Region</th>
                        <th width="25%">Area</th>
                        <th width="25%">Description</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="formArea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Area</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_area" enctype="multipart/form-data" action="{{ route('region.store') }}">
                    <span id="form_result"></span>
                    @csrf
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control js-example-basic-single" name="Type" id="Type" style="position: relative !important" title="Select Type">
                            <option value="" disabled selected>Select Type</option>
                            <option value="1">Local</option>
                            <option value="2">International</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Region</label>
                        <select class="form-control js-example-basic-single" name="RegionId" id="RegionId" style="position: relative !important" title="Select Company">
                            <option value="" disabled selected>Select Region</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Area</label>
                        <input type="text" class="form-control" id="Name" name="Name" placeholder="Enter Area Name">
                    </div>
                    <div class="form-group">
                        <label for="name">Description</label>
                        <input type="text" class="form-control" id="Description" name="Description" placeholder="Enter Description">
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" id="action" value="Save">
                        <input type="hidden" name="hidden_id" id="hidden_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Region</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 20px">
                <h5 style="margin: 0">Are you sure you want to delete this data?</h5>
            </div>
            <div class="modal-footer" style="padding: 0.6875rem">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="delete_area" id="delete_area" class="btn btn-danger">Yes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> 

<script>
    $(document).ready(function(){
        $('#area_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('area.index') }}"
            },
            columns: [
                {
                    data: 'Type',
                    name: 'Type',
                    render: function(data, type, row) {
                        // Display "Local" for type 1 and "International" for type 2
                        return data == 1 ? 'Local' : 'International';
                    }
                },
                {
                    data: 'region.Name',
                    name: 'region.Name'
                },
                {
                    data: 'Name',
                    name: 'Name'
                },
                {
                    data: 'Description',
                    name: 'Description'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ],
            columnDefs: [
                {
                    targets: 1, // Target the first column (index 1)
                    render: function(data, type, row) {
                        return '<div style="white-space: break-spaces; width: 100%;">' + data + '</div>';
                    }
                },
                {
                    targets: 2, // Target the second column (index 2)
                    render: function(data, type, row) {
                        return '<div style="white-space: break-spaces; width: 100%;">' + data + '</div>';
                    }
                }
            ]
        });

        $('#add_area').click(function(){
            $('#formArea').modal('show');
            $('.modal-title').text("Add New Area");
        });

        $('#form_area').on('submit', function(event){
            event.preventDefault();
            if($('#action').val() == 'Save')
            {
                $.ajax({
                    url: "{{ route('area.store') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#form_area')[0].reset();
                            setTimeout(function(){
                                $('#formArea').modal('hide');
                            }, 2000);
                            $('#area_table').DataTable().ajax.reload();
                            setTimeout(function(){
                                $('#form_result').empty(); 
                            }, 2000); 
                        }
                        $('#form_result').html(html);
                    }
                })
            }

            if($('#action').val() == 'Edit')
            {
                var formData = new FormData(this);
                formData.append('id', $('#hidden_id').val());
                $.ajax({
                    url: "{{ route('update_area', ':id') }}".replace(':id', $('#hidden_id').val()),
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success:function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#form_area')[0].reset();
                            setTimeout(function(){
                                $('#formArea').modal('hide');
                            }, 2000);
                            $('#area_table').DataTable().ajax.reload();
                            setTimeout(function(){
                                $('#form_result').empty(); 
                            }, 2000); 
                        }
                        $('#form_result').html(html);
                    }
                });
            }
        });

        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                url: "{{ route('edit_area', ['id' => '_id_']) }}".replace('_id_', id),
                dataType: "json",
                success: function(html){
                    $('#Type').val(html.data.Type).trigger('change');
                    $('#RegionId').val(html.data.RegionId).trigger('change');
                    $('#Name').val(html.data.Name);
                    $('#Description').val(html.data.Description);
                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text("Edit Region");
                    $('#action_button').val("Update");
                    $('#action').val("Edit");
                    
                    var type = html.data.Type;
                    $('#Type').val(type).trigger('change');
                    
                    $('#formArea').modal('show');
                }
            });
        });

        var area_id;
        $(document).on('click', '.delete', function(){
            area_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text("Delete Area");
        });    

        $('#delete_area').click(function(){
            $.ajax({
                url: "{{ url('delete_area') }}/" + area_id, 
                method: "GET",
                beforeSend:function(){
                    $('#delete_area').text('Deleting...');
                },
                success:function(data)
                {
                    setTimeout(function(){
                        $('#confirmModal').modal('hide');
                        $('#area_table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });
    });
</script>
@endsection 