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
                        <span>Pharmacology product experimentation processes </span>
                        
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


        <div class="card">
            <div class="card-body">

            <form action="{{url('admin/pharm/animalexperiment/update',['id' =>$editexperiment->id ])}}" method="post">
                {{ csrf_field() }} 
            
                        {{-- <ul class="nav justify-content-center" style="margin-top: 10px"> 
                            <h5> </h5> -
                        <h6> {{\App\PharmTestConducted::find($editexperiment->pharm_testconducted)->name}}</h6>                                          
                        </ul>
                         --}}
                         <div class="row">
                                   
                            <div class="col-sm-4">
                              <label for="exampleSelectGender">Edit Experiment result</label>
                              <div class="input-group mb-2 mr-sm-2">
                                  <div class="input-group-prepend">
                                      <div class="input-group-text"></div>
                                  </div>
                                 
                                 
                                    <select required name="product_id" id="pharmproduct_id"  style="" class="form-control select2" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                      <option value="">Select Product</option>
                                      <option value="{{$editexperiment->id}}" {{$editexperiment->id == $editexperiment->id? "selected":""}}>{{$editexperiment->code}}</option>
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
                              <div class="form-group" style="display: none">
                                  <label for="exampleSelectGender">Testconducted</label>
                                  <select class="form-control" id="pharmtest" name="pharm_testconducted">
                                      <option  value="1">Acute Toxicity Test</option>
                                      <option value="2">Dermal  Toxicity Test</option>
                                  </select>
                              </div>
                         
                         </div>
                         <div class="col-sm-4">
                              @foreach( $errors->all() as $error)
                              <li style="color: red">{{$error}}</li>
                              @endforeach
                         </div>
                              
                      </div><br>
                  
                    {{-- <input type="hidden" name="pharm_testconducted" value="{{$editexperiment->pharm_testconducted}}"> --}}
                        <ul class="nav justify-content-center" style="margin: 20px"> 
                            <h6 ></h6>
                        </ul>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm"  id="dynamic_field" style="scrollX: true">
                                <thead>
                                    <tr>
                                    
                                <th>Animal Model
                                </th>
                                <th>Weight</th>
                                <th>Dosage</th>
                                <th>Route of Administration </th>
                                <th>Time of Administration</th>
                                <th>Signs of Toxicity<br>
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
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($editexperiment->animalExperiment as $product)

                                    <tr>
                                        <td class="font">                              
                                            <input type="hidden" name="oldproduct_id" value="{{$editexperiment->id}}">
                                                <div class="form-group">
                                                    <select class="form-control select2" name="animalmodel[]" style="width:170px;">
                                                        @foreach (\App\PharmAnimalModel::all() as $animalmodel)  
                                                        <option  value="{{$animalmodel->id}}" {{$product->animal_model == $animalmodel->id? "selected":""}}>
                                                            {{$animalmodel->name}}
                                                        </option>  
                                                        @endforeach 
                                                    </select>   
                                                </div>
                                            
                                        </td>
                                        <td class="font">    
                                        
                                            <input class="form-control" type="text" name="weight[]" value="{{$product->weight}}" style="width:70px"><br>
                                        
                                        </td>
                                        <td class="font">
                                        
                                            <input class="form-control" type="text" name="dosage[]" value="{{$product->dosage}}"><br>
                                    
                                        </td>

                                        <td class="font"> 
                                        
                                            <div class="form-group"> 
                                                <select class="form-control select2" name="method_of_admin[]" style="width:170px">
                                                    <option value="{{$product->method}}">{{$product->animal_method}}</option>                                                     
                                                    <option value="1">Oral</option><option value="2">Subcutanious</option>
                                                    <option value="3">Intradermal</option>
                                                    <option value="4">Intra Veinous</option>
                                                    <option value="5">Applied Topical</option>
                                                    <option value="6">Applied Topical & Intrademal</option>
                                                </select>
                                                </div>
                                        
                                        </td>

                                        <td class="font">
                                            
                                        <input class="form-control" type="text" name="time_administration[]" value="{{$product->time_administration}}"><br>
                                
                                        </td>

                                        <td class="font" >
                                                                                                                    
                                        <div class="form-group">
                                            <ul><li style="font-size:10p"> @foreach ($product['toxicity'] as $itm) 
                                                {{$itm}}  
                                              @endforeach 
                                            </li></ul> 
                                        <select class="form-control select2 toxicity1" name="toxicity[{{$loop->index}}][]" multiple style="width:170px">
                                            <option selected>
                                                @foreach ($product['toxicity'] as $itm) 
                                                {{$itm}}  
                                              @endforeach 
                                        </option>
                                        @foreach (\App\PharmToxicity::all() as $toxicity)  
                                        <option  value="{{$toxicity->name}}" {{$product->toxicity == $toxicity->id? "selected":""}}>
                                            {{$toxicity->name}}
                                        </option>  
                                        @endforeach                                                
                                        </select>
                                        </div>
                                    
                                        </td>

                                        <td class="font">
                                            <div class="form-group"> 
                                            <select class="form-control select2" name="death[]" style="width:70px">
                                                <option value="{{$product->death}}">{{$product->no_death}}</option>                
                                                <option value="1"> Yes </option>
                                                <option value="2"> No </option>

                                            </select>
                                            </div>
                                        </td> 


                                        <td class="font">
                                        <input class="form-control" type="text" name="time_death[]" value="{{$product->time_death}}"><br>
                                    

                                    </td>

                                        <td class="font">
                                            <div class="form-group"> 
                                                <select class="form-control select2" name="sex[]" style="width:100px">
                                                    <option value="{{$product->sex}}">{{$product->animal_sex}}</option>                                                     
                                                    <option value="1"> Male </option>
                                                    <option value="2"> Female </option>
                                                </select>
                                            </div>                        
                                        </td>
                                
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-4" style="margin: 10px">
                                <label for=""> Total Number of Days</label>
                                @foreach ($editexperiment->animalExperiment as $product)
                                @if($editexperiment->animalExperiment->first() == $product)
                                <input required class="form-control" type="text" name="total_days" value="{{$product->total_days}}">
                                @endif
                                @endforeach
                            </div>
                        
                            <div class="col-md-4" style="margin: 10px">
                                <label for=""> Group</label>
                                @foreach ($editexperiment->animalExperiment as $product)
                                @if($editexperiment->animalExperiment->first() == $product)
                            <input type="text" class="form-control" name="group" value="{{$product->group}}">
                            @endif
                            @endforeach
                            </div>

                        </div>
        
                <div class="modal-footer">
                    <a href="{{route('admin.pharm.animalexperimentation.maketest')}}"><span class="btn btn-secondary">New Test</span></a>    
                            <button class="btn btn-primary">Save changes</button>
                </div>
        </form>
        </div>
        </div>

</div>
@endsection



