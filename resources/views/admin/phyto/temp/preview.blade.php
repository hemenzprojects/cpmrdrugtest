<div class="modal fade" id="demoModapreview" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:950px;  margin-left: -200px; ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center"> 
                    <img src="{{asset('admin/img/logo.jpg')}}" class="" width="10%">
                    <h4 class="font2" style="font-size:18px">CENTRE FOR PLANT MEDICINE RESEARCH </h4>
                    <p class="card-subtitle">PHYTOCHEMISTRY DEPARTMENT</p>
                </div>
            <table class="table table-striped table-bordered nowrap dataTable" >
            <tr>
                <th class="font2">Product Code</th>
                <th class="font2">Dosage Form</th>
                <th class="font2">Date Received</th>
                <th class="font2">Date Analysed</th>
            </tr>
            <tr>
            <td class="font2">{{$product->code}}</td>
            <td class="font2">{{$product->productType->name}}</td>
            <td class="font2">{{ $product->departmentById(3)->pivot->updated_at->format('jS \\, F Y') }}</td>
            <td class="font2">{{ Carbon\Carbon::parse($product->phyto_dateanalysed)->format('jS \\, F Y')}}</td>
            </tr>

            </table>
             
            <div  style="margin-top:30px">
                <h6 >A. {{\App\PhytoTestConducted::find(1)->name}}</h6>
                <table  class="table table-striped table-bordered nowrap dataTable"  >

                    <tbody>
                        @foreach ($phyto_organolepticsreport as $organo_item)
                        <tr>
                            <td class="font2" style="width: 50%"><strong>{{$organo_item->name}}</strong></td>
                            <td class="font2" style="width: 50%">{{$organo_item->feature}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
         

            <div style="margin-top:30px">
                <h6 >B. {{\App\PhytoTestConducted::find(2)->name}}</h6>
            <table class="table table-striped table-bordered nowrap dataTable" >
                
                <tbody>
                    @for ($i = 0; $i < count($phyto_physicochreport); $i++)
                    <tr>
                        <td class="font2" style="width: 50%"><strong>{{$phyto_physicochreport[$i]->name}}</strong></td>
                        <td class="font2" style="width: 50%">
                            @if ($phyto_physicochreport[$i]->location == 1)
                            <span>{{$phyto_physicochreport[$i]->result}}  &deg; {{$phyto_physicochreport[$i]->unit}}  </span>        
                           @else
                           {{$phyto_physicochreport[$i]->result}}  {{$phyto_physicochreport[$i]->unit}}
                           @endif
            
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
            </div>

            <div style="margin-top:30px">
                <h6 >C. {{\App\PhytoTestConducted::find(3)->name}}</h6>
            <table class="table table-striped table-bordered nowrap dataTable" >

                <tbody>
                    <tr>
                        <td class="font2">
                      
                            @foreach ($phyto_chemicalconstsreport as $key => $value)
                            @if( count( $phyto_chemicalconstsreport  ) != $key + 1 )
                            {{App\PhytoChemicalConstituents::find($value->name)->name}},
                            @else
                             {{App\PhytoChemicalConstituents::find($value->name)->name}}.
                            @endif
                            @endforeach
                        </td>
        
                        
                    </tr>
                </tbody>
            </table>

            </div>
            
            <div style="margin-top:30px">
                <h6 class="font2">Remarks</h6>
              <p class="font2">{{$product->phyto_comment}}</p>

            </div>

          <div style="margin-top: 50px">          
                @include('admin.phyto.temp.signaturetemplate')
        </div>  
          </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>