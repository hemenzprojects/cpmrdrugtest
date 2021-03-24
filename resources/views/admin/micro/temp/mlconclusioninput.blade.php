
   <div class="alert bg-light alert-light" style="margin-bottom: 10px">
    <strong><span>General Conclusion</span></strong><br><br>
    <div class="input-grou">
      <div class="row">
        <div class="col-md-4">
          <div class="">
          <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="ml_general_conclusion" name="ml_general_conclusion" value="321">
              <span class="custom-control-label">&nbsp;Please check to type </span>
          </label>
       </div>
    </div>
        <div class="col-md-8">
          <div class="form-group 321">
          <select required  name="micro_la_conclution_option" class="form-control" id="micro_la_conclution_option">
            <option value="{{$product->micro_la_conclution}}">{{$product->micro_la_conclution == Null ?'Please select option':$product->micro_la_conclution}}</option>
            <option value="The sample meets with the requirements as per BP specifications">The sample meets with the requirements as per BP specifications</option>
            <option value="The sample doest not meets with the requirements as per BP specifications">The sample doest not meets with the requirements as per BP specifications</option>
        </select>
       </div>
        <div class="form-group 321" style="display: none">
          <label for="exampleTextarea1">Textarea</label>
        <textarea class="form-control" name="micro_la_conclution_text" rows="4">{{$product->micro_la_conclution}}</textarea>
        
       </div>
        </div>
      </div>
    </div> 
</div>