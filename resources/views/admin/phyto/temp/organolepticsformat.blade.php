<div class="row">
    <div class="col-lg-10 col-md-10">
        <h6>A. {{\App\PhytoTestConducted::find(1)->name}}</h6>
    </div> 
    @if ($product->phyto_hod_evaluation ===Null || $product->phyto_hod_evaluation === 1)
    <div class="col-lg-1 col-md-10" style="margin: 1%">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#demoModal">Add</button>
    </div>
    @endif    
</div>

<table class="table table-inverse">                      
    <tbody>
        @foreach ($phyto_organolepticsreport as $organo_item)

        <tr>
        
            @if ($product->phyto_hod_evaluation ===Null || $product->phyto_hod_evaluation === 1)
            <th>
            <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input select_all_child" checked>
            <span class="custom-control-label">&nbsp;</span>
            </label>
            </th>
            <th style="display: none">
                <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input select_all_child" name="organoleptics_id[]" value="{{$organo_item->id}}" checked>
                <span class="custom-control-label">&nbsp;</span>
                </label>
            </th>
            @endif
        
            <td class="font" style="width: 300px"><strong> {{$organo_item->name}} :</strong></td>
            <input type="hidden" name="organolepticsname[]" value="{{$organo_item->name}}">

            <td class="font"><input class="form-control" type="text" name="organolepticsfeature[] " value="{{$organo_item->feature}}"></td>
            @if ($product->phyto_hod_evaluation === Null || $product->phyto_hod_evaluation === 1)
                <td > 
                <a onclick="return confirm('Please confrim before deleting row')" href="{{url('admin/phyto/makereport/organoleptics/delete',['p_id' => $report_id, 'organo_id' => $organo_item->id ])}}">
                <button type="button" name="remove" class="btn btn-danger btn_remove">X</button>
                </a> 
                </td>
            @endif
        </tr>   
            
        @endforeach
    </tbody>
    </table>