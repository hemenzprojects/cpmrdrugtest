
        <div class="row" style="margin: 35px">
            <div class="col-sm-4 invoice-col">
                <?php
                $pharm_approved_by = ($product? $product->pharm_approved_by:'');
                $hod_user_type = (\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->user_type_id:'');

                ?>
                <p>Analysed by</p><br>
                @if ($product->pharm_hod_evaluation ==2)
                <img src="{{asset(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->sign_url:'')}}" class="" width="42%"><br>
                @endif

                ------------------------------<br> 
            
            <span>{{ucfirst(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->full_name:'')}}</span>
            <p>{{ucfirst(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->position:'')}}</p>

            </div>
         
        <div class="col-sm-4 invoice-col">
            
         </div>
           <div class="col-sm-4 invoice-col">
            <?php
            $pharm_finalapproved_by = ($product? $product->pharm_finalapproved_by:'');
            $hod_user_type = (\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->user_type_id:'');

            ?>
            <p>Approved by</p><br>
            @if ($product->pharm_finalapproved_by != Null)
            <img src="{{asset(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->sign_url:'')}}" class="" width="42%"><br>
            @endif

            ------------------------------<br> 
        
        <span>{{ucfirst(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->full_name:'')}}</span>
        <p>{{ucfirst(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->position:'')}}</p>

        </div> 
        </div>
