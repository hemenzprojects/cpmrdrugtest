@extends('admin.layout.main')

@section('content')

<div class="">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-edit bg-blue"></i>
                            <div class="d-inline">
                                <h5>Pharm Completed Peports </h5>
                                <span>Bellow shows all completed reports from pharmacology</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pharm Completed Rports</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
              
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-12">
                            <h3 class="card-title">All Pharm completed products </h3>
                          </div>
                        <div class="col-md-12">
                          
                            <form  action="{{url('admin/sid/hod_office/pharm_completed_report/update')}}" class="forms-sample" method="POST">
                                {{ csrf_field() }}

                             <table id="scr-vtr-dynamic" class="table table-striped table-bordered nowrap dataTable">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>download</th>
                                        <th>Actions</th>

                                   </tr>
                                </thead>
                                <tbody>                                                
                                    @foreach($pharmcompletedreports as $product)
                                    <tr>
                                      
                                    <td class="font">{{$product->code}}</td>
                                    <td class="font">{{$product->name}}</td>
                                    <td class="font">
                                        @if ($product->pharm_hod_evaluation == 2)
                                        <a  target="_blank" href="{{route('admin.sid.print_pharmreport',['id' => $product->id])}}">
                                          <button type="button" class="btn btn-outline-success btn-rounded">Print Report</button>
                                      </a><br><br>
                                      <a href="{{route('admin.sid.pharmreport.pdf',['id' => $product->id])}}">
                                          <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                                        </a>   
                                        @endif
                                    </td>
                                    <td class="font">
                                        <div class="form-check mx-sm-2">
                                            <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input phytoselect" name="pharm_completedproduct_id[]"  value="{{$product->id}}" >
                                                <span class="custom-control-label">&nbsp; </span>
                                            </label>
                                        </div>
                                    </td>
 
                                    </tr>
                                   
                                    @endforeach
                                </tbody>
                            </table>
                              <button class="" type="submit"> Reject Reports</button>
                            </form>
         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
 </div>

@endsection
