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
                <td class="font"><strong>Date Recievied:</strong></td>
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
                    <td class="font"><strong>Test Conducted</strong></td>
                    <td class="font">{{\App\PharmTestConducted::find($product->pharm_testconducted)->name}}</td>
                    <input type="hidden" id="pharm_test_conducted" name="pharm_testconducted"  value="{{\App\PharmTestConducted::find($pharmreports->pharm_testconducted)->id}}">  
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>