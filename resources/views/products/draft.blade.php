@extends('layouts.header')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between align-items-center">
                Product List (Draft)
            <button type="button" class="btn btn-md btn-primary" name="add_product" id="add_product">Add Product</button>
            </h4>
            <table class="table table-striped table-hover" id="draft_table" width="100%">
                <thead>
                    <tr>
                        <th width="25%">DDW Number</th>
                        <th width="25%">Code</th>
                        <th width="25%">Created By</th>
                        <th width="15%">Date Created</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="formProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_product" enctype="multipart/form-data" action="">
                    <span id="form_result"></span>
                    @csrf
                    <div class="form-group">
                        <label for="name">DDW Number</label>
                        <input type="text" class="form-control" id="ddw_number" name="ddw_number" placeholder="Enter DDW Number">
                    </div>
                    <div class="form-group">
                        <label for="name">Product Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Enter Product Code">
                    </div>
                    <div class="form-group">
                        <label for="name">Reference Number</label>
                        <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="Enter Reference Number">
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control js-example-basic-single" name="type" id="type" style="position: relative !important" title="Select Type">
                            <option value="" disabled selected>Select Type</option>
                            <option value="1">Pure</option>
                            <option value="2">Blend</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Application</label>
                        <select class="form-control js-example-basic-single" name="application_id" id="application_id" style="position: relative !important" title="Select Application">
                            <option value="" disabled selected>Select Application</option>
                            @foreach($product_applications as $product_application)
                                <option value="{{ $product_application->id }}">{{ $product_application->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Application Subcategory</label>
                        <select class="form-control js-example-basic-single" name="application_subcategory_id" id="application_subcategory_id" style="position: relative !important" title="Select Subcategory">
                            <option value="" disabled selected>Select Subcategory</option>
                            @foreach($product_subcategories as $product_subcategory)
                                <option value="{{ $product_subcategory->id }}">{{ $product_subcategory->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Product Origin</label>
                        <input type="text" class="form-control" id="product_origin" name="product_origin" placeholder="Enter Product Origin">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> 

<script>
    $(document).ready(function(){
        $('#draft_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('product.draft') }}"
            },
            columns: [
                {
                    data: 'ddw_number',
                    name: 'ddw_number'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'user_full_name',
                    name: 'user_full_name'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return moment(data).format('YYYY-MM-DD'); // Format as desired
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ],
            columnDefs: [
                {
                    targets: [0, 1, 2, 3], // Target the column
                    render: function(data, type, row) {
                        return '<div style="white-space: break-spaces; width: 100%;">' + data + '</div>';
                    }
                }
            ]
        });

        $('#add_product').click(function(){
            $('#formProduct').modal('show');
            $('.modal-title').text("Add New Product");
        });

        $('#form_product').on('submit', function(event){
            event.preventDefault();
            if($('#action').val() == 'Save')
            {
                $.ajax({
                    url: "{{ route('product.store') }}",
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
                            $('#form_product')[0].reset();
                            setTimeout(function(){
                                $('#formProduct').modal('hide');
                            }, 2000);
                            $('#draft_table').DataTable().ajax.reload();
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
                    url: "{{ route('update_product', ':id') }}".replace(':id', $('#hidden_id').val()),
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
                            $('#form_product')[0].reset();
                            setTimeout(function(){
                                $('#formProduct').modal('hide');
                            }, 2000);
                            $('#draft_table').DataTable().ajax.reload();
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
                url: "{{ route('edit_product', ['id' => '_id_']) }}".replace('_id_', id),
                dataType: "json",
                success: function(html){
                    $('#ddw_number').val(html.data.ddw_number);
                    $('#code').val(html.data.code);
                    $('#reference_no').val(html.data.reference_no);
                    $('#type').val(html.data.type).trigger('change');
                    $('#application_id').val(html.data.application_id).trigger('change');
                    $('#application_subcategory_id').val(html.data.application_subcategory_id).trigger('change');
                    $('#product_origin').val(html.data.product_origin);
                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text("Edit Product");
                    $('#action_button').val("Update");
                    $('#action').val("Edit");
                    $('#formProduct').modal('show');
                }
            });
        });
    });
</script>
@endsection