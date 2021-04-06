
<h6 style="margin-top: 2%">REMARKS</h6>
<textarea class="form-control" required name="comment"  cols="30" rows="3"> {{$product->phyto_comment}}</textarea>

<div class="col-sm-3" style="margin-top:30px">
<div class="form-group">
    <label for="exampleInputEmail3"> <strong><span style="color: red">Report Evaluation</span></strong>  </label>
    <select name="phyto_grade" required class="form-control" id="exampleSelectGender">
    <option value="{{$product->phyto_grade}}">{!! $product->phyto_grade_report !!}</option>
        <option value="1">Failed</option>
        <option value="2">Passed</option>
    </select>                                
    </div>
</div>