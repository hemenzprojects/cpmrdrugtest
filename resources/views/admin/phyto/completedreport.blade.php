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
  <div class="card" style="padding:40px">
            
       <div class="" style="margin-top: 10px">
        <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4>
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td class="font"> <strong>Name of Product:</strong></td>
                        <td class="font">
                            {{$phytoshowreport->code}}
                        </td>
                    </tr>
                    <tr>
                    <td class="font"><strong>Date Recievied:</strong></td>
                        <td class="font">
                            {{   Carbon\Carbon::parse($phytoshowreport->departmentById(3)->pivot->received_at)->format('jS \\ F Y')}}                                        
                        </td>
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
                  <td class="font">
                    @if ($item->location == 1)
                    <p>{{$item->result}}  &deg; {{$item->unit}}  </p>        
                   @else
                   {{$item->result}}  {{$item->unit}}
                   @endif
                  </td>
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


   @include('admin.phyto.temp.signaturetemplate')

 
</div>

@include('admin.layout.general.scriptsjs')