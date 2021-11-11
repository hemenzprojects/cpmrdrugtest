@extends('admin.layout.main')

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-menu bg-blue"></i>
                <div class="d-inline">
                    <h5>Send Bulk Sms</h5>
                    <span>Please select customers below and send sms</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">all customers with completed reports</li>
                    
                </ol>
            </nav>
        </div>
     
    </div>
</div>
<form action="{{url('admin/sid/customer/sendsmscreate')}}" method="POST">
    {{ csrf_field() }}
<div class="row">
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-12">
                        <h3 class="card-title">Completed Product List</h3>
                        <div id="visitfromworld" style="width:100%; height:px"></div>
                    </div>
                        <div class="table-responsive">
                            <table id="scr-vtr-dynamic" class="table table-striped table-bordered ">      
                               <thead>
                                    <tr>
                                       <th></th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer_completed_reports as $item)
                                    <tr>
                                        <td></td>
                                        <td>{{$item->name}} 
                                            <span  style="background-color:#28a745; color:#fff">
                                                <span style="font-size: 0.1px">#completed</span> {{$item->code}}
                                            </span>  
                                        </td>
                                         <td>{{$item->customer->name}}</td>
                                        
                                         <td>
                                            <div class="form-check mx-sm-2">
                                                <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="customer_id[]" class="custom-control-input" value="{{$item->customer_id}}">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </div>
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
    <div class="col-md-4">
        <div class="card" style="min-height: 422px;">
            <div class="card-header"><h3>Message</h3></div>
            <div class="card-body">
                <textarea name="message" id="" cols="38" rows="22">Hello, Kindly visit our office for your report within a week or contact us if you prefer EMS Services. CPMR, Mampong-Akuapem

                </textarea>
                
            </div>
        </div>

        <button type="" class="btn btn-primary mr-2">Send Message</button>
    <button class="btn btn-light">Cancel</button>
    </div>

</div>
</form>
  
@endsection