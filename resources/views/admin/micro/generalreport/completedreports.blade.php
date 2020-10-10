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
                    <div class="row" style="margin:1%">
                    
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Daily Report</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Search</button>    
                                 </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Monthly Report</label>
                                {{ Form::open(array('action'=> "yearly Orders",  'method'=>'post','class'=>'form-horizontal')) }}

                                {{form::token()}}
                                <div class="input-group">
                                    {{ Form::selectRange('year', date('Y') -2, date('Y'),Input::old('year'),array('class'=>'','placeholder'=>'')) }}
                
                                    <button class="" type="submit">Go!</button>
                                    </span>
                                </div>
                                
                                {{ Form::close() }}                                      
                             </div>
                        </div>
                
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Yearly Report</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
                                    
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">search</button>                                       
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
@endsection