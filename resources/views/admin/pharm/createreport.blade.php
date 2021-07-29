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
     <form action="{{url('admin/pharm/report/create',['id' => $product->id])}}" method="post">
        {{ csrf_field() }} 
        @include('admin.pharm.temp.productformat') 

        @if ($pharmreports->pharm_testconducted ==1  || $pharmreports->pharm_testconducted ==3)
        <div class="card">
        <div class="row">
            <div class="col-md-7">
 
       @include('admin.pharm.temp.finalreportform')
        
        <div class="" style="padding: 2%">

        <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"> <strong>REMARKS: </strong></h4>
        @if ( $product->pharm_acute_comment !== Null)
        <textarea id="tinymce"  style="font-size: 14.8px; text-align: justify " class="form-control" rows="8" name="pharm_acute_comment" >{{$pharmreports->pharm_acute_comment}}
        </textarea>
        @endif
        @if ( $product->pharm_acute_comment === Null)
        <textarea id="tinymce1" style="font-size: 14.8px text-align: justify " class="form-control" rows="7" name="pharm_acute_comment" > <p style="text-align: justify;"><span style="font-size: 12pt;"> The LD<sub>50</sub> is estimated to be greater than 5000 mg/kg which is greater or equal to level 5 on the Hodge and Sterner Scale<sup>1</sup> and also 93 times more than the recommended dose ({{$pharmreports->dosage}} equivalent to 5.0 mg/kg ), as indicated by the manufacturer. Thus, {{$pharmreports->code}}  may not be toxic and is within the accepted margin of safety (Hodge and Sterner Scale) at the recommended dose. </span> </p></textarea> 
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
      
       @if ($pharmreports->pharm_testconducted ==2 || $pharmreports->pharm_testconducted ==3)
     <div class="row">
         <div class="col-md-7">
          <div class="card" style="padding: 2%">
            @if ( $product->pharm_standard !== Null )
                <textarea id="tinymce"  style="font-size: 16px" class="form-control" rows="10" name="pharm_standard" >{!! $pharmreports->pharm_standard !!}
                </textarea> 
            @endif

            @if ( $product->pharm_standard === Null)
            <textarea id="tinymce1" name="pharm_standard" class="form-control" style="font-size: 16px" cols="30" rows="6"><p style="text-align: justify;"><span style="font-size: 12pt;"> {{\App\PharmStandards::find($pharmreports->productType->pharm_standard_id)? \App\PharmStandards::find($pharmreports->productType->pharm_standard_id)->default:'' }} </span></p></textarea>
            @endif
 
               <h4 class="font" style="font-size:18px margin:20px; margin-top:15px"> <strong>RESULT: </strong></h4>
               @if ($pharmreports->pharm_result ===Null)
                 <textarea id="tinymce2" class="form-control" style="font-size: 16px"name="pharm_result" rows="10"> <p style="text-align: justify;"><span style="font-size: 12pt;"> The experimental @foreach ($pharmreports->animalExperiment->unique('animal_model') as $item){{App\PharmAnimalModel::find($item->animal_model)->name}} @endforeach in group 1 and 2 administered with 1% and 5% w/v of the {{$pharmreports->productType->name}} intradermally and topically (0.5-1 g), showed no ulceration, irritation and/or inflammations at the site of injection and shaved area, respectively.</span></p></textarea> 
                 @endif                                                                                               
                 @if ($pharmreports->pharm_result !== Null)
                <textarea id="tinymce3" style="font-size: 16px" class="form-control" rows="10" name="pharm_result" >{{$pharmreports->pharm_result}}
                </textarea> 
                @endif
           
                    
                <h4 class="font" style="font-size:18px margin:20px; margin-top:15px"> <strong>REMARKS: </strong></h4>
                @if ( $product->pharm_dermal_comment !== Null)
                <textarea id="tinymce4" style="font-size: 16px text-align: justify " class="form-control" rows="4" name="pharm_dermal_comment" >{!! $pharmreports->pharm_dermal_comment !!}
                </textarea> 
                @endif
                @if ( $product->pharm_dermal_comment === Null)
                <textarea id="tinymce5" style="font-size: 16px text-align: justify " class="form-control" rows="4" name="pharm_dermal_comment" ><span style="font-size: 12pt;"> {{$pharmreports->code}} appears to be safe when applied to the skin.</span></textarea> 
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
                <h4 class="font" style="font-size:15px; margin:20px; margin-top:15px"> <strong>HOD's REMARKS: </strong></h4>
                <div class="alert alert-info" role="alert">
                    {!! $pharmreports->pharm_hod_remarks !!}
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
     

        @include('admin.pharm.temp.signaturetemp') 

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