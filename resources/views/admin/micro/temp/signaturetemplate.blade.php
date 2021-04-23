<div class="col-md-12" style="margin-top: 2%">
    <div class="form-group">
        <label for="exampleTextarea1"> <strong>General Conclusion:</strong></label>
        <textarea class="form-control" id="exampleTextarea1" rows="4"> {{$product->micro_general_conclusion}}     
 </textarea>
    </div>
</div>
<div class="col-sm-3" style="margin-bottom:3%">
    <div class="form-group">
        <p><strong>Evaluation:</strong> {!! $product->micro_grade_report !!} </p>
    </div>
</div>
<div class="row invoice-info" style="margin: 15px; margin-top:30px">
    <?php
    $micro_approved_by = ($product? $product->micro_approved_by:'');
    $user_type         = (\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->user_type_id:'');
  ?>
    <div class="col-sm-4 invoice-col">
        
        <p>Analyzed By</p><br>
        @if (($product->micro_hod_evaluation === 0 && $product->micro_approved_by != Null) || $product->micro_hod_evaluation === 2)
        <img src="{{asset(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->sign_url:'')}}" class="" width="28%"><br>
        @endif
        -----------------------------<br>
      
        <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->full_name:'')}}</span><br>
        <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->position:'')}}</span>

    </div> 
    <div class="col-sm-4 invoice-col">
         
    </div>
    <div class="col-sm-4 invoice-col">
        <?php
        $micro_finalapproved_by = ($product? $product->micro_finalapproved_by:'');
        $hod_user_type = (\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->user_type_id:'');

        ?>
        <p>Approved by</p><br>
        @if ($product->micro_finalapproved_by === 2)
        <img src="{{asset(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->sign_url:'')}}" class="" width="28%"><br>
        @endif

        ------------------------------<br> 

        <span>{{ucfirst(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->full_name:'')}}</span>
        <p>{{ucfirst(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->position:'')}}</p>

    </div>

</div>
