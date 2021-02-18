@extends('admin.layout.main')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="text-center" style="margin: 2%"> 
                    <h4 class="font" style="font-size:18px">Generate Report on Conducted Experiments</h4>
                   <p class="card-subtitle"> Select date below to generate report</p>
                  </div>
                <div class="row" style="margin:1%">
                
                    <div class="col-lg-6">
                      
                       
                    </div>
                </div>
            </div>
            <div class="card-header row">
                <div class="col col-sm-3">
                    Total Quantity: 
                    <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                       {{count($all_exp_conducteds)}} 
                    </label>
                </div>
                <div class="col col-sm-9">
                    <div class="card-search with-adv-search dropdown">
                        <form action="{{route('admin.pharm.completed_animalexperiment.report')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4">
                                    <span style="margin: 5">From</span>  <input type="date" name="from_date" class="form-control" value="2020-01-10">
                                </div>
                                <div class="col-md-4">
                                    <span style="margin: 5px">To</span>  <input type="date" name="to_date" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-4">
                                  
                                    <button style="margin-top: 20px" type="submit" class="btn btn-primary mr-2">search</button>  
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
               
            </div><br>
            <div class="dt-responsive">
               
                <table id="order-table_exp" class="table table-striped table-bordered nowrap">
                
                  
                <thead>
                <tr>
                
                    <th>Product</th>
                    <th>Test Conducted</th>
                    <th>Experiment By </th>
                    <th>No. of animals</th>
                    <th>No. of Death</th>
                    <th>Date of Experiment</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($all_exp_conducteds->sortByDesc('created_at') as $all_exp_conducted)
                    
                    <tr style="background-color: #fff">
                       
                        <td class="font">
                        <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$all_exp_conducted->id}}" title="View Product" href="">
                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                {{$all_exp_conducted->code}}
                            </span>
                        </a> 
                        
                        </td>
                        <td class="font">
                            @foreach ($all_exp_conducted->animalExperiment->unique('pharm_testconducted') as $item)
                            {{App\PharmTestConducted::find($item->pharm_testconducted_id)->name}}
                           
                            @endforeach
                        </td>
                     
                        <td class="font">
                        {{\App\Admin::find($all_exp_conducted->pharm_experiment_by)? \App\Admin::find($all_exp_conducted->pharm_experiment_by)->full_name:'null'}}

                        </td>
                        <td class="font">
                            @foreach ($all_exp_conducted->animalExperiment->groupBy('product_id') as $item)
                            {{count($item)}}
                            @endforeach                    
                        </td> 
                        <td class="font">
                            {{$all_exp_conducted->experimental_deaths}} Deaths <br>
                            {{$all_exp_conducted->experimental_Lives}} Lives 
                        </td> 
                        <td class="font">
                            (  @foreach($all_exp_conducted->animalExperiment as $temp)
                            @if($all_exp_conducted->animalExperiment->first() == $temp)
                            {{$temp->created_at->format('d/m/y')}}
                            @endif
                            @endforeach)
                        </td>
                        <td>
                            <a href="{{url('admin/pharm/completedexperiment/show',['id' => $all_exp_conducted->id])}}"><i class="ik ik-eye f-16 mr-15 text-green"></i></a>
   
                        </td> 
                    </tr>
                
                   @endforeach
                   
             </tbody>
            
            </table>
        </div>

           
        </div>
    </div>
</div>

@endsection