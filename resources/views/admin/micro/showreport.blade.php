@extends('admin.layout.main')

@section('content')
        <div class="container-fluid">
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
                               @foreach ($show_productdept as $showproduct)
                                  <tr>
                                      <td class="font"> {{\App\Product::find($showproduct->product_id)->productType->code}}|{{\App\Product::find($showproduct->product_id)->id}}|{{\App\Product::find($showproduct->product_id)->created_at->format('y')}}</td>
                                      <td class="font"> {{\App\Product::find($showproduct->product_id)->productType->name}}</td>
                                      <td class="font"> {{($showproduct->updated_at->format('d/m/Y'))}}</td>
                                      <td class="font">
                                        <input class="form-control" type="date" placeholder="Date" name="date_analysed" value="">
                                       </td>
                                       <input type="hidden" name="micro_product_id" value="{{\App\Product::find($showproduct->product_id)->id}}">
                                       <input type="hidden" id="product_typestate" value="7777{{\App\Product::find($showproduct->product_id)->productType->state}}">
                                       <input class="form-control" type="hidden" id="load_analyses_id" value="811920012{{$showproduct->status}}">

                                  </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                   
                    
                        <div class="card-header"><h3>Microbial Load Analysis</h3></div>
                   
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                                <tr  class="table-warning">
                                    {{-- <th>#</th> --}}
                                    <th>Test Conducted</th>
                                    <th class="77772" style="display: none">Result (CFU/ml)</th>
                                    <th class="77771" style="display: none">Result (CFU/g)</th>
                                    <th>Accepted Criterion (BP, 2016)</th>
                                  
                                </tr>
                            </thead>
                        <tbody class="8119200123" style="display: none">
                           
                            @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)
                         <tr>
                               
                                  <input type="hidden" name="mltest_id[]" value="{{$show_microbial_loadanalyses[$i]->id}}" class="custom-control-input" checked="">
                        
                                <td class="font">
                                    {{$show_microbial_loadanalyses[$i]->test_conducted}}
                                    <input type="hidden" class="form-control" name="test_conducted[]"  value="{{$show_microbial_loadanalyses[$i]->test_conducted}}">
                                </td>
                                <td class="font">
                                    <input type="text" required class="form-control {{$i<2?'date-inputmask':''}}" required name="result[]"  placeholder="{{$i>1?'Result':''}}" value="{{$show_microbial_loadanalyses[$i]->result}}">
                                </td>
                                <td class="font">
                                    <input type="text" required class="form-control {{$i<2?'date-inputmask':''}}" required name="acceptance_criterion[]"  placeholder="{{$i>1?'Acceptance Criterion':''}}" id="expresult-{{$show_microbial_loadanalyses[$i]->id}}" value="{{$show_microbial_loadanalyses[$i]->acceptance_criterion}}">
                                </td>
                                
                                <input type="hidden" required class="custom-control-input" name="loadanalyses" value="{{$show_microbial_loadanalyses[$i]->load_analyses_id}}">
                                
                            </tr>
                            @endfor
                        </tbody>
                       </table>  
                    </div>
                    
                    <div class="checkefficacy1 col-sm-3">
                        <label class="custom-control custom-checkbox" >
                            <input type="checkbox" class=" custom-control-input" name="efficacyanalyses_form" id="check_efficacy2" value="243123">
                            <span class="custom-control-label">&nbsp;Microbial Efficacy Analysis</span>
                        </label>
                    </div>

                    <div class="243123" style="display: none">
                        <div class="card">
                            <div class="card-header d-block">
                            </div>
                            <div class="card-body p-0 table-border-style">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>Pathogen</th>
                                                <th>Product IZone</th>
                                                <th>Ciprofloxacin IZone</th>
                                                <th>Fluconazole IZone</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($MicrobialEfficacyform as $metest)
                                            <tr>
                                                <td class="font">
                                                    
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="metestform_id[]" value="{{$metest->id}}" class="custom-control-input" checked="true">
                        
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label> 
                                                    
                                                </td>
                                                <td class="font">{{$metest->pathogen}}</td>
                                                <input type="hidden" class="form-control" name="pathogen_form[]" value="{{$metest->pathogen}}">

                                                <td class="font">
                                                    <input type="text" class="form-control" required name="pi_zoneform[]" placeholder="PI Zone" value="{{$metest->pi_zone}}">
                                                </td>
                                                <td class="font" class="form-control">{{$metest->ci_zone}}</td>
                                                <input type="hidden"  name="ci_zoneform[]" value="{{$metest->ci_zone}}">

                                                <td class="font">{{$metest->fi_zone}}</td>
                                                <input type="hidden" class="form-control" name="fi_zoneform[]"  value="{{$metest->fi_zone}}">

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> 
                  
                       <div class="table-responsive">
                        
                          <div class="card-header"><h3>Microbial Efficacy Analysis</h3></div>
                       
                             <table class="table table-striped table-bordered nowrap dataTable">
                                <thead class="meatablehead 768992334039322" style="display: none">
                                    <tr class="table-info">
                                        <th>Pathogen</th>
                                        <th>PI Zone</th>
                                        <th>CI Zone</th>
                                        <th>FI Zone</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    @foreach($show_microbial_efficacyanalyses as $efficacyanalyses)
                                    
                                        <tr>
                                            <input type="hidden" name="metest_id[]" value="{{$efficacyanalyses->id}}" class="custom-control-input" checked="">

                                            <td class="font ">{{$efficacyanalyses->pathogen}}</td>
                                            <td class="font">
                                                <input type="text" required class="form-control" required name="pi_zone_update[]" placeholder="PI Zone" value="{{$efficacyanalyses->pi_zone}}">
                                                <input type="hidden" class="form-control" id="pi_zone" value="76899233403932{{$efficacyanalyses->efficacy_analyses_id}}">
                                                <input type="hidden" class="form-control" id="pi_zone" name="efficacyanalyses_update" value="{{$efficacyanalyses->efficacy_analyses_id}}">

                                            </td>
                                            <td class="font">{{$efficacyanalyses->ci_zone}}</td>
                                            <td class="font">{{$efficacyanalyses->fi_zone}}</td>
                                        </tr>
                                    
                                    
                                    @endforeach
                               </tbody>
                            </table>  
                      </div>
              
                    <div class="alert alert-secondary mt-20" style="margin-bottom: 10px">
                        <strong><span>General Comment</span></strong><br><br>
                        <textarea required="" type="text" class="form-control" id="exampleTextarea1" name="micro_comment" placeholder="General Comment" value="" rows="4">
                        </textarea>
                    
                        <strong><span>Conclution</span></strong><br><br>
                        <div class="input-group">
                        <input type="text" required class="form-control" placeholder="Concution" name="micro_conclution" value="">
                        </div> 
                   </div>
                    <div class="row invoice-info" style="margin: 15px">

                        <div class="col-sm-4 invoice-col">
                            <p>Analyzed By</p><br>

                            -----------------------------<br>
                            {{-- <p>{{ucfirst(\App\Admin::find($show_microbial_reportcreator->added_by_id)? \App\Admin::find($show_microbial_reportcreator->added_by_id)->full_name:'null')}}</p> --}}
                        </div> 
                        <div class="col-sm-4 invoice-col">
                             
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <p>Supervisor</p><br>

                            ------------------------------<br> 
                        <p></p>                     
                        </div>

                    </div>
    
               </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit for Approval</button>
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-view"></i> View Report</button>
            </div>
        </form>
        </div>
        
@endsection

@section('bottom-scripts')
<script src="{{asset('js/jquery.inputmask.bundle.min.js')}}"></script>
    
@endsection