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
                            <span style="margin: 5px">Lab(s)</span>  
                            <div class="form-group">
                                <select name="single_multiple_lab" class="form-control">
                                    <option value="" >None</option>
                                    <option value="1" {{$single_multiple_lab == 1 ? "selected":""}}>Single Lab</option>
                                    <option value="2" {{$single_multiple_lab == 2 ? "selected":""}}>Multiple Labs</option>
                                    <option value="3" {{$single_multiple_lab == 3 ? "selected":""}}>All Labs</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button style="margin-top: 20px" type="submit" class="btn btn-primary mr-2">Search </button>  
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
    
     <div class="card">
         <div class="card-bod" style="margin: 5px">
            <div class="text-center" style="padding: 10px"> 
                <h4 class="font" style="font-size:18px; ">Number of Drugs Analysed from {{ date("F Y", strtotime($from_date)) }} to {{ date("F Y", strtotime($to_date)) }} </h4>
                </div>
             <div class="row">
      
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget bg-primary">
                            <div class="widget-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="state">
                                        <h6>Products</h6>
                                        <h2>{{$products}}</h2>
                                    </div>
                                    <div class="icon">
                                        <i class="ik ik-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget bg-success">
                            <div class="widget-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="state">
                                        <h6>Single Lab</h6>
                                        <h2>{{$single_lab}}</h2>
                                    </div>
                                    <div class="icon">
                                        <i class="ik ik-clipboard"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget bg-success">
                            <div class="widget-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="state">
                                        <h6>Multiple Labs</h6>
                                        <h2>{{$multiple_labs}}</h2>
                                    </div>
                                    <div class="icon">
                                        <i class="ik ik-clipboard"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget bg-success">
                            <div class="widget-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="state">
                                        <h6>All  Labs</h6>
                                        <h2>{{$all_labs}}</h2>
                                    </div>
                                    <div class="icon">
                                        <i class="ik ik-clipboard"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
             </div>
         </div>
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

                                    @if ($single_multiple_lab == Null)
                                    @foreach ($product_type['pending'] as $item)
                                    <input type="hidden" name="pending_report_ids[]" value="{{$item->id}}">
                                    @endforeach
                                    <button type="submit" class="btn btn-outline-light btn-rounded" style="height:23%">
                                    <h2 style="color: red"> {{count($product_type['pending'])}}</h2>
                                    </button> 
                                    @endif

                                    @if ($single_multiple_lab == 1)
                                    @foreach ($product_type['singlelabpending'] as $item)
                                    <input type="hidden" name="pending_report_ids[]" value="{{$item->id}}">
                                    @endforeach
                                    <button type="submit" class="btn btn-outline-light btn-rounded" style="height:23%">
                                    <h2 style="color: red"> {{count($product_type['singlelabpending'])}}</h2>
                                    </button> 
                                    @endif

                                    @if ($single_multiple_lab == 2)
                                    @foreach ($product_type['multiplelabpending'] as $item)
                                    <input type="hidden" name="pending_report_ids[]" value="{{$item->id}}">
                                    @endforeach
                                    <button type="submit" class="btn btn-outline-light btn-rounded" style="height:23%">
                                    <h2 style="color: red"> {{count($product_type['multiplelabpending'])}}</h2>
                                    </button> 
                                    @endif
                                   
                                    @if ($single_multiple_lab == 3)
                                    @foreach ($product_type['all_labpending'] as $item)
                                    <input type="hidden" name="pending_report_ids[]" value="{{$item->id}}">
                                    @endforeach
                                    <button type="submit" class="btn btn-outline-light btn-rounded" style="height:23%">
                                    <h2 style="color: red"> {{count($product_type['all_labpending'])}}</h2>
                                    </button> 
                                    @endif


                                </div>
                                <small class="text-small mt-10 d-block">Total number of pending reports</small>
                            </div>
                        </form>
                      </div>
                  
                    <div class="col-md-6">
                            <form action="{{route('admin.sid.final_reports.index')}}" method="POST">
                                {{ csrf_field() }}
                            <div class="card-block text-center">
                                <div class="state">
                                    <input type="hidden" name="product_type_id" value="{{$product_type->id}}">

                                    <h5 style="font-size: 15px"> Completed </h5><hr>
                                    @if ($single_multiple_lab == Null)
                                    <button type="submit" class="btn btn-outline-light btn-rounded" style="height:23%">
                                        <h2 style="color: green"> {{count($product_type['completed'])}}</h2>
                                    </button> 
                                       <input type="hidden" name="single_multiple_lab" value="{{$single_multiple_lab}}">

                                       @foreach ($product_type['completed'] as $item)
                                       <input type="hidden" name="completed_reports[]" value="{{$item->id}}">
                                       @endforeach
                                    @endif

                                    @if ($single_multiple_lab == 1)
                                    <button type="submit" class="btn btn-outline-light btn-rounded" style="height:23%">
                                        <h2 style="color: green"> {{count($product_type['singlelabcompleted'])}}</h2>
                                    </button> 
                                    <input type="hidden" name="single_multiple_lab" value="{{$single_multiple_lab}}">

                                    @foreach ($product_type['singlelabcompleted'] as $item)
                                    <input type="hidden" name="singlelabcompleted[]" value="{{$item->id}}">
                                    @endforeach
                                    @endif
                                    @if ($single_multiple_lab == 2)
                                    <button type="submit" class="btn btn-outline-light btn-rounded" style="height:23%">
                                        <h2 style="color: green"> {{count($product_type['multiplelabcompleted'])}}</h2>
                                    </button>
                                    <input type="hidden" name="single_multiple_lab" value="{{$single_multiple_lab}}">

                                    @foreach ($product_type['multiplelabcompleted'] as $item)
                                    <input type="hidden" name="multiplelabcompleted[]" value="{{$item->id}}">
                                    @endforeach
                                    @endif
                                    @if ($single_multiple_lab == 3)
                                    <button type="submit" class="btn btn-outline-light btn-rounded" style="height:23%">
                                        <h2 style="color: green"> {{count($product_type['all_labcompleted'])}}</h2>
                                    </button>
                                    <input type="hidden" name="single_multiple_lab" value="{{$single_multiple_lab}}">

                                    @foreach ($product_type['all_labcompleted'] as $item)
                                    <input type="hidden" name="all_labcompleted[]" value="{{$item->id}}">
                                    @endforeach
                                    @endif
                                </div>
                                <small class="text-small mt-10 d-block">Total number of completed reports</small>
                            </div>
                            </form>
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
                <a href="{{route('admin.sid.reportindex.pdf',['from_date' => $from_date, 'to_date' => $to_date, 'smlab' => $single_multiple_lab])}}"> 
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
             <th>Number of product Received</th>
             <th>Number of Product Pending</th>
             <th>Number of Product Analysed</th>
         </tr>
         </thead>
         <tbody>

            @if ($single_multiple_lab == Null)
            @php 
            $i=0; 
            @endphp
            @foreach ($product_types as $product_type)                                    
             <tr>
             <td class="font">{{$i}} </td>
             <td class="font"> {{$product_type->name}} </td>
             <td class="font"> 
                 @php
                     $p = count($product_type['pending']);
                     $c = count($product_type['completed']);
                     echo ($p + $c); 
                 @endphp
             </td>
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
            @endif 


            @if ($single_multiple_lab == 1)
                      @php $i=0; @endphp
            @foreach ($product_types as $product_type)                                    
             <tr>
             <td class="font">{{$i}} </td>
             <td class="font"> {{$product_type->name}} </td>

             <td class="font"> 
                @php
                    $p = count($product_type['singlelabpending']);
                    $c = count($product_type['singlelabcompleted']);
                    echo ($p + $c); 
                @endphp
            </td>
             <td class="font"> 
                {{count($product_type['singlelabpending'])}}
             </td>
             <td class="font"> 
                {{count($product_type['singlelabcompleted'])}}
             </td>
             </tr>
            @php
               $i++; 
            @endphp
            @endforeach
            @endif 

            @if ($single_multiple_lab == 2)
                     @php $i=0; @endphp
            @foreach ($product_types as $product_type)                                    
             <tr>
             <td class="font">{{$i}} </td>
             <td class="font"> {{$product_type->name}} </td>
             <td class="font"> 
                @php
                    $p = count($product_type['multiplelabpending']);
                    $c = count($product_type['multiplelabcompleted']);
                    echo ($p + $c); 
                @endphp
            </td>
             <td class="font"> 
                {{count($product_type['multiplelabpending'])}}
             </td>
             <td class="font"> 
                {{count($product_type['multiplelabcompleted'])}}
             </td>
             </tr>
            @php
               $i++; 
            @endphp
            @endforeach
            @endif

            @if ($single_multiple_lab == 3)
             @php $i=0; @endphp
            @foreach ($product_types as $product_type)                                    
             <tr>
             <td class="font">{{$i}} </td>
             <td class="font"> {{$product_type->name}} </td>
             <td class="font"> 
                @php
                    $p = count($product_type['all_labpending']);
                    $c = count($product_type['all_labcompleted']);
                    echo ($p + $c); 
                @endphp
            </td>
             <td class="font"> 
                {{count($product_type['all_labpending'])}}
             </td>
             <td class="font"> 
                {{count($product_type['all_labcompleted'])}}
             </td>
             </tr>
            @php
               $i++; 
            @endphp
            @endforeach
            @endif
             
         </tbody>
         <tr>
            <th>    
            </th>
            <th>
               Total 
            </th>
            <th>
                @include('admin.sid.temp.reportforalltemp')
               
            </th>
           <th>
               @include('admin.sid.temp.reportpendingtotals')

           </th>
            <th>
                @include('admin.sid.temp.reportcompletedtotals')

            </th>
        </tr>
        </table>
        </div>
    </div>
</div>

@endsection