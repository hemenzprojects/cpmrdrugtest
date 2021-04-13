<div class="row invoice-info" style="margin: 15px">
    
    <?php
    $phyto_approved_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->phyto_approved_by:'');
    $user_type         = (\App\Admin::find($phyto_approved_by)? \App\Admin::find($phyto_approved_by)->user_type_id:'');
    ?>
    <div class="col-sm-4 invoice-col">
        <p>Analyzed By</p><br>
        @if (\App\Product::find($report_id)->phyto_hod_evaluation === 0 || \App\Product::find($report_id)->phyto_hod_evaluation === 2)
        <img src="{{asset(\App\Admin::find($phyto_approved_by)? \App\Admin::find($phyto_approved_by)->sign_url:'')}}" class="" width="42%"><br>
        @endif
        -----------------------------<br>
      
        <span>{{ucfirst(\App\Admin::find($phyto_approved_by)? \App\Admin::find($phyto_approved_by)->full_name:'')}}</span><br>
        <span>{{ucfirst(\App\Admin::find($phyto_approved_by)? \App\Admin::find($phyto_approved_by)->position:'')}}</span>

    </div> 
    <div class="col-sm-4 invoice-col">
         
    </div>
    <div class="col-sm-4 invoice-col">
        <?php
        $phyto_finalapproved_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->phyto_finalapproved_by:'');
        $hod_user_type = (\App\Admin::find($phyto_finalapproved_by)? \App\Admin::find($phyto_finalapproved_by)->user_type_id:'');

        ?>
        <p>Approved By</p><br>

        @if (\App\Product::find($report_id)->phyto_hod_evaluation ==2)

        <img src="{{asset(\App\Admin::find($phyto_finalapproved_by)? \App\Admin::find($phyto_finalapproved_by)->sign_url:'')}}" class="" width="42%"><br>
        @endif

        ------------------------------<br> 

      <span>{{ucfirst(\App\Admin::find($phyto_finalapproved_by)? \App\Admin::find($phyto_finalapproved_by)->full_name:'')}}</span><br>
      <span>{{ucfirst(\App\Admin::find($phyto_finalapproved_by)? \App\Admin::find($phyto_finalapproved_by)->position:'')}}</span>

    </div>

</div>