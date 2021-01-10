@include('admin.layout.general.head')
<style>
    .table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #d3d3d3;
    }
   
</style>

<div class="container">
        <div class="text-center" style="padding: 10px"> 
          <a href="{{ old('redirect_to', URL::previous())}}"> 
            <img style="margin:10px" src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
        </a>

        <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
        <p class="card-subtitle">Phytochemistry Department</p>
       </div>
  <div class="card">
            
       <div class="" style="margin-top: 10px">
        <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4>
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td class="font"> <strong>Name of Product:</strong></td>
                        <td class="font">
                            {{$phytoshowreport->productType->code}}|{{$phytoshowreport->id}}|{{$phytoshowreport->created_at->format('y')}}
                        </td>
                    </tr>
                    <tr>
                    <td class="font"><strong>Date Recievied:</strong></td>
                        <td class="font">{{$phytoshowreport->name}}</td>
                    </tr>
                    <tr>
                        <td class="font"><strong>Date of Report:</strong></td> 
                        <td class="font">{{$phytoshowreport->phyto_dateanalysed}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

   <div class="" style="margin-top: 10px">
      <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> TECHNICAL INFORMATION</strong></h4>

      <div class="col-md-7">

        <div class="col-lg-10 col-md-10" style="margin: 5px"><h5>A. {{\App\PhytoTestConducted::find(1)->name}}</h5></div> 
        <div class="table-responsive">
            <table class="table">

            <tbody>
              @foreach ($phytoshowreport->organolipticReport as $item)
              <tr>
                <th scope="row">{{$item->name}} :</th>
                <td class="font">{{$item->feature}}</td>
              </tr>
              @endforeach
            </tbody>
 
        </table>
    </div>

    <div class="col-lg-10 col-md-10" style="margin: 5px"><h5>B. {{\App\PhytoTestConducted::find(2)->name}}</h5></div>
    <div class="table-responsive"> 
        <table class="table">
            <tbody>
                @foreach ($phytoshowreport->phytochemdataReport as $item)
                <tr>
                  <th scope="row">{{$item->name}} : </th> 
                  <td class="font"> = {{$item->result}}</td>
                </tr>
                @endforeach
              </tbody>
        </table>
    </div>
    
    <div class="col-lg-10 col-md-10" style="margin: 5px"><h5>C. {{\App\PhytoTestConducted::find(3)->name}}</h5></div>
    
         <h6 class="" style="margin: 3%"> 
          @foreach ($phytoshowreport->phytochemconstReport as $pchemconst_item)
          @foreach (\App\PhytoChemicalConstituents::where('id', $pchemconst_item->name)->get() as $item)
          {{$item->name}},
          @endforeach
         @endforeach
         </h6>
            
    </div>

   </div>

   <div class="" style="margin-top: 10px">
    <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> REMARKS</strong></h4>
   <h6 style="margin:15px">{{$phytoshowreport->phyto_comment}}</h6>
   </div>


   <div class="row invoice-info" style="margin: 15px;margin-top: 20px">
    <?php
    $phyto_analysed_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->phyto_analysed_by:'');
    $user_type         = (\App\Admin::find($phyto_analysed_by)? \App\Admin::find($phyto_analysed_by)->user_type_id:'');
    ?>
    <div class="col-sm-4 invoice-col">
        <p>Analyzed By</p><br>
        @if (\App\Product::find($report_id)->phyto_hod_evaluation >null)
        <img src="{{asset(\App\Admin::find($phyto_analysed_by)? \App\Admin::find($phyto_analysed_by)->sign_url:'')}}" class="" width="42%"><br>
        @endif
        -----------------------------<br>
      
        <span>{{ucfirst(\App\Admin::find($phyto_analysed_by)? \App\Admin::find($phyto_analysed_by)->full_name:'')}}</span>
        <p>{{ucfirst(\App\UserType::find($user_type )? \App\UserType::find($user_type )->name:'')}}</p>

    </div> 
    <div class="col-sm-4 invoice-col">
         
    </div>
    <div class="col-sm-4 invoice-col">
        <?php
        $phyto_appoved_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->phyto_appoved_by:'');
        $hod_user_type = (\App\Admin::find($phyto_appoved_by)? \App\Admin::find($phyto_appoved_by)->user_type_id:'');

        ?>
        <p>Supervisor</p><br>

        @if (\App\Product::find($report_id)->phyto_hod_evaluation ==2)

        <img src="{{asset(\App\Admin::find($phyto_appoved_by)? \App\Admin::find($phyto_appoved_by)->sign_url:'')}}" class="" width="42%"><br>
        @endif

        ------------------------------<br> 

      <span>{{ucfirst(\App\Admin::find($phyto_appoved_by)? \App\Admin::find($phyto_appoved_by)->full_name:'')}}</span>
      <p>{{ucfirst(\App\UserType::find($hod_user_type)? \App\UserType::find($hod_user_type)->name:'')}}</p>

    </div>

</div>
  </div>
 
</div>

@include('admin.layout.general.scriptsjs')