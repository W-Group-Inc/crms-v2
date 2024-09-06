<div class="modal fade" id="pdsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Add PDS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="POST" action="{{url('add_product_ds')}}" onsubmit="show()">
                {{csrf_field()}}
                
                <input type="hidden" name="product_id" value="{{$data->id}}">
                {{-- <input type="hidden" name="product_datasheet_id" value="{{$data->productDataSheet->Id}}"> --}}
                <div class="modal-body" style="padding: 20px">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            Product: {{$data->code}}
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Company :</label>
                            <select data-placeholder="Choose company" name="company" class="js-example-basic-single form-control form-control-sm">
                                <option value="">-Company-</option>
                                @foreach ($client as $c)
                                    <option value="{{$c->id}}" >{{$c->Name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Control Number :</label>
                            <input type="text" name="control_number" class="form-control form-control-sm" placeholder="Enter control number" required>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Date Issued :</label>
                            <input type="date" name="date_issued" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Description :</label>
                            <textarea name="description" class="form-control form-control-sm" cols="30" rows="10" placeholder="Enter description" required></textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Description 2:</label>
                            <textarea name="description2" class="form-control form-control-sm" cols="30" rows="10" placeholder="Enter description"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Appearance :</label>
                            <textarea name="appearance" class="form-control form-control-sm" cols="30" rows="10" placeholder="Enter appearance"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Application :</label>
                            <textarea name="application" class="form-control form-control-sm" cols="30" rows="10" placeholder="Enter application"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="mb-3">
                                <button class="btn btn-sm btn-success addPotentialBenefit" type="button">
                                    <i class="ti-plus"></i>
                                </button>
                                {{-- <button class="btn btn-sm btn-danger removePotentialBenefit" type="button">
                                    <i class="ti-minus"></i>
                                </button> --}}
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label>Potential Benefits :</label>
                                    <div class="potentialBenefitContainer">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="mb-3">
                                <button class="btn btn-sm btn-success addPca" type="button">
                                    <i class="ti-plus"></i>
                                </button>
                                {{-- <button class="btn btn-sm btn-danger removePca" type="button">
                                    <i class="ti-minus"></i>
                                </button> --}}
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label>Physico Chemical Analyses :</label>
                                    <div class="pcaContainer">
                                        {{-- @foreach ($data->productDataSheet->productPhysicoChemicalAnalyses as $pca)
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input type="text" name="pcaParameter[]" placeholder="Enter parameter" class="form-control form-control-sm mb-2" value="{{$pca->Parameter}}">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" name="pcaValue[]" placeholder="Enter value" class="form-control form-control-sm mb-2" value="{{$pca->Value}}">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" name="pcaRemark[]" placeholder="Enter remark" class="form-control form-control-sm mb-2" value="{{$pca->Remarks}}">
                                                </div>
                                            </div>
                                        @endforeach --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="mb-3">
                                <button class="btn btn-sm btn-success addMa" type="button">
                                    <i class="ti-plus"></i>
                                </button>
                                {{-- <button class="btn btn-sm btn-danger removeMa" type="button">
                                    <i class="ti-minus"></i>
                                </button> --}}
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label>Microbiological Analyses :</label>
                                    <div class="maContainer">
                                        {{-- @foreach ($data->productDataSheet->productMicrobiologicalAnalysis as $ma)
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input type="text" name="maParameter[]" placeholder="Enter parameter" class="form-control form-control-sm mb-2" value="{{$ma->Parameter}}">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" name="maValue[]" placeholder="Enter value" class="form-control form-control-sm mb-2" value="{{$ma->Value}}">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" name="maRemark[]" placeholder="Enter remark" class="form-control form-control-sm mb-2" value="{{$ma->Remarks}}">
                                                </div>
                                            </div>
                                        @endforeach --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="mb-3">
                                <button class="btn btn-sm btn-success addHeavyMetals" type="button">
                                    <i class="ti-plus"></i>
                                </button>
                                {{-- <button class="btn btn-sm btn-danger removeHeavyMetals" type="button">
                                    <i class="ti-minus"></i>
                                </button> --}}
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label>Heavy Metals :</label>
                                    <div class="heavyMetalsContainer">
                                        {{-- @foreach ($data->productDataSheet->productHeavyMetal as $heavyMetals)
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input type="text" name="heavyMetalsParameter[]" placeholder="Enter parameter" class="form-control form-control-sm mb-2" value="{{$heavyMetals->Parameter}}">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" name="heavyMetalsValue[]" placeholder="Enter value" class="form-control form-control-sm mb-2" value="{{$heavyMetals->Value}}">
                                                </div>
                                            </div>
                                        @endforeach --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="mb-3">
                                <button class="btn btn-sm btn-success addNutritionalInfo" type="button">
                                    <i class="ti-plus"></i>
                                </button>
                                {{-- <button class="btn btn-sm btn-danger removeNutritionalInfo" type="button">
                                    <i class="ti-minus"></i>
                                </button> --}}
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label>Nutritional Information :</label>
                                    <div class="nutrionalInfoContainer">
                                        {{-- @foreach ($data->productDataSheet->productNutritionalInformation as $nutrionalInfo)
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input type="text" name="nutrionalInfoParameter[]" placeholder="Enter parameter" class="form-control form-control-sm mb-2" value="{{$nutrionalInfo->Parameter}}">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text" name="nutrionalInfoValue[]" placeholder="Enter value" class="form-control form-control-sm mb-2" value="{{$nutrionalInfo->Value}}">
                                                </div>
                                            </div>
                                        @endforeach --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="mb-3">
                                <button class="btn btn-sm btn-success addAllergens" type="button">
                                    <i class="ti-plus"></i>
                                </button>
                                {{-- <button class="btn btn-sm btn-danger removeAllergens" type="button">
                                    <i class="ti-minus"></i>
                                </button> --}}
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label>Allergens :</label>
                                    <div class="allergensContainer">
                                        {{-- @foreach ($data->productDataSheet->productAllergens as $allergens)
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input type="text" name="allergensParameter[]" placeholder="Enter parameter" class="form-control form-control-sm mb-2" value="{{$allergens->Parameter}}">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="checkbox" name="isAllergen[]" class="form-control form-control-sm" @if($allergens->IsAllergen == 1)checked @endif>
                                                </div>
                                            </div>
                                        @endforeach --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Direction for use :</label>
                            <textarea name="direction_for_use" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Storage :</label>
                            <textarea name="storage" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Technical Assistance :</label>
                            <textarea name="technical_assistance" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Purity and Legal Status :</label>
                            <textarea name="purity_and_legal_status" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Packaging :</label>
                            <textarea name="packaging" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>Certifications :</label>
                            <textarea name="certifications" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 0.6875rem">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="yes_button" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>