<div class="card">
    <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4>
    <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <td class="font"> <strong>Name of Product:</strong></td>
                    <td class="font">
                        {{$product->code}} 
                    </td>
                </tr>
                <tr>
                <td class="font"><strong>Date Received:</strong></td>
                    <td class="font">
                        {!! $product->pharm_date_received !!}  
                        <input class="form-control" required="required" type="date" placeholder="Date" name="date_received" value="{{($product->departmentById(2)->pivot->received_at)}}" style="width:250px">                                     
                                                            
                    </td>
                </tr>
                <tr>                                    

                    <td class="font"><strong>Date Analysed:</strong></td> 
                    <td class="font">
                        <div>
                            {!! $product->pharm_analysed_date !!}
                        <input type="date" class="form-control" name="date_analysed" value="{{$product->pharm_dateanalysed}}" placeholder=" {{Carbon\Carbon::parse($product['pharm_dateanalysed'])->format('d/m/Y')}}" style="width:250px">
                        </div>
                     {{-- <input class="form-control" required type="date" name="date_analysed" data-date-format="DD-MM-YYYY"  style="width:250px"> --}}
                    </td>
                </tr>
                <tr>
                    <td class="font"><strong>Test Conducted </strong></td>
                    <td class="font">{{\App\PharmTestConducted::find($product->pharm_testconducted)->name}} </td>
                    <input type="hidden" id="pharm_test_conducted" name="pharm_testconducted"  value="{{\App\PharmTestConducted::find($pharmreports->pharm_testconducted)->id}}">  
                </tr>
                <tr>
                    {{-- <td class="font"><strong>Additional Test Conducted</strong></td>
                    <td>
                        <div class="row">
                            @if ($product->pharm_additional_testconducted==Null)
                            <div class="col-sm-6">
                               
                                <label class="custom-control custom-checkbox" style="margin-top:5px">
                                    <input type="checkbox" class="custom-control-input" name="additional_testcheck" id="additional_test_id" value="4">
                                    <span class="custom-control-label" style="color:#ff">&nbsp;Check to add new test type</span>
                                </label>
                            </div>
                            @endif
                            <div class="col-sm-6 4" style="{{$product->pharm_additional_testconducted?\App\Admin::find($product->pharm_additional_testconducted):'display:none'}}"> 
                                <input type="text" id="additional_testtype_id" name="additional_testtype" value="{{$product->pharm_additional_testconducted}}" placeholder="Additional Test type">

                            </div>
                        </div>
                    </td> --}}


                   
                                            
                </tr>
            </tbody>
        </table>
    </div>
</div>