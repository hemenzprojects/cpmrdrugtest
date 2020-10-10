@extends('admin.layout.main')

@section('content')
 
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    
                    <div class="d-inline">
                    <h5>List of Product Types</h5>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
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
               <a href="{{route('admin.micro.completed_reports.index',['id' => $product_type->id])}}">
                    <div class="card-block text-center">
                        <div class="state">
                            @foreach ($completed_products->where('product_type_id',$product_type->id)->groupBy('id') as $item)
                            <h2 style="color: red"> {{count($item)}}</h2>
                            @endforeach
                                    
                        </div>
                        <small class="text-small mt-10 d-block">Total number of product Completed</small>
                    </div>
                </a>
           
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- <div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    
                    <div class="d-inline">
                        <h5>General Report Section</h5>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
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
            <div class="col-md-12">
            <div class="card">
                    <div class="card-body">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Report(s) Withheld</h6>
                                                                                        </div>
                                            <div class="icon">
                                                <i class="ik ik-alert-circle"></i>
                                            </div>
                                        </div>
                                        <small class="text-small mt-10 d-block">Total number of product withheld</small>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6> Approved Report(s)</h6>
                                                                                        </div>
                                            <div class="icon">
                                                <i class="ik ik-thumbs-up"></i>
                                            </div>
                                        </div>
                                        <small class="text-small mt-10 d-block">Total number of report in Approved</small>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Completed Report(s) </h6>
                                                
                                                <h2>1</h2>
                                                                                        </div>
                                            <div class="icon">
                                                <i class="ik ik-calendar"></i>
                                            </div>
                                        </div>
                                        <small class="text-small mt-10 d-block">Total number of report completed</small>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                <th>Evaluation</th>
                                                <th>Date Analysed</th>  
                                                <th>Action</th>                  
                                            </tr>
                                        </thead> 
                                        <tbody> 
                                                
                                        </tbody>
                                    </table>
                                 
                                    </form>
                                </div> 
                                
                            </div>
                    </div>
                </div>
            </div>
        </div>
</div> --}}
@endsection