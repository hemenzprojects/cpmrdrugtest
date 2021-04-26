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
                        {{ $product->departmentById(1)->pivot->updated_at->format(' F j,  Y') }}                                        
                    </td>
                </tr>
                <tr>                                    

                    <td class="font"><strong>Date of Report:</strong></td> 
                    <td class="font">
                        <div>
                           
                        <input type="text" class="form-control datetimepicker-input" name="date_analysed" data-date-format="DD-MM-YYYY" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker" value="" placeholder=" {{Carbon\Carbon::parse($product['pharm_dateanalysed'])->format('d/m/Y')}}" style="width:250px">

                        </div>
                     {{-- <input class="form-control" required type="date" name="date_analysed" data-date-format="DD-MM-YYYY"  style="width:250px"> --}}
                    </td>
                </tr>
                <tr>
                    <td class="font"><strong>Test Conducted</strong></td>
                    <td class="font">{{\App\PharmTestConducted::find($product->pharm_testconducted)->name}}</td>
                    <input type="hidden" id="pharm_test_conducted" value="{{\App\PharmTestConducted::find($pharmreports->pharm_testconducted)->id}}">  
                    
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>