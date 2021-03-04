@extends('admin.layout.main')

@section('content')
@php
   $product = \App\Product::find($pharmreports->id);
@endphp
<div class="container-fluid">
     <div class="card" style="padding: 15px">
          <div class="text-center"> 
            <img src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
            <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
            <p class="card-subtitle">Pharmacology & Toxicology Department</p>
           </div>
     <form action="{{url('admin/pharm/report/create',['id' => $pharmreports->id])}}" method="post">
        {{ csrf_field() }} 
        <div class="card">
            <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="font"> <strong>Name of Product:</strong></td>
                            <td class="font">
                                {{$pharmreports->code}} 
                            </td>
                        </tr>
                        <tr>
                        <td class="font"><strong>Date Recievied:</strong></td>
                            <td class="font">
                                @foreach (\App\ProductDept::where('product_id',$pharmreports->id)->where('dept_id',2)->get() as $item)
                                {{$item->updated_at->format('d/m/Y')}}
                                @endforeach
                            </td>
                        </tr>
                        <tr>                                    

                            <td class="font"><strong>Date of Report:</strong></td> 
                            <td class="font">
                                <div>
                                   
                                <input type="text" class="form-control datetimepicker-input" name="date_analysed" data-date-format="DD-MM-YYYY" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker" value="" placeholder=" {{Carbon\Carbon::parse($pharmreports['pharm_dateanalysed'])->format('d/m/Y')}}" style="width:250px">

                                </div>
                             {{-- <input class="form-control" required type="date" name="date_analysed" data-date-format="DD-MM-YYYY"  style="width:250px"> --}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font"><strong>Test Conducted</strong></td>
                            <td class="font">{{\App\PharmTestConducted::find($pharmreports->pharm_testconducted)->name}}</td>
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
        @if ($pharmreports->pharm_testconducted ==1)
        <div class="card">
        <div class="row">
            <div class="col-md-7">
 
       @include('admin.pharm.temp.finalreportform')
    
        <div class="" style="padding: 2%">

        <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"> <strong>REMARKS: </strong></h4>
        @if ( $product->pharm_comment !== Null)
        <textarea  style="font-size: 14.8px; text-align: justify " class="form-control" rows="8" name="pharm_comment" >{{$pharmreports->pharm_comment}}
        </textarea>
        @endif
        @if ( $product->pharm_comment === Null)
        <textarea style="font-size: 14.8px text-align: justify " class="form-control" rows="7" name="pharm_comment" > LD/50 is estimated to be greater than 5000 mg/kg which is greater or equal to the level 5 on the Hodge and Sterner Scale (1) and also 93 times more than the recommended dose (two tablespoonful thrice daily equivalent to 53.63 mg/kg), as indicated by the manufacturer. Thus, (P-CODE)  may not be toxic and is within the accepted margin of safety (Hodge and Stoermer Scale) at the recommended dose.
        </textarea> 
        @endif
        </div> 
        </div>

                <div class="col-md-5" style="background-color:">
                    <div class="card-body">
                        @include('admin.pharm.temp.acuteanimalexpreport') 
                    </div>
                </div>
         </div>
            
       
        </div>
        @endif
      
       @if ($pharmreports->pharm_testconducted ==2)
     <div class="row">
         <div class="col-md-7">
          <div class="card" style="padding: 2%">
            @if ( $product->pharm_standard !== Null )
                <textarea style="font-size: 16px" class="form-control" rows="10" name="pharm_standard" >{{$pharmreports->pharm_standard}}
                </textarea> 
            @endif

            @if ( $product->pharm_standard === Null)
            <textarea name="pharm_standard" class="form-control" style="font-size: 16px" cols="30" rows="6">{{\App\PharmStandards::find($pharmreports->productType->pharm_standard_id)? \App\PharmStandards::find($pharmreports->productType->pharm_standard_id)->default:'' }} </textarea>
            @endif

            <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> RESULTS: </strong></h4>
                 @if ($pharmreports->pharm_result ===Null)
                 <textarea class="form-control" style="font-size: 16px"name="pharm_result" rows="10">Experimental (Animal Model) in groups 1 and 2 that received 0.1ml (Route of administration) of the (product type) dissolved in glycerol at 1% and 5% w/v respectively, showed  at the site of injection. This indicates that even at a high level of 5% w/v the (product type) did not appear to cause erythemia to the skin of the animal. A similar observation was made for the topical application.</textarea> 
                 @endif
                 @if ($pharmreports->pharm_result !== Null)
                <textarea style="font-size: 16px" class="form-control" rows="10" name="pharm_result" >{{$pharmreports->pharm_result}}
                </textarea> 
                @endif
            </div>       
                <div class="card" style="padding: 2%">
                    
                        <h4 class="font" style="font-size:18px margin:20px; margin-top:15px"> <strong>REMARKS: </strong></h4>
                        @if ( $product->pharm_comment !== Null)
                        <textarea  style="font-size: 16px text-align: justify " class="form-control" rows="4" name="pharm_comment" >{{$pharmreports->pharm_comment}}
                        </textarea> 
                        @endif
                        @if ( $product->pharm_comment === Null)
                        <textarea style="font-size: 16px text-align: justify " class="form-control" rows="4" name="pharm_comment" >
                             {{$pharmreports->code}} appears to be safe / not safe when applied to the skin.
                        </textarea> 
                        @endif
                    
                </div>
            </div> 
            <div class="col-md-5" >
                <div class="card-body">
                    @include('admin.pharm.temp.dermalanimalexpreport') 
                </div>
            </div>
      </div> 
       @endif

        <div class="row">
            @if ( $product->pharm_hod_evaluation > 0)
            <div class="col-sm-8">
                <h4 class="font" style="font-size:15px; margin:20px; margin-top:15px"> <strong>HOD REMARKS: </strong></h4>
                <div class="alert alert-info" role="alert">
                    {{$pharmreports->pharm_hod_remarks}}
                  </div>
            </div>
            @endif
            <div class="col-sm-3" style="margin-top:30px">
             <div class="form-group">
                 <label for="exampleInputEmail3"> <strong><span style="color: red">Report Evaluation</span></strong>  </label>
                 <select name="pharm_grade" required class="form-control" id="exampleSelectGender">
                 <option value="{{ $product->pharm_grade}}">{!!  $product->pharm_grade_report !!}</option>
                     <option value="1">Failed</option>
                     <option value="2">Passed</option>
                 </select>                                
              </div>
         </div>
        </div>
     

       <div class="row" style="margin: 35px">
                <div class="col-sm-4 invoice-col">
                <?php
                 $pharm_appoved_by = ( $product?  $product->pharm_appoved_by:'');
                $hod_user_type = (\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->user_type_id:'');
                ?>
                <p>Analysed by</p><br>
                @if ( $product->pharm_hod_evaluation ==2)
                <img src="{{asset(\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->sign_url:'')}}" class="" width="42%"><br>
                @endif

                ------------------------------<br> 
            
            <span>{{ucfirst(\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->full_name:'')}}</span>
            <p>{{ucfirst(\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->position:'')}}</p>

            </div> 
            <div class="col-sm-4 invoice-col">
            
            </div>
            <div class="col-sm-4 invoice-col">
                <?php
             $pharm_finalappoved_by = ( $product?  $product->pharm_finalappoved_by:'');
            $user_type         = (\App\Admin::find($pharm_finalappoved_by)? \App\Admin::find($pharm_finalappoved_by)->user_type_id:'');
            ?>
            <p>Approved By</p><br>
            @if ( $product->pharm_finalappoved_by !== null)
            <img src="{{asset(\App\Admin::find($pharm_finalappoved_by)? \App\Admin::find($pharm_finalappoved_by)->sign_url:'')}}" class="" width="42%"><br>
            @endif
            -----------------------------<br>
        
            <span>{{ucfirst(\App\Admin::find($pharm_finalappoved_by)? \App\Admin::find($pharm_finalappoved_by)->full_name:'')}}</span>
            <p>{{ucfirst(\App\Admin::find($pharm_finalappoved_by)? \App\Admin::find($pharm_finalappoved_by)->position:'')}}</p>

            </div>
      </div>

        <div class="row" style="margin-top: 110px">
            <div class="col-9">
                <div class="row">
                   
                    <div class="col-sm-3">
                        @if ( $product->pharm_hod_evaluation ===Null ||  $product->pharm_hod_evaluation ===1 )
                        <button  type="submit" class="btn btn-success pull-right pharmsubmitreport1" id="pharm_submit_report" >
                        <i class="fa fa-credit-card "></i> 
                        Save Report
                        </button>
                        <button style="display: none" onclick="return confirm('NB: report will be submitted to the head of department. Click Ok to confirm report submission')" type="submit" class="btn btn-info pull-right pharmsubmitreport2" id="pharm_submit_report" >
                            <i class="fa fa-credit-card " ></i> 
                            Submit Report
                        </button>
                        @endif
                        @if ( $product->pharm_hod_evaluation ==2)
                        <button type="button" onclick="myFunction()" class="btn btn-primary pull-right" id="pharm_complete_report" style="margin-right: 5px;">
                        <i class="fa fa-view"></i> Print Report</button>
                        @endif
                    </div>
                    <div class="col-sm-9">
                        @if ( $product->pharm_hod_evaluation ===Null ||  $product->pharm_hod_evaluation ===1 )
                        <div class="form-check mx-sm-2">
                            <label class="custom-control custom-checkbox">
                                <input id="pharmsubmitreport" type="checkbox" name="complete_report" value="1" class="custom-control-input">
                                <span class="custom-control-label">&nbsp;Check to complete report </span>
                            </label>
                        </div>
                        @endif
                    </div>
                </div>
              
           
                {{-- <input type="hidden" id="report_url" value="{{url('admin/pharm/completedreport/show',['id' => $pharmreports->id])}}"> --}}
            
          </div>

            <div class="col-3">
                @if ( $product->pharm_hod_evaluation ===0)
                <button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>
                @endif
                @if ( $product->pharm_hod_evaluation ===1)
                <button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i> Report Withheld</button>
                @endif
                @if ( $product->pharm_hod_evaluation ===2)
                <button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>        
               @endif
                {{-- <input type="hidden" id="pharm_hod_evaluation" value="{{ $product->pharm_hod_evaluation}}"> --}}

            </div>
      </form>
    </div>
    </div>
</div>


@endsection

@section('bottom-scripts')
<script>
function myFunction() {
  var url = $('input[id="report_url"]').attr("value");
  var r = confirm("Be aware of the following before you complete report : 1.Completed Reports can not be edited after submision, system require you to see HoD for unavoidable complains or changes.  Thank you");
  if (r == true) {
  var  myWindow = window.open(url, "_blank", "width=1000, height=700");
  } else {
   
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>

@endsection