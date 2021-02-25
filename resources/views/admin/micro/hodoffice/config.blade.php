@extends('admin.layout.main')

@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-settings bg-blue"></i>
                        <div class="d-inline">
                            <h5>Configuration</h5>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href=""><i class="ik ik-home"></i></a>
                            </li>

                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Configuration</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
         
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3> Microbial Load Data Template</h3></div>
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-8">
                                <form  action="{{url('admin/micro/config/microbialanalysis/update')}}" method="post">
                                    {{ csrf_field() }}
                                <table class="table table-inverse">                      
                                    <tbody>
                                        <tr>
                                            
                                            <th>Test</th>
                                            <th>Result</th>
                                            <th>Acceptance Criterion 
                                               <span class="font">
                                                (BP @foreach ($microbial_loadanalyses->groupBy('id')->first()  as $item)
                                                {{$item->expired_at}}
                                                   @endforeach )
                                               </span>
                                            </th>
                                            <th>Definition</th>
                                            <th>Hide/show</th>
                                        </tr>
                                        @foreach ($microbial_loadanalyses as $microbial_loadanalyse)
                                        <tr>
                                    
                                        <td class="font"><input class="form-control" style="width:220px" type="text" name="name[]" value="{{$microbial_loadanalyse->test_conducted}} :"></td>
            
                                        <td class="font"><input class="form-control" type="text" name="result[]" value="{{$microbial_loadanalyse->result}} "></td>
                                       
                                        <td class="font"><input class="form-control" type="text" name="acceptance_criterion[]" value="{{$microbial_loadanalyse->acceptance_criterion}} "></td>
                                        <td class="font" style="font-size: 10px">{{$microbial_loadanalyse->definition}} 
                                           @if ($microbial_loadanalyse->definition ==Null)
                                                <p style="font-size: 10px">None</p>
                                           @endif
                                        </td>
                                        <td > 
                                                <div class="form-check mx-sm-2">
                                                <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="microbial_loadanalyse_id[]" value="{{$microbial_loadanalyse->id}}" class="custom-control-input"{{$microbial_loadanalyse->action == 1 ?'checked':''}}>
                                                    <span class="custom-control-label">&nbsp;</span>
                                                </label>
                                            </div>
                                        </td>
                                        </tr>        
                                        @endforeach
    
                                     </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-3">
                                            <div class="form-group">
                                                <select required name="action" class="form-control" id="exampleSelectGender">
                                            <option value=""> Select Action</option>                                        
                                                <option  value="0" >Hide</option>
                                                <option  value="1" >Show</option>
                                                </select>
                                            </div>    
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="date" name="date">
                                    </div>
                                    <div class="col-md-5">
                                        <button type="submit" class="btn btn-primary mr-2">Update Template</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                           
                            <div class="col-md-4">
                                
                                <form  class="forms-sample" action="{{url('admin/micro/config/microbialanalysis/create')}}" method="post">
                                    {{ csrf_field() }}
    
                                    <div class="card-header"><h3>Create New feature</h3></div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Test</label>
                                        <input type="text" required name="test" class="form-control"  placeholder="Name">
                                        @error('test')
                                        <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                            <strong>{{$message}}</strong>
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Result</label>
                                        <input type="text" required name="result" class="form-control" placeholder="Feature">
                                        @error('result')
                                        <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                            <strong>{{$message}}</strong>
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Acceptance Criterion</label>
                                        <input type="text" required name="acceptance_criterion" class="form-control" placeholder="Feature">
                                        @error('acceptance_criterion')
                                        <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                            <strong>{{$message}}</strong>
                                        </small>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success mr-2">Create feature</button>
                                </form>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
         
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>Microbial Efficacy Data Template</h3></div>
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-8">
                                <form  action="{{url('admin/micro/config/microbialefficacy/update')}}" method="post">
                                    {{ csrf_field() }}
                                <table class="table table-inverse">                      
                                    <tbody>
                                        <tr>
                                            
                                            <th>Test </th>
                                            <th>Pathogen</th>
                                            <th>Pi Zone</th>
                                            <th>Ci Zone</th>
                                            <th>Fi Zone</th>

                                        </tr>
                                        @foreach ($microbial_efficacys as $microbial_efficacy)
                                        <tr>
                                    
                                        <td class="font"><input class="form-control" style="width:180px" type="text" name="pathogen[]" value="{{$microbial_efficacy->pathogen}} :"></td>
            
                                        <td class="font"><input class="form-control" type="text" name="pi_zone[]" value="{{$microbial_efficacy->pi_zone}} "></td>
                                       
                                        <td class="font"><input class="form-control" type="text" name="ci_zone[]" value="{{$microbial_efficacy->ci_zone}} "></td>
                                        <td class="font"><input class="form-control" type="text" name="fi_zone[]" value="{{$microbial_efficacy->fi_zone}} "></td>

                                        <td > 
                                
                                            <div class="form-check mx-sm-2">
                                                <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="microbial_efficacy_id[]" value="{{$microbial_efficacy->id}}" class="custom-control-input"{{$microbial_efficacy->action == 1 ?'checked':''}}>
                                                    <span class="custom-control-label">&nbsp;</span>
                                                </label>
                                            </div>
                                        </td>
                                        </tr>        
                                        @endforeach
    
                                     </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            @foreach ($microbial_efficacys->groupBy('id')->first()  as $item)
                                            {!! $item->ref !!}
                                               @endforeach 
                                            </div>

                                    </div>
                                    <div class="col-md-3">
                                            <div class="form-group">
                                                <select required name="action" class="form-control" id="exampleSelectGender">
                                            <option value=""> Select Action</option>                                        
                                                <option  value="0" >Hide</option>
                                                <option  value="1" >Show</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary mr-2">Update Template</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                           
                            <div class="col-md-4">
                                
                                <form  class="forms-sample" action="{{url('admin/micro/config/microbialefficacy/create')}}" method="post">
                                    {{ csrf_field() }}
    
                                    <div class="card-header"><h3>Create New feature</h3></div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Pathogen</label>
                                        <input type="text" required name="pathogen" class="form-control"  placeholder="pathogen">
                                        @error('pathogen')
                                        <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                            <strong>{{$message}}</strong>
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">PI Zone</label>
                                        <input type="text" required name="pi_zone" class="form-control" placeholder="pi_zone">
                                        @error('pi_zone')
                                        <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                            <strong>{{$message}}</strong>
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">CI Zone</label>
                                        <input type="text" required name="ci_zone" class="form-control" placeholder="ci_zone">
                                        @error('ci_zone')
                                        <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                            <strong>{{$message}}</strong>
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">FI Zone</label>
                                        <input type="text"  name="fi_zone" class="form-control" placeholder="fi_zone">
                                        @error('ci_zone')
                                        <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                            <strong>{{$message}}</strong>
                                        </small>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success mr-2">Create feature</button>
                                </form>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>

@endsection