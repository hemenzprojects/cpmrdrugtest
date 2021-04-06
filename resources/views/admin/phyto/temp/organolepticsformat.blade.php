<div class="row">
    <div class="col-lg-10 col-md-10">
        <h6>A. {{\App\PhytoTestConducted::find(1)->name}}</h6>
    </div> 

    @if ($product->phyto_hod_evaluation ===Null || $product->phyto_hod_evaluation === 1)
    <div class="col-lg-1 col-md-10" style="margin: 1%">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#demoModal">Add</button>
    </div>
    @endif
    @if ( (App\Admin::find(Auth::guard("admin")->id())->dept_office_id == 1) && ($product->phyto_hod_evaluation === 0))
    <div class="col-lg-1 col-md-10" style="margin: 1%">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#demoModal">Add</button>
    </div>
    @endif      
</div>

<table class="table table-inverse">                      
    <tbody>
        @foreach ($phyto_organolepticsreport as $organo_item)

        <tr>
             
            {{-- <th>
            <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input select_all_child" checked>
            <span class="custom-control-label">&nbsp;</span>
            </label>
            </th> --}}
            <th style="display: none">
                <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input select_all_child" name="organoleptics_id[]" value="{{$organo_item->id}}" checked>
                <span class="custom-control-label">&nbsp;</span>
                </label>
            </th>
        
            <td class="font">
                <strong>{{$organo_item->name}}</strong>
                <input type="hidden" class="form-control" name="organolepticsname[]" value="{{$organo_item->name}}"> 
            </td>
           

            <td class="font">
                <input class="form-control" type="text" name="organolepticsfeature[] " value="{{$organo_item->feature}}">
            </td>
            <td class="font">
                <select name="organolepticsroworder[]">
                    @foreach ($phyto_organoleptics as $item)
                    <option value="{{$item->id}}" {{$item->id == $organo_item->roworder ? "selected":""}}>Row {{$item->id}}</option>
                    @endforeach
                 </select>
            </td>
            @if ($product->phyto_hod_evaluation ===Null || $product->phyto_hod_evaluation === 1)
                <td > 
                <a onclick="return confirm('Please confrim before deleting row')" href="{{url('admin/phyto/makereport/organoleptics/delete',['p_id' => $report_id, 'organo_id' => $organo_item->id ])}}">
                <button type="button" name="remove" class="btn btn-danger btn_remove">X</button>
                </a> 
                </td>
            @endif
            @if ( (App\Admin::find(Auth::guard("admin")->id())->dept_office_id == 1) && ($product->phyto_hod_evaluation === 0))
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