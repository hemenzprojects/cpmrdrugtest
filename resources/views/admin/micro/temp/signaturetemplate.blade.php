<div class="row invoice-info" style="margin: 15px; margin-top:60px">
    <?php
    $micro_approved_by = ($product? $product->micro_approved_by:'');
    $user_type         = (\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->user_type_id:'');
  ?>
    <div class="col-sm-4 invoice-col">
        <p>Analyzed By</p><br>
        @if ($product->micro_hod_evaluation === 0 || $product->micro_hod_evaluation === 2)
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
