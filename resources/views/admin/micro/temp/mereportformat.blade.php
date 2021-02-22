<div class="checkefficacy1 col-sm-3">
    <label class="custom-control custom-checkbox" >
        <input type="checkbox" class=" custom-control-input" name="efficacyanalyses_form" id="check_efficacy2" value="243123">
        <span class="custom-control-label">&nbsp;Microbial Efficacy Analysis Form</span>
    </label>
</div>

@if (($show_microbial_efficacyanalyses) && count($show_microbial_efficacyanalyses)>0) 
<div class="table-responsive">  
     <div class="card-heade" style="margin: 2%">
     <h6>Microbial Efficacy Analysis</h6>
     </div>
     
      <table class="table table-striped table-bordered nowrap dataTable">
         <thead class="meatablehead 768992334039322" style="display: none">
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
                         <input type="hidden" class="form-control" id="pi_zone" value="76899233403932{{$efficacyanalyses->efficacy_analyses_id}}">
                         <input type="hidden" class="form-control" name="efficacyanalyses_update" value="{{$efficacyanalyses->efficacy_analyses_id}}">

                     </td>
                     <td class="font">
                     <input type="text" class="form-control" required name="ci_zone_update[]"  value="{{$efficacyanalyses->ci_zone}}">
                     </td>
                     <td class="font">
                         <input type="text" class="form-control" required name="fi_zone_update[]" value="{{$efficacyanalyses->fi_zone}}">
                     </td>
                 </tr>
             
             
             @endforeach
        </tbody>
     </table> 
</div>

<div class="alert alert-secondary mt-20" style="margin-bottom: 10px">
 <strong><span>General Conclusion</span></strong><br><br>
 <div class="input-group">
     <select name="micro_ea_conclution" required class="form-control">
         <option value="{{$product->micro_ea_conclution}}">{!! $product->micro_efficacy_conc !!}</option>
         <option value="1">The product did not show antimicrobial activity</option>
         <option value="2">The product showed antimicrobial activity</option>
     </select>
 </div> 
</div>
@endif