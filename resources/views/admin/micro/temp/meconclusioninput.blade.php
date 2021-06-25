<div class="alert bg-light alert-light" style="margin-bottom: 10px">

 <div class="input-grou">
    <div class="row">
      <div class="col-md-3">
        <strong><span>General Conclusion</span></strong><br><br>
    <div class="form-check">
    <input class="form-check-input" type="radio" name="efficacy_default_conclusion" id="flexRadioDefault_1"  {{$product->micro_ea_conclusion == 1 ? "checked":""}}  value="1">
    <label class="form-check-label" for="flexRadioDefault_1">
         The product showed antimicrobial activity.
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="efficacy_default_conclusion" id="flexRadioDefault_2"  {{$product->micro_ea_conclusion == 2 ? "checked":""}}  value="2">
    <label class="form-check-label" for="flexRadioDefault_2">
        The product did not show antimicrobial activity.
    </label>
  </div>
      </div>
      <div class="col-md-3">
        <strong><span>General Comment</span></strong><br><br>
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="me_general_conclusion" name="me_general_comment" value="432">
            <span class="custom-control-label">&nbsp;Please check to type </span>
        </label>
  </div>
      <div class="col-md-6">
        <div class="form-group 432">
        <select  name="micro_ea_comment_option" class="form-control" id="micro_ea_comment_option">
          <option value="{{$product->micro_ea_comment}}">{{$product->micro_ea_comment == Null ?'Please select option':$product->micro_ea_comment}}</option>
          <option tag2="1" value="The product showed antimicrobial activity."> The product showed antimicrobial activity.</option>
          <option tag2="2" value="The product did not show antimicrobial activity.">The product did not show antimicrobial activity.</option>
      </select>
     </div>
      <div class="form-group 432" style="display: none">
        <label for="exampleTextarea1">Textarea</label>
      <textarea class="form-control" name="micro_ea_comment_text" rows="4">{{$product->micro_ea_comment}}</textarea>
      
     </div>
      </div>
    </div>
  </div> 


</div>

