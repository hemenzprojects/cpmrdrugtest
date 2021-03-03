@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="text-center" style="margin: 2%"> 
                        <h4 class="font" style="font-size:18px">List of completed {{\App\ProductType::find($ptype_id)->name}}</h4>
                       <p class="card-subtitle"> select date below to generate report on {{\App\ProductType::find($ptype_id)->name}}</p>
                      </div>
                    {{-- <div class="row" style="margin:1%">
                        <div class="col-md-4">
                            <div class="form-group row" style="margin-left:8%">
                             
                                    {{ Form::open(array('action'=> "AdminAuth\Pharmacology\PharmController@daily_report",  'method'=>'post','class'=>'form-horizontal')) }}
                                    {{form::token()}}
                                    <div class="input-group">
                                        {{ Form::selectRange('year', date('Y') -2, date('Y'),array('class'=>'form-control','placeholder'=>'')) }}
                                        {{ Form::selectMonth('month',array('class'=>'form-control','placeholder'=>'')) }}
                                        <button type="submit" class="btn btn-primary mr-2">Search</button>   
                                    </div>
                                    <input type="hidden" name="product_type" value="{{$ptype_id}}">

                                    {{ Form::close() }}
                               
                                   
                            </div>
                        </div>
                        
                        
                         <div class="col-md-4">
                            <div class="form-group row" style="margin-left:12%">
                               
                                    {{ Form::open(array('action'=> "AdminAuth\Pharmacology\PharmController@monthly_report",  'method'=>'post','class'=>'form-horizontal')) }}
                                    {{form::token()}}
                                   <div class="input-group">
                                       {{ Form::selectRange('year', date('Y') -2, date('Y'),array('class'=>'form-control','placeholder'=>'')) }}
                                       {{ Form::selectMonth('month',array('class'=>'form-control','placeholder'=>'')) }}
                                       <button type="submit" class="btn btn-primary mr-2">search</button>  
                                   </div>
                                   <input type="hidden" name="product_type" value="{{$ptype_id}}">
                                   {{ Form::close() }}
                          </div>
                                                                     
                            
                        </div>

                        <div class="col-md-4">
                            <div class="form-group row" style="margin-left:16%">

                                {{ Form::open(array('action'=>"AdminAuth\Pharmacology\PharmController@yearly_report", 'method'=>'post','class'=>'form-horizontal')) }}
                                    {{Form::token()}}
                                    <div class="input-group">
                                        {{ Form::selectRange('year',date('Y') -2, date('Y'), array('class'=>'form-control','placeholder'=>'')) }}
                                        <button type="submit" class="btn btn-primary mr-2">Search</button>    
                                    </span>
                                    </div>
                                 <input type="hidden" name="product_type" value="{{$ptype_id}}">
                               {{ Form::close() }} 
                             </div>
                        </div>
                
                    </div> --}}
                </div>
                      
                    <div class="card">
                            <div class="card-header row">
                                <div class="card-header">
                                    <label class="badge badge-warning" style="background-color:#26c281; margin-right:5px;">
                                        {{count($completed_products)}}
                                    </label>
                                    <h3>Total {{\App\ProductType::find($ptype_id)->name}} Reports completed</h3>
            
                                 </div>
                                <div class="card-body">
                                    <table id="order-table" class="table table-striped table-bordered nowrap">
                                 <thead>
                                 <tr>
                                    
                                     <th>Product</th>
                                     <th>Test conducted</th>
                                     <th>Assigned To</th>
                                     <th>Evaluation</th>
                                     <th>Grade</th>
                                     <th>Date Analysed</th>  
                                     <th>Date Submited</th> 
                                     <th>Action</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($completed_products as $completed_product)                                      
                                     <tr>
                                  
                                     <td class="font">
                                         <a data-toggle="modal"  data-placement="auto" data-target="#exampleModalLong{{$completed_product->id}}" title="View Experiment" href=""></i>  
                                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                {{$completed_product->code}}
                                            </span>
     
                                         </a>
                                         <sup style="font-size: 1px">
                                            {{$completed_product->productType->code}}{{$completed_product->id}}{{$completed_product->created_at->format('y')}}
                                         </sup> 
                                     </td>
                                     <td class="font">
                                         {{\App\PharmTestConducted::find($completed_product->pharm_testconducted)->name}}
                                     </td>
                                     <td class="font">
                                         {{-- <strong>Sample Preparation:</strong><li> @foreach ($completed_product->samplePreparation->groupBy('id')->first() as $item)
                                             {{\App\Admin::find($item->distributed_by)->full_name}}
                                             @endforeach</li> --}}
                                       <strong>Animal Experiment:</strong>  <li style="margin-bottom: 5px"> @foreach ($completed_product->animalExperiment->groupBy('id')->first() as $item)
                                         <span style="color: #023504">{{\App\Admin::find($item->added_by_id)->full_name}}</span>
                                         @endforeach</li>
                                         <strong>Report Analyst:</strong>
                                           <li>
                                            <span style="color: #023504">{{\App\Admin::find($completed_product->pharm_analysed_by)->full_name}}
                                         </li>
                                     </td>
                                     <td class="font">{!! $completed_product->hod_pharm_evaluation !!}</td>
                                     <td class=""> 
                                        @if ($completed_product->pharm_grade != Null)
                                        <strong>{!! $completed_product->pharm_grade_report !!}</strong>
                                        @endif
                                    </td>
                                     <td class="font">{{$completed_product->pharm_dateanalysed}}</td>
                                     <td class="font">{{$completed_product->updated_at->format('d/m/Y')}}</td>
                                     <td class="font">
                                         <a href="{{url('admin/pharm/completedreport/show',['id' => $completed_product->id])}}"><i class="ik ik-eye f-16 mr-15 text-green"></i></a>
     
                                         </td>
                                     
                                     </tr>
                                  
                                      @endforeach
                               </tbody>
                               
                             </table>
                                </div> 
                                
                            </div>
                    </div>
                
            </div>
        </div>
</div>
@endsection