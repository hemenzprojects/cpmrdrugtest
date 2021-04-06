
                        <div class="row">
                            <div class="col-lg-10 col-md-10"><h6>B. {{\App\PhytoTestConducted::find(2)->name}}</h6></div> 
                            @if ($product->phyto_hod_evaluation === Null || $product->phyto_hod_evaluation === 1)
                            <div class="col-lg-1 col-md-10" style="margin: 1%"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong">Add</button></div>  
                            @endif
                            @if ( (App\Admin::find(Auth::guard("admin")->id())->dept_office_id == 1) && ($product->phyto_hod_evaluation === 0))
                            <div class="col-lg-1 col-md-10" style="margin: 1%"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong">Add</button></div>  
                            @endif
                        </div>
                        <table class="table table-inverse" >                      
                        <tbody>
                              @for ($i = 0; $i < count($phyto_physicochreport); $i++)
                                 
                                <tr>
                                  {{-- <th>
                                    <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select_all_child" checked>
                                    <span class="custom-control-label">&nbsp;</span>
                                    </label>
                                  </th> --}}
                                  <th style="display: none">
                                    <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select_all_child"  name="physicochemdata_id[]" value="{{$phyto_physicochreport[$i]->id}}" checked>
                                    <span class="custom-control-label">&nbsp;</span>
                                    </label>
                                  </th>
                                
                                <td class="font" style="">
                                  <strong>{{$phyto_physicochreport[$i]->name}}
                                :</strong>
                                </td>
                                <input type="hidden" name="physicochemname[]" value="{{$phyto_physicochreport[$i]->name}} ">
                                <td style="color:" class="font">
                                  
                                    <input class="form-control" type="text" name="physicochemresult[]" value="{{$phyto_physicochreport[$i]->result}}">
                                </td>
                                
                                <td class="font" style="">
                            
                                <input class="form-control" type="text" name="physicochemunit[]" value="{{$phyto_physicochreport[$i]->unit}}" {{$phyto_physicochreport[$i]->location == 1 ? "readonly" : "" }}>

                                </td>
                                <td class="font" style="font-size:13px">
                                  
                                   @if ($phyto_physicochreport[$i]->location == 1)
                                   <p>{{$phyto_physicochreport[$i]->result}}  &deg; {{$phyto_physicochreport[$i]->unit}}  </p>        
                                  @else
                                  {{$phyto_physicochreport[$i]->result}}  {{$phyto_physicochreport[$i]->unit}}
                                  @endif
                                </td>
                                </a> 
                                <td>
                                  <select name="physicochemroworder[]">
                                    @foreach ($phyto_physicochemdata as $item)
                                    <option value="{{$item->id}}" {{$item->id == $phyto_physicochreport[$i]->roworder ? "selected":""}}>Row {{$item->id}}</option>
                                    @endforeach
                                 </select>
                                </td>

                                <td >
                                   @if ($product->phyto_hod_evaluation ===Null || $product->phyto_hod_evaluation === 1)

                                  <a onclick="return confirm('Please confrim before deleting row')" href="{{url('admin/phyto/makereport/physicochemdata/delete',['p_id' => $phyto_physicochreport[$i]->product_id, 'physico_id' => $phyto_physicochreport[$i]->id])}}">
                                    <button type="button" name="remove" class="btn btn-danger btn_remove">X</button> 
                                    @endif
                                    @if ( (App\Admin::find(Auth::guard("admin")->id())->dept_office_id == 1) && ($product->phyto_hod_evaluation === 0))
                                  <a onclick="return confirm('Please confrim before deleting row')" href="{{url('admin/phyto/makereport/physicochemdata/delete',['p_id' => $phyto_physicochreport[$i]->product_id, 'physico_id' => $phyto_physicochreport[$i]->id])}}">
                                    <button type="button" name="remove" class="btn btn-danger btn_remove">X</button> 
                                    @endif
                                </td>
                             

                            </tr>        

                            @endfor
                        </tbody>
                        </table>  