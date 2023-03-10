@extends('admin.layout.main')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-server bg-blue"></i>
                    <div class="d-inline">
                        <h5>Taskboard</h5>
                        <span>Pharmacology / Toxicology product experimentation processes </span>
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
                            <a href="#">Apps</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Taskboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
  @include('admin.pharm.temp.animalexptaskboard')
 <form action="{{route('admin.pharm.animalexperiment.store')}}" method="post">
    {{ csrf_field() }}
    <div class="card">
        <div class="card-body">
            <ul class="nav justify-content-center" style="margin-top: 10px"> 
                <h5>Animal Experimentation Form</h5><hr>
            </ul><br>
            <div class="row">
                                   
                  <div class="col-sm-4">
                    <label for="exampleSelectGender"> Product at the lab</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"></div>
                        </div>
                        {{-- need to check  --}}
                          <select required name="product_id" id="pharmproduct_id"  style="" class="form-control select2" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option value="">Select Product</option>
                            @foreach($animalexps as $animalexp)
                            @foreach($animalexp->pharmsamplePreparation as $item)  
                            <option spvolume="{{$item->pivot->measurement}}"   product_ma="{{$item->pivot->pharm_testconducted_id}}"  value="{{$item->pivot->product_id}}" {{$item->pivot->product_id== old('product')? "selected":""}}>{{\App\Product::find($item->pivot->product_id)->code}}</option>
                            @endforeach
                            @endforeach
                         </select>

                      </div>
                      {{-- this is to get value from samplePreparation table and input in Animal exp form  --}}

                    <div>
                        @error('product_id')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                    </div>
                  </div>            
               
                   <div class="col-sm-4">

                    <div class="form-group">
                        <label for="exampleSelectGender">Test to be conducted</label>
                        <input type="text" class="form-control" id="pharmtest0" value="" placeholder="Test" onkeypress="return false;">
                    </div>

                    <div class="form-group" style="display: none">
                        <label for="exampleSelectGender">Testconducted</label>
                        <select class="form-control" id="pharmtest" name="pharm_testconducted">
                            <option  value="1">Acute Toxicity Test</option>
                            <option value="2">Dermal  Toxicity Test</option>
                            <option value="3">Acute / Dermal  Toxicity Test</option>

                        </select>
                    </div>
               
                   </div>
               <div class="col-sm-4">
                    @foreach( $errors->all() as $error)
                    <li style="color: red">{{$error}}</li>
                    @endforeach
               </div>
                    
            </div><br>
        
            <div class="dt-responsive" style="overflow-x:auto;">
                <ul class="nav justify-content-center" style="margin-top: 10px"> 
                    <h6></h6><hr>
                </ul><br>
                <table class="table table-striped table-bordered table-sm"  id="dynamic_field" style="scrollX: true">
                    
                    <thead>
                    <tr>
                        
                        <th>Animal Model
                        </th>
                        <th>Weight</th>
                        <th>Dosage</th>
                        <th>Route of Administration </th>
                        <th>Time of Administration</th>
                        <th>SignsofToxicity<br>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-12">
                                      <label class="custom-control custom-checkbox">
                                          
                                          <input type="checkbox" id="toxicity1" class="custom-control-input" value="1"><span></span>
                                      <span class="custom-control-label">All Nill</span>
                                  </label>
                            </div> 
                        </th>
                        <th>Death</th>
                        <th>Time of Death</th>
                        <th> Sex<br>
                           <div class="row" style="margin-top: 10px">
                              <div class="col-md-6">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" id="male_sex" class="custom-control-input" value="1"><span></span>
                                    <span class="custom-control-label">M</span>
                                </label>
                                </div> 
                                <div class="col-md-6">
                                        <label class="custom-control custom-checkbox">
                                      <input type="checkbox" id="female_sex" class="custom-control-input" value="2"> 
                                        <span class="custom-control-label">F</span>
                                    </label>
                                </div>
                           </div>
                        </th>

                        <th><button type="button" name="add" id="add" class="btn btn-success">Add</button>
                        </th>
                    </tr>
                    </thead>

                </table>
             
            </div>
        </div>

        <div class="card">
            
        <div class="row" style="margin: 2%">
            <div class="col-md-12">
                <div class="row">
                <div class="col-md-3">
                    <label for="">Total number of days observed</label>
                    <input type="number" required placeholder=" Total number of days observed" class="form-control" name="total_days" value="">   
                </div>

                <div class="col-md-3">
                    <label for="">Number of Group</label>
                    <input type="number" required placeholder="Group" class="form-control" name="group" value="">   
                </div>
                <div class="col-md-6">
                    <label for="">Comment</label>
                    <textarea class="form-control" name="expcomment" id="" cols="50" rows="2" placeholder="comment"></textarea>
                </div>
            </div>
            </div>
            
        </div>
        <div class="col-md-3">   
            <button type="submit" onclick="return confirm('Great work done. Please ensure that all input fields are correct as compare to the experiment made. If set click Ok else cancel to continue report process. Thank you')" class="btn btn-primary mb-2"> Complete Experiment</button>
        </div>
        </div>
     </div> 
   </form>
</div>

<div class="col-md-6"> 
    <div class="container">
       
    </div>
</div>
@endsection



