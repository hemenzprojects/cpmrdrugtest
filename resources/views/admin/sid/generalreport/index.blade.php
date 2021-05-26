@extends('admin.layout.main')

@section('content')
 
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-3">
                    <div class="page-header-title" style="margin-bottom: 10px">
                        <div class="d-inline">
                            <h5>REPORT STATISTICS</h5>
                            <span><p>NB: The data shows report of distributed and accepted products by departments</p></span>
                        </div>
                    </div>
                    {{-- {{ Form::open(array('action'=>"AdminAuth\SID\SIDController@generalyearly_report", 'method'=>'post','class'=>'form-horizontal')) }}
                        {{Form::token()}}
                        <div class="input-group">
                            {{ Form::selectRange('year',date('Y') -1, date('Y'), isset($year) ?? $year, array('class'=>'form-','placeholder'=>'Select year')) }}
                            <button type="submit" class="btn btn-primary mr-2">Search</button>    
                        </span>
                        </div>
                   {{ Form::close() }}  --}}
            </div>
            <div class="col-lg-9">
                <form action="{{route('admin.sid.general_report.between_months')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                            <span style="margin: 5px">From</span>  <input type="date" name="from_date" class="form-control" value="2020-01-10">
                        </div>
                        <div class="col-md-3">
                            <span style="margin: 5px">To</span>  <input type="date" name="to_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-2">
                            <span style="margin: 5px">Lab</span>  
                            <div class="form-group">
                                <select name="single_multiple_lab" class="form-control">
                                    <option value="1">Single Lab</option>
                                    <option value="2">Multiple Lab</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button style="margin-top: 20px" type="submit" class="btn btn-primary mr-2">search</button>  

                        </div>
                    </div>
                    
                </form>
               
            </div>
            {{-- <div class="col-lg-2">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#"></a></li>
                        <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                </nav>
            </div> --}}
        </div>
    </div>
    <div class="text-center" style="padding: 10px"> 
    <h4 class="font" style="font-size:18px; ">Number of Drugs Analysed from {{ date("F Y", strtotime($from_date)) }} to {{ date("F Y", strtotime($to_date)) }} </h4>
    </div>
    <div class="row">
        @foreach ($product_types as $product_type)
        <div class="col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-header">
                <h3>{{$product_type->name}} Reports</h3>
                </div>
                <div class="row">
                    

                     <div class="col-md-6">
                        <form action="{{route('admin.sid.pending_reports.index',['id' => $product_type->id])}}" method="POST">
                            {{ csrf_field() }}
                            <div class="card-block text-center">
                                <div class="state">
                                    <h5 style="font-size: 15px">Pending </h5><hr>
                                    @foreach ($product_type['pending'] as $item)
                                    <input type="hidden" name="pending_report_ids[]" value="{{$item->id}}">
                                    @endforeach
                                    <button type="submit" class="btn btn-outline-light btn-rounded" style="height:23%">
                                    <h2 style="color: red"> {{count($product_type['pending'])}}</h2>
                                    </button>       
                                </div>
                                <small class="text-small mt-10 d-block">Total number of pending reports</small>
                            </div>
                        </form>
                      </div>
                  
                    <div class="col-md-6">
              
                        <a href="{{route('admin.sid.final_reports.index',['id' => $product_type->id])}}">
                            <div class="card-block text-center">
                                <div class="state">
                                    <h5 style="font-size: 15px">Completed </h5><hr>
                                    <h2 style="color: green"> {{count($product_type['completed'])}}</h2>
                                    
                                            
                                </div>
                                <small class="text-small mt-10 d-block">Total number of completed reports</small>
                            </div>
                         </a>
                    </div>
                </div>
           
           
            </div>
        </div>
        @endforeach
    </div>
    <div class="card">
        <div class="text-center"> 
            <div class="row">
                <div class="col-md-9">
                    <h4 class="font" style="font-size:18px; margin-top:20px">Number of Drug Analysis Report Completed from {{ date("F Y", strtotime($from_date)) }} to {{ date("F Y", strtotime($to_date)) }} </h4>
                </div>
                <div class="col-md-3">
                <a href="{{route('admin.sid.reportindex.pdf',['from_date' => $from_date, 'to_date' => $to_date])}}"> 
                        <h6 class="font" style="font-size:15px; margin-top:20px; color:red">download pdf</h6>
                </a>
                </div>
            </div>
    
           </div>
        <div class="card-body">
            <table id="general-report" class="table table-striped table-bordered nowrap">
         <thead>
         <tr>
             <th>#</th>
             <th>Product Type</th>
             <th>Number of Product Received</th>
             <th>Number of Product Analysed</th>
         </tr>
         </thead>
         <tbody>
             @php $i=0; @endphp
            @foreach ($product_types as $product_type)                                    
             <tr>
             <td class="font">{{$i}} </td>
             <td class="font"> {{$product_type->name}} </td>
             <td class="font"> 
                {{count($product_type['pending'])}}
             </td>
             <td class="font"> 
                {{count($product_type['completed'])}}
             </td>
             </tr>
            @php
               $i++; 
            @endphp
            @endforeach
             
         </tbody>
         <tr>
            <th>Total</th>
            <th></th>
            <th>Total</th>
            <th>Total</th>
        </tr>
        </table>
        </div>
    </div>
</div>

@endsection