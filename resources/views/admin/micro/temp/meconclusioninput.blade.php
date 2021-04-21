<div class="alert bg-light alert-light" style="margin-bottom: 10px">
 <strong><span>General Comment</span></strong><br><br>
 <div class="input-grou">
    <div class="row">
      <div class="col-md-4">
        <div class="form-check mx-sm-2">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="me_general_conclusion" name="me_general_comment" value="432">
            <span class="custom-control-label">&nbsp;Please check to type </span>
        </label>
     </div>
  </div>
      <div class="col-md-8">
        <div class="form-group 432">
        <select  name="micro_ea_comment_option" class="form-control" id="micro_ea_comment_option">
          <option value="{{$product->micro_ea_comment}}">{{$product->micro_ea_comment == Null ?'Please select option':$product->micro_ea_comment}}</option>
          <option value="The product did not show antimicrobial activity">The product did not show antimicrobial activity</option>
          <option value="The product showed antimicrobial activity">The product showed antimicrobial activity</option>
      </select>
     </div>
      <div class="form-group 432" style="display: none">
        <label for="exampleTextarea1">Textarea</label>
      <textarea class="form-control" name="micro_ea_comment_text" rows="4">{{$product->micro_ea_conclution}}</textarea>
      
     </div>
      </div>
    </div>
  </div> 


</div>