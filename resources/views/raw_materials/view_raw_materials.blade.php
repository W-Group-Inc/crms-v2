<div class="modal fade" id="viewProducts-{{$rm->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Products</h5>
            </div>
            <div class="modal-body">
                <h4><strong>Material: </strong>{{ $rm->Name }}</h4>
                <h4><strong>Description: </strong> {{$rm->Description}}</h4>

                <table class="table-bordered table-hover table-striped table mt-5 view_raw_materials_table">
                    <thead>
                        <tr>
                            <th>Products</th>
                            <th>Percentage (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($rm->productMaterialCompositions))
                            @foreach ($rm->productMaterialCompositions as $pmc)
                                <tr>
                                    <td>{{$pmc->products->code}}</td>
                                    <td>{{$pmc->Percentage}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2">No data available.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>