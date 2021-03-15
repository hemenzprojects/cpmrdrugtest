@if (($show_microbial_efficacyanalyses) && count($show_microbial_efficacyanalyses)<1) 
<div class="checkefficacy1 col-sm-3">
    <label class="custom-control custom-checkbox" >
        <input type="checkbox" class=" custom-control-input" name="efficacyanalyses_form" id="check_efficacy2" value="243123">
        <span class="custom-control-label">&nbsp;Microbial Efficacy Analysis Form</span>
    </label>
</div>
@endif
@if (($show_microbial_efficacyanalyses) && count($show_microbial_efficacyanalyses)>0) 
<div class="table-responsive">  
     <div class="card-heade" style="margin: 2%">
     <h6>Microbial Efficacy Analysis</h6>
     </div>
     
      <table class="table table-striped table-bordered nowrap dataTable">
         <thead class="meatablehead">
             <tr class="table-info">
                 <th>Pathogen</th>
                 <th>PI Zone</th>
                 <th>CI Zone</th>
                 <th>FI Zone</th>
             </tr>
         </thead>
         <tbody class="">
             @foreach($show_microbial_efficacyanalyses as $efficacyanalyses)
             
                 <tr>
                     <input type="hidden" name="metest_id[]" value="{{$efficacyanalyses->id}}" class="custom-control-input" checked="">

                     <td class="font ">{{$efficacyanalyses->pathogen}}</td>
                     <td class="font">
                         <input type="text" required class="form-control" required name="pi_zone_update[]" placeholder="PI Zone" value="{{$efficacyanalyses->pi_zone}}">
                         {{-- <input type="hidden" class="form-control" id="pi_zone" value="76899233403932{{$efficacyanalyses->efficacy_analyses_id}}"> --}}
                         <input type="hidden" class="form-control" name="efficacy_analyses_id[]" value="{{$efficacyanalyses->efficacy_analyses_id}}">

                     </td>
                     <td class="font">
                     <input type="text" class="form-control" required name="ci_zone_update[]"  value="{{$efficacyanalyses->ci_zone}}">
                     </td>
                     <td class="font">
                         <input type="text" class="form-control" required name="fi_zone_update[]" value="{{$efficacyanalyses->fi_zone}}">
                     </td>
                 </tr>
             
             
             @endforeach

             <div class="checkefficacy1 col-sm-3">
                <label class="custom-control custom-checkbox" >
                    <input type="checkbox" class=" custom-control-input" name="efficacyanalyses_update" value="1" checked>
                </label>
            </div>

        </tbody>
     </table> 

     @for ($i = 0; $i < count($show_microbial_efficacyanalyses); $i++)
 
     @if ($i<1)
    {!! $show_microbial_efficacyanalyses[0]->ref !!}
     @endif
     @endfor
</div>

@include('admin.micro.temp.meconclusioninput') 

@endif