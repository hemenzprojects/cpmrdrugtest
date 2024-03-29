<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Report submitted from animal house</strong> 
    
    <table class="table">
        <tbody>
            <tr>
                <td class="font"><strong>Animal Model</strong></td>
                <td class="font">
                    @foreach ($pharmreports->animalExperiment->unique('animal_model') as $item)
                    {{App\PharmAnimalModel::find($item->animal_model)->name}},
                    @endforeach
                </td>
            </tr>
            <tr>
            <td class="font"><strong>No. of Animals</strong></td>
                <td class="font">
                    @foreach ($pharmreports->animalExperiment->groupBy('product_id') as $item)
                    {{count($item)}}
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="font"><strong>Sex</strong></td> 
                <td  class="font">
                    @foreach ($pharmreports->animalExperiment->groupBy('id')->first() as $item)
                   {{ucfirst($item->animal_sex)}}
                    @endforeach
            </td>
            </tr>
            <tr>
                <td class="font"><strong>No. of Groups</strong></td> 
                <td  class="font">
                    @foreach ($pharmreports->animalExperiment->groupBy('group') as $item)
                    2(N = {{count($item) / 2}})
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="font"><strong>Route of Administration</strong></td> 
                <td  class="font">
                    @foreach ($pharmreports->animalExperiment->unique('animal_method') as $item)
                    {{ucfirst($item->animal_method)}},
                    @endforeach
                    {{-- @foreach ($pharmreports->animalExperiment as $item)
                    {{($item->animal_method)}},
                     @endforeach --}}
                </td>
            </tr>
         
           
            <tr>
                <td class="font"><strong>Dose Administered (mg/kg)</strong></td> 
                <td  class="font">
                 @php
                    $data = $pharmreports->animalExperiment()->orderBy('id','ASC')->get();
                @endphp
                @for ($i = 0; $i < count([$data]); $i++)
                {{$data[0]->dosage}}
                @endfor 
                </td>
            </tr>
            <tr>
                <td class="font"><strong>Period of Observation</strong></td> 
                <td  class="font">
                    @foreach ($pharmreports->animalExperiment->groupBy('id')->first() as $item)
                    {{$item->total_days}} Days
                    @endforeach
            </td>
            </tr>
            <tr>
                <td class="font"><strong>No. of Death Recorded</strong></td> 
                <td  class="font">
                  
                        {{$pharmreports->experimental_deaths}} Death
                </td>
            </tr>
            <tr>
                <td class="font"><strong>No. Alive</strong></td> 
                <td  class="font">
                        {{$pharmreports->experimental_Lives}} Lives 
                </td>
            </tr>
           
            <tr>
                <td class="font"  ><strong>Physical Signs of Toxicity</strong></td> 
                <td  class="font">  
                        @foreach ($pharmreports->animalExperiment as $item)
                        @foreach ($item['toxicity'] as $itm)             
                        {{$itm}}
                        @endforeach
                         @endforeach                                  
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>  
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="ik ik-x"></i>
    </button>
</div>
<div class="alert alert-secondary" role="alert">
    <strong>Product sample prepared</strong> 
    @foreach ($pharmreports->samplePreparation as $item)
    <li><strong>Weight: </strong>{{$item->weight}}</li>
    <li><strong>Dosage: </strong>{{$item->dosage}}</li>
    <li><strong>Yield:</strong> {{$item->yield}}</li>
    <li><strong>Measurement to animal exp unit:</strong> {{$item->measurement}}</li>

    @endforeach
  </div>