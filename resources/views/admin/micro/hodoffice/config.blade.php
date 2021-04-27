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
                    <div class="card-header"><h3>Microbial Load Data Template</h3></div>
                    <div class="card-body">
                        <div class="row">
                    <div class="col-md-9">
                            
                                    <div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="demoModalLabel">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <form  class="forms-sample" action="{{url('admin/micro/config/microbialanalysis/create')}}" method="post">
                                                    {{ csrf_field() }}
                                                <div class="modal-body">
                                                                        
                                                        <div class="card-header"><h3>Create New feature</h3></div>
                    
                                                        <div class="form-group">
                                                            <label for="exampleInputName1">Test Name</label>
                                                            <input type="text" required name="test_conducted" class="form-control"  placeholder="Name">
                                                            @error('test_conducted')
                                                            <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                                                <strong>{{$message}}</strong>
                                                            </small>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputName1">Definition</label>
                                                            <input type="text" required name="definition" class="form-control"  placeholder="Definition">
                                                            @error('test_conducted')
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
                                                        
                                                        <input type="text" name="location" value="{{count($microbial_loadanalyses)}}">
                                                        
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Create feature</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <form  action="{{url('admin/micro/config/microbialanalysis/update')}}" method="post">
                                            {{ csrf_field() }}
                                        <table class="table table-hover">                      
                                            <tbody>
                                                <tr>
                                                    <th>Activate</th>
                                                    <th>Test</th>
                                                    <th>Result</th>
                                                    <th>Acceptance Criterion 
                                                    <span class="font">
                                                        (BP @foreach ($microbial_loadanalyses->groupBy('id')->first()  as $item)
                                                         {{Carbon\Carbon::parse($item->date)->format('Y')}}
                                                        @endforeach )
                                                    </span>
                                                    </th>
                                                    <th>Definition</th>
                                                    <th> <button type="button" class="btn btn-success" data-toggle="modal" data-target="#demoModal">New</button> </th>
                                                    
                                                </tr>
                                                @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
                                                <tr>
                                                    
                                            
                                                <td> 
                                                        <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="microbial_loadanalyse_id[]" value="{{$microbial_loadanalyses[$i]->id}}" class="custom-control-input">
                                                            <span class="custom-control-label">&nbsp;</span>
                                                        </label>
                                                        <input type="hidden" name="location[{{$i}}]" value="{{$i}}">

                                                </td>

                                                <td style="display: none"> 
                                                    <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="mloadanalyse_id[{{$i}}]" value="{{$microbial_loadanalyses[$i]->id}}" class="custom-control-input" checked>
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                            </td>
                                                <td class="font"><input class="form-control" style="width:220px" type="text" name="name[{{$i}}]" value="{{$microbial_loadanalyses[$i]->test_conducted}}" {{$microbial_loadanalyses[$i]->location == 0 || $microbial_loadanalyses[$i]->location == 1 ? "readonly" : "" }}></td>
                    
                                                <td class="font"><input class="form-control" type="text" name="result[{{$i}}]" value="{{$microbial_loadanalyses[$i]->result}}"></td>
                                            
                                                <td class="font"><input class="form-control" type="text" name="acceptance_criterion[{{$i}}]" value="{{$microbial_loadanalyses[$i]->acceptance_criterion}} "></td>
                                                <td class="font" style="font-size: 10px">
                                                    {{$microbial_loadanalyses[$i]->definition}} 
                                                    <input class="form-control" type="hidden" name="definition[{{$i}}]" value="{{$microbial_loadanalyses[$i]->definition}}">

                                                @if ($microbial_loadanalyses[$i]->definition ==Null)
                                                        <p style="font-size: 10px">None</p>

                                                @endif
                                                <input class="form-control" type="hidden" name="loadanalysisdate[{{$i}}]" value="{{$microbial_loadanalyses[$i]->date}}">
                                                </td>
                                            
                                                <td> 
                                                    {{-- <button type="button" name="remove" class="btn btn-danger btn_remove">X</button> --}}
                                                </td>
                                                </tr>  
                                                @endfor   
                                            
            
                                            </tbody>
                                        </table>
                                    
                                        <div class="row">
                                            <div class="col-md-3">
                                                    <div class="form-group">
                                                        <select required name="action" class="form-control" id="exampleSelectGender">
                                                    <option value=""> Select Action</option>                                        
                                                        <option  value="1" >Activate</option>
                                                        <option  value="2" >Update Template</option>
                                                        </select>
                                                    </div>    
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" type="date" name="date">
                                            </div>
                                            <div class="col-md-5">
                                                <button type="submit" class="btn btn-primary mr-2">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                    </div>
                    <div class="col-md-3">
                            <div class="alert alert-warning" role="alert">
                                @foreach ($microbial_loadanalyses_admin as $item)
                                <ul><li>{{$item->test_conducted}}</li></ul>  
                                @endforeach
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
                            <div class="modal fade" id="demoModal1" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="demoModalLabel1">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <form  class="forms-sample" action="{{url('admin/micro/config/microbialefficacy/create')}}" method="post">
                                            {{ csrf_field() }}
                                        <div class="modal-body">
                                                                  
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
            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Create feature</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <form  action="{{url('admin/micro/config/microbialefficacy/update')}}" method="post">
                                    {{ csrf_field() }}
                                <table class="table table-inverse">                      
                                    <tbody>
                                        <tr>
                                            
                                            <th>Activate</th>
                                            <th>Pathogen</th>
                                            <th>Pi Zone</th>
                                            <th>Ci Zone</th>
                                            <th>Fi Zone</th>
                                            <th> <button type="button" class="btn btn-success" data-toggle="modal" data-target="#demoModal1">New</button> </th>


                                        </tr>
                                        @foreach ($microbial_efficacys as $microbial_efficacy)
                                        <tr>
                                            <td > 
                                
                                                <div class="form-check mx-sm-2">
                                                    <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="microbial_efficacy_id[]" value="{{$microbial_efficacy->id}}" class="custom-control-input">
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </div>
                                                <div class="form-check mx-sm-2" style="display: none">
                                                    <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="microbialefficacy_id[]" value="{{$microbial_efficacy->id}}" class="custom-control-input" checked>
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </div>
                                            </td>
                                        <td class="font"><input class="form-control" style="width:180px" type="text" name="pathogen[]" value="{{$microbial_efficacy->pathogen}}"></td>
            
                                        <td class="font"><input class="form-control" type="text" name="pi_zone[]" value="{{$microbial_efficacy->pi_zone}} "></td>
                                       
                                        <td class="font"><input class="form-control" type="text" name="ci_zone[]" value="{{$microbial_efficacy->ci_zone}} "></td>
                                        <td class="font"><input class="form-control" type="text" name="fi_zone[]" value="{{$microbial_efficacy->fi_zone}} "></td>
                                     
                                        <td></td>
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
                                                <option  value="1" >Activate</option>
                                                <option  value="2" >Update Template</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                           
                            <div class="col-md-3">
                                <div class="alert alert-warning" role="alert">
                                    @foreach ($microbial_efficacyanalyses_admin as $item)
                                     <ul><li>{{$item->pathogen}}</li></ul>  
                                    @endforeach
                                 </div>
                    
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
            <div class="card">
                <div class="card-header"><h3>General Conclusions</h3></div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-8">
                        <div class="card-body p-0 table-border-style">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Conclusion</th>
                                            <th>#</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($micro_report_conclusions as $item)
                                        <tr>
                                            <td class="font">{{$item->title}}</td>
                                            <td class="font">{{$item->default_conclusion}}</td>
                                        <td class="font">
                                        <i class="ik ik-edit-2" data-toggle="modal" data-target="#exampleModalCenter{{$item->id}}"></i>
                                        </td>

                                        </tr>
                                    <div class="modal fade" id="exampleModalCenter{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form  class="forms-sample" action="{{url('admin/micro/config/conclusions/update')}}" method="post">
                                                    {{ csrf_field() }}  
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterLabel">Default Conclusion</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                                 <input type="hidden" name="item_id" value="{{$item->id}}">
                                                          <div class="form-group">
                                                            <label for="exampleInputName1">Title</label>
                                                            <input type="text" class="form-control" name="title" placeholder="Title" value="{{$item->title}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputName1">Conclusion</label>
                                                        <textarea class="form-control"  name="conclusion" rows="4">{{$item->default_conclusion}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                              </form>

                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                     <form  class="forms-sample" action="{{url('admin/micro/config/conclusions/create')}}" method="post">
                            {{ csrf_field() }}           
                          <div class="form-group">
                            <label for="exampleInputName1">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Conclusion</label>
                            <textarea class="form-control"  name="conclusion" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection