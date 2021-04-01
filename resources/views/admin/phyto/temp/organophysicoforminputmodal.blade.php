<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
                
                <div class="modal-content" style="width: 140%">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongLabel">B. {{\App\PhytoTestConducted::find(2)->name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{url('admin/phyto/makereport/physicochemdata/update')}}" method="post">
                            {{ csrf_field() }}                 
                            <table class="table table-inverse">                      
                                <tbody>
                                    @foreach ($phyto_physicochemdata->except($physicochemdata_ids) as $physicochem_item)
                                    <tr>
                                        <input type="hidden" name="product_id" value="{{$product->id}}">

                                        <input type="hidden" name="phyto_testconducted_2" value="{{\App\PhytoTestConducted::find(2)->id}}">
                                    <th>
                                        <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input select_all_child" name="physicochemdata_id[]" value="{{$physicochem_item->id}}">
                                        <span class="custom-control-label">&nbsp;</span>
                                        </label>
                                    </th>
                                    <td class="font">
                                        {{-- <p class="physicochem_{{$physicochem_item->id}}">{{$physicochem_item->name}}</p> --}}
                                        <input type="text" class="form-control" name="physicochemname_{{$physicochem_item->id}}" value="{{$physicochem_item->name}}">
                                    </td>
                                    <td class="font">
                                        <input type="hidden" name="physicochemdata_location_{{$physicochem_item->id}}" value="{{$physicochem_item->location}}">

                                        <input class="form-control" type="text" name="physicochemresult_{{$physicochem_item->id}}" value="{{$physicochem_item->result}}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="physicochemunit_{{$physicochem_item->id}}" value="{{$physicochem_item->unit}}"  {{$physicochem_item->location == 1 ? "readonly" : "" }}>
                                    </td>
                                    <td>
                                        <select name="physicochemdata_roworder_{{$physicochem_item->id}}" id="">
                                            @foreach ($phyto_physicochemdata->except($physicochemdata_roworder) as $item)
                                            <option value="{{$item->id}}">Row {{$item->id}}</option>
                                            @endforeach
                                       </select>
                                    </td>
                                    </tr>        
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form> 
                    </div>
                    
        
                    </div>
                    
    </div>
</div>
<div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"><h6>A. {{\App\PhytoTestConducted::find(1)->name}}</h6></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            
                    <div class="modal-body">
                        <form action="{{url('admin/phyto/makereport/organoleptics/update')}}" method="post">
                            {{ csrf_field() }} 
                            <table class="table table-inverse">                      
                                <tbody>
                                    
                                    @foreach ($phyto_organoleptics->except($organoleptics_ids) as $organo_item)
                                    <tr>
                                        <input type="hidden" name="product_id" value="{{$product->id}}">

                                        <input type="hidden" name="phyto_testconducted_1" value="{{\App\PhytoTestConducted::find(1)->id}}">
                                    <th>
                                        <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input select_all_child"  name="organoleptics_id[]" value="{{$organo_item->id}}">
                                        <span class="custom-control-label">&nbsp;</span>
                                        </label>
                                    </th>
                                    <td class="font">{{$organo_item->name}} :</td>
                                    <input type="hidden" name="organolepticsname_{{$organo_item->id}}" value="{{$organo_item->name}}">
        
                                    <td class="font"><input class="form-control" type="text" name="organolepticsfeature_{{$organo_item->id}}" value="{{$organo_item->feature}}"></td>
                                    </tr>        
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            
                        </form>
                    </div>
            
        
        </div>
    </div>
</div>