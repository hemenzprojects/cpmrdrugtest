
                        <div class="row">
                            <div class="col-lg-10 col-md-10"><h6>B. {{\App\PhytoTestConducted::find(2)->name}}</h6></div> 
                            @if ($product->phyto_hod_evaluation <2)
                            <div class="col-lg-1 col-md-10" style="margin: 1%"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong">Add</button></div>  
                            @endif
                          
                        </div>
                        <table class="table table-inverse">                      
                        <tbody>
                              @for ($i = 0; $i < count($phyto_physicochreport); $i++)
                                 
                                <tr>
                                 @if ($product->phyto_hod_evaluation <2)
                                  <th>
                                    <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select_all_child" id="" name="physicochemdata_id[]" value="{{$phyto_physicochreport[$i]->id}}" checked>
                                    <span class="custom-control-label">&nbsp;</span>
                                    </label>
                                  </th>
                                @endif
                                <td class="font" style="width: 300px"><strong>{{$phyto_physicochreport[$i]->name}} :</strong></td>
                                <input type="hidden" name="physicochemname[]" value="{{$phyto_physicochreport[$i]->name}}">
                                <td style="color: " class="font">
                                    <?php
                                    if ($phyto_physicochreport[$i]->location == 3) {
                                     $result = explode(' ',$phyto_physicochreport[$i]->result);
                    
                                    print_r($result[0]); echo ' ';  print_r($result[1]); echo ' '; print_r($result[2]);  echo ' ';  echo '<sup>';  print_r($result[3]); echo '</sup>'; print_r($result[4]);
                                    } 
                                  ?>
                                    <input class="form-control" type="text" name="physicochemresult[]" value="{{$phyto_physicochreport[$i]->result}}">
                                </td>
                                
                                @if ($product->phyto_hod_evaluation <2)
                                </a> 
                                <td >
                                    <a onclick="return confirm('Please confrim before deleting row')" href="{{url('admin/phyto/makereport/physicochemdata/delete',['p_id' => $phyto_physicochreport[$i]->product_id, 'physico_id' => $phyto_physicochreport[$i]->id])}}">
                                    <button type="button" name="remove" class="btn btn-danger btn_remove">X</button>
                                </td>
                                @endif

                            </tr>        

                            @endfor
                        </tbody>
                        </table>  