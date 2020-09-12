@include('admin.layout.general.head')

<div class="row">

        <div class="container">
            <div class="card" style="padding: 15px">
            <form action="{{url('admin/micro/report/update',['id' => $report_id])}}" method="POST">
                    {{ csrf_field() }} 
                <div class="text-center"> 
                <img src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
                <h5 class="font" style="font-size:16px"> Microbiology Department Centre for Plant Medicine Research </h5>
                <p class="card-subtitle">Microbial Analysis Report on Herbal Product</p>
               </div>
                <form action=""> 
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                                <tr  class="table-warning">
                                    <th>Product Code</th>
                                    <th>Product Form</th>
                                    <th>Date Received</th>
                                    <th>Date Analysed</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($micro_withcompletedproducts as $completedproduct)
                                <tr>
                                     <td class="font">  {{$completedproduct->productType->code}}|{{$completedproduct->id}}|{{$completedproduct->created_at->format('y')}}</td>
                                    <td class="font">  {{$completedproduct->productType->name}}</td>
                                    <input type="hidden" name="micro_product_id" value="{{$completedproduct->id}}">
                                    <input type="hidden" id="product_typestate" value="7777{{$completedproduct->productType->state}}">
                                    @foreach($completedproduct->departments->groupBy('id')->first() as $dept)

                                    <td class="font">{{($dept->pivot->updated_at->format('d/m/Y'))}}</td>
                                    @endforeach 

                                    <td class="font">
                                     <input class="form-control" type="date" placeholder="Date" name="date_analysed" value="">

                                    </td>
                                    
                                </tr>
                               {{-- {{ $dept->pivot}} --}}
                               @endforeach 
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header d-block">
                        <h6>Microbial Load Analysis</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                                <tr  class="table-warning">
                                    <th>Test Conducted</th>
                                    <th class="77772" style="display: none">Result (CFU/ml)</th>
                                    <th class="77771" style="display: none">Result (CFU/g)</th>
                                    <th>Accepted Criterion (BP, 2016)</th>
                                  
                                </tr>
                            </thead>
                        <tbody>
                           
                            @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
                            <tr>
                                <td class="font">
                                    {{$microbial_loadanalyses[$i]->test_conducted}}
                                    <input type="hidden" class="form-control" name="loadanalyses" placeholder="Result" value="{{$microbial_loadanalyses[$i]->test_conducted}}">
                                </td>
                                <td class="font">
                                    {{$microbial_loadanalyses[$i]->result}}
                                </td>
                                <td class="font">
                                    {{$microbial_loadanalyses[$i]->acceptance_criterion}}
                                </td>                                                          
                            </tr>
                            @endfor
                        </tbody>
                       </table>  
                    </div>


                    <div class="card-header d-block ">
                        <h6>Microbial Efficacy Analysis</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead class="meatablehead 768992334039322" style="display: none">
                                <tr class="table-warning">
                                    <th>Pathogen</th>
                                    <th>PI Zone</th>
                                    <th>CI Zone</th>
                                    <th>FI Zone</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($microbial_efficacyanalyses as $efficacyanalyses)
                            
                                <tr>
                                    <td class="font ">{{$efficacyanalyses->pathogen}}</td>
                                    <td class="font">
                                       {{$efficacyanalyses->pi_zone}}
                                    </td>
                                    <td class="font">{{$efficacyanalyses->ci_zone}}</td>
                                    <td class="font">{{$efficacyanalyses->fi_zone}}</td>
                                </tr>
                            
                               </div>
                             
                            @endforeach
                           </tbody>
                       </table>  
                    </div>
               
                    <div class="row invoice-info" style="margin: 15px">

                        <div class="col-sm-4 invoice-col">
                            <p>Analyzed By</p><br>
                            -----------------------------
                        </div> 
                        <div class="col-sm-4 invoice-col">
                           
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <p>Supervisor</p><br>
                            ------------------------------                        
                        </div>

                    </div>
    
               </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit to complete report</button>
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-view"></i> View Report</button>
            </div>
        </form>
        </div>

               

</div>

@include('admin.layout.general.scriptsjs')

