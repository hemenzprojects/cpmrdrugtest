@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-server bg-blue"></i>
                    <div class="d-inline">
                        <h5>Sample Preparation</h5>
                        <span>Pharmacology sample preparation processes </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Sample preparation</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-12">

            <div class="card" style=" overflow-x: auto; overflow-y: auto;">
                <div class="card-header d-block">
                   
                    <h3>  @foreach($pharmproducts->groupBy('product_id') as $pharmproduct)
                        <label class="badge badge-warning" style="background-color:#f5365c; margin-right:5px;">
                           {{count($pharmproduct)}} 
                        </label>
                        @endforeach Input data of prepared samples</h3>
                    
                </div>
              
          
                <div class="card-body">
                <form action="{{route('admin.pharm.samplepreparation.search')}}" method="post">
                        {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                        <select name="otherlist" id="">
                            <option value="10" {{10 == $list ? "selected":""}}>10</option>
                            <option value="25" {{25 == $list ? "selected":""}}>25</option>
                            <option value="50" {{50 == $list ? "selected":""}}>50</option>
                            <option value="100" {{100 == $list ? "selected":""}}>100</option>
                        </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="date" class="form-control select2">
                                    <option value="" {{0 == $date? "selected":""}}>Select Period</option>
                                    <option value="1" {{1 == $date? "selected":""}}>Today</option>
                                    <option value="2" {{2 == $date? "selected":""}}>Weekly</option>
                                    <option value="3" {{3 == $date? "selected":""}}>Monthly</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="product_type_id" class="form-control select2">
                                    <option value="">Select Product Type </option>
                                    @foreach($product_types as $product_type)
                                    <option value="{{$product_type->id}}" {{$product_type->id == $product_type_id ? "selected":""}}>{{$product_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                           </div>
                           <div class="col-md-3">
                            <button type="submit" class="btn btn-primary mr-2">Search List</button>
                        </div>
                     </div>
                    </form>
                    
                    <form action="{{route('admin.pharm.samplepreparation.store')}}" method="post">
                        {{ csrf_field() }}
                    <div class="dt-responsive">
                        <table id="scr-vtr-dynamic" class="table table-striped table-bordered nowrap" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Weight</th>
                                <th>Dosage</th>
                                <th>Yield</th>
                                <th>Test Conducted</th>
                                <th>Date Received</th>

                            </tr>
                            </thead>
                            <tbody>
                                @if ($product_type_id < 1)
                                <?php $i = 0; ?>
                                @foreach($pharmproducts as $pharmproduct)
                                <?php $i++; ?>
                                <?php if(!($i > $list)) continue; ?>
                                  @include('admin.pharm.temp.samplepreparationtemp')
                                @endforeach 
                                @endif
                     
                                @if ($product_type_id > 0)
                                <?php $i = 0; ?>
                                @foreach($pharmproducts->where('product_type_id',$product_type_id) as $pharmproduct)
                                <?php $i++; ?>
                                <?php if(!($i <= $list)) continue; ?>
                                  @include('admin.pharm.temp.samplepreparationtemp')
                                @endforeach 
                                @endif
                         
                        </tbody>
                        </table>
                    </div>
                     <div class="row">
                        <div class="col-md-9">
                     
                        </div>
                        <div class="col-md-3">
                            <button onclick="return confirm('Please click Ok to confirm accurate data input')"  type="submit" class="btn btn-success mr-2">Save Record</button>
                        </div>
                     </div>
                    </form> 
                </div>
              
            </div>
       
    </div>
</div>
@endsection