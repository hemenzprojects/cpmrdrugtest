@extends('admin.layout.main')

@section('content')
 
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-4">
                <div class="page-header-title" style="margin-bottom: 10px">
                    
                    <div class="d-inline">
                    <h5>REPORT STATISTICS</h5>
                        <span></span>
                    </div>
                </div>
                
                    {{-- {{ Form::open(array('action'=>"AdminAuth\Pharmacology\PharmController@generalyearly_report", 'method'=>'post','class'=>'form-horizontal')) }}
                        {{Form::token()}}
                        <div class="input-group">
                            {{ Form::selectRange('year',date('Y') -1, date('Y'), array('class'=>'form-control','placeholder'=>'')) }}
                            <button type="submit" class="btn btn-primary mr-2">Search</button>    
                        </span>
                        </div>
                   {{ Form::close() }}  --}}
                 
            </div>
            <div class="col-lg-6">
                <form action="{{route('admin.phyto.general_report.between_months')}}" method="POST">
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
            <div class="col-lg-2">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#"></a></li>
                        <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($product_types as $product_type)
        <div class="col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-header">
                <h3>{{$product_type->name}} Completed</h3>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a href="">
                            <div class="card-block text-center">
                                <div class="state">
                                    @foreach ($pending_products->where('product_type_id',$product_type->id)->groupBy('product_type_id') as $item)
                                    <h2 style="color: red"> {{count($item)}}</h2>
                                    @endforeach                                  
                                </div>
                                <small class="text-small mt-10 d-block">Total number of pending product</small>
                            </div>
                        </a>
                    </div>
                   
                    <div class="col-md-6">
                        <a href="{{route('admin.phyto.completed_reports.index',['id' => $product_type->id])}}">
                            <div class="card-block text-center">
                                <div class="state">
                                    @foreach ($completed_products->where('product_type_id',$product_type->id)->groupBy('product_type_id') as $item)
                                    <h2 style="color: green"> {{count($item)}}</h2>
                                    @endforeach                                  
                                </div>
                                <small class="text-small mt-10 d-block">Total number of completed product </small>
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
        <h4 class="font" style="font-size:18px; margin-top:20px">Number of Drug Analysis Report Completed from to </h4>


       </div>
    <div class="card-body">
        <table id="order-table" class="table table-striped table-bordered nowrap">
     <thead>
     <tr>
         <th>#</th>
         <th>Product Type</th>
         <th>Number of Product Received</th>
         <th>Number of Product Analysed</th>
     </tr>
     </thead>
     <tbody>
        @foreach ($product_types as $product_type)                                    
         <tr>
         <td class="font">{{$product_type->id}} </td>
         <td class="font"> {{$product_type->name}} </td>
         <td class="font"> 
              @foreach ($pending_products->where('product_type_id',$product_type->id)->groupBy('product_type_id') as $item)
            {{count($item)}}
             @endforeach   
         </td>
         <td class="font"> 
            @foreach ($completed_products->where('product_type_id',$product_type->id)->groupBy('product_type_id') as $item)
            {{count($item)}}
            @endforeach  
         </td>

         </tr>
        
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