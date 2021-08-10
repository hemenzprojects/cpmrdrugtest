@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="text-center" style="margin: 2%"> 
                        <h4 class="font" style="font-size:18px">List of completed {{\App\ProductType::find($ptype_id)->name}}</h4>
                       <p class="card-subtitle"> Bellow are all completed report on {{\App\ProductType::find($ptype_id)->name}}, click the action button to view report</p>
                      </div>
                    {{-- <div class="row" style="margin:1%">
                        <div class="col-md-4">
                            <div class="form-group row" style="margin-left:8%">
                             
                                    {{ Form::open(array('action'=> "AdminAuth\Microbiology\MicroController@daily_report",  'method'=>'post','class'=>'form-horizontal')) }}
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
                               
                                    {{ Form::open(array('action'=> "AdminAuth\Microbiology\MicroController@monthly_report",  'method'=>'post','class'=>'form-horizontal')) }}
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

                                {{ Form::open(array('action'=>"AdminAuth\Microbiology\MicroController@yearly_report", 'method'=>'post','class'=>'form-horizontal')) }}
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
                                
                                <div class="card-body">
                                    <form action="" method="post">
                                        <input type="hidden" name="_token" value="zZGTCQ8R7MuZv3xF0Kq4LT1EsUjYV3YZgwuXIS6F">
                                    <table id="order-table" class="table table-striped table-bordered table dataTable" style="overflow-x:scroll">
                                        <thead>
                                            <tr><th>#</th>
                                                <th>Product</th>
                                                <th>Test conducted</th>
                                                <th>Assigned To</th>
                                                <th>Approvals</th>
                                                <th>Evaluation</th>
                                                <th>Grade</th>
                                                <th>Date Analysed</th>  
                                                <th>Action</th>                  
                                            </tr>
                                        </thead> 
                                        <tbody> 
                                            @foreach ($completed_products as $completed_product)                                      
                                            <tr>
                                            <td> 
                                                <div class="">
                                                    <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="evaluated_product[]" class="custom-control-input" value="{{$completed_product->id}}">
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="font">
                                                <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                    {{$completed_product->code}}
                                               </span>
                                            <td class="font">
                                                <li ><small class="">
                                                    @if (count($completed_product->loadAnalyses)>0)
                                                    {{count($completed_product->loadAnalyses)}} Microbial Load Analysis
                                                    @endif
                                                </li>  
                                                    {{-- @foreach ($microproduct_completedtest->loadAnalyses->groupBy('id')->first() as $loadnalyses)
                                                    @endforeach --}}
                                                    <li>
                                                    @if (count($completed_product->efficacyAnalyses)>0)
                                                    & {{count($completed_product->efficacyAnalyses)}} Efficacy Analysis
                                                    @endif
                                                    </li>
                                                 
                                            </td>
                                            <td class="font">
                                                {{\App\Admin::find($completed_product->micro_analysed_by)? \App\Admin::find($completed_product->micro_analysed_by)->full_name:'null'}} 

                                                {{-- @if (count($completed_product->loadAnalyses)>0)
                                                @foreach($completed_product->microbialloadReports->groupBy('id')->first() as $report)
                                                {{\App\Admin::find($report->added_by_id)? \App\Admin::find($report->added_by_id)->full_name:'null'}} 
                                                @endforeach 
                                                @endif 
                                                <br>
                                                @if (count($completed_product->efficacyAnalyses)>0)
                                                @foreach($completed_product->microbialefficacyReports->groupBy('id')->first() as $report)
                                                {{\App\Admin::find($report->added_by_id)? \App\Admin::find($report->added_by_id)->full_name:'null'}}
                                                @endforeach 
                                                @endif --}}
                                            </td>
                                            <td class="font">
                                               <span style="font-size: 10px"> <strong>Approval 1:</strong> {{\App\Admin::find($completed_product->micro_approved_by)? \App\Admin::find($completed_product->micro_approved_by)->full_name:'null'}} </span><br>
                                             <span style="font-size: 10px">  <strong>Approval 2:</strong> {{\App\Admin::find($completed_product->micro_finalapproved_by)? \App\Admin::find($completed_product->micro_finalapproved_by)->full_name:'null'}} </span> 
                                           </td>
                                            <td class="font">{!! $completed_product->hod_evaluation !!}</td>

                                            
                                            <td class=""> 
                                                @if ($completed_product->micro_grade != Null)
                                                <strong>{!! $completed_product->micro_grade_report !!}</strong>
                                                @endif
                                            </td>

                                            <td class="font">
                                            {{$completed_product->micro_dateanalysed}}
                                            </td>
                                            <td class="font">
                                            <a target="_blank" href="{{ route('admin.micro.printreport',['id' => $completed_product->id]) }}"><i class="ik ik-eye f-16 mr-15 text-green"></i></a>
                                            </td>
                                            </tr>
                                        @endforeach    
                                        </tbody>
                                    </table>
                                 
                                    </form>
                                </div> 
                                
                            </div>
                    </div>
                
            </div>
        </div>
</div>
@endsection