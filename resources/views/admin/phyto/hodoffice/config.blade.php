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
                            <li class="breadcrumb-item active" aria-current="page">Config</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Organolepticts Template</h4></div>
                    <div class="card-body">
                       <div class="row">
                        <div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="demoModalLabel">Organolepticts</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <form  class="forms-sample" action="{{url('admin/phyto/config/organoleptics/create')}}" method="post">
                                        {{ csrf_field() }}
        
                                    <div class="modal-body">
                                                                    
                                            <div class="card-header"><h3>Create New feature</h3></div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Name</label>
                                                <input type="text" required name="name" class="form-control"  placeholder="Name">
                                                @error('name')
                                                <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Feature</label>
                                                <input type="text" required name="feature" class="form-control" placeholder="Feature">
                                                @error('feature')
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
                           <div class="col-md-8">
                           <form  class="" action="{{url('admin/phyto/config/organoleptics/update')}}" method="post">
                                {{ csrf_field() }}
                                <table class="table table-inverse">                      
                                    <tbody>
                                        <tr>
                                            <th>Activation</th>
                                            <th>Name</th>
                                            <th>Feature</th>
                                            <th><button type="button" class="btn btn-success" data-toggle="modal" data-target="#demoModal">New</button></th>
                                        </tr>
                                        
                                        @for ($i = 0; $i < count($phyto_organoleptics); $i++)

                                        <tr>
                                            <td > 
                                
                                                <div class="form-check mx-sm-2">
                                                    <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="organo_item[]" value="{{$phyto_organoleptics[$i]->id}}" class="custom-control-input">
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="organo_item_id[]" value="{{$phyto_organoleptics[$i]->id}}">
                                                </td>
                                        <td class="font"><input type="text" name="name[]" value="{{$phyto_organoleptics[$i]->name}} "></td>

                                        <td class="font"><input class="form-control" type="text" name="feature[]" value="{{$phyto_organoleptics[$i]->feature}}"></td>
                                     
                                        </tr>        
                                        @endfor
                                     </tbody>
                                </table>
                                    <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <select required name="action" class="form-control" id="exampleSelectGender">
                                                <option value=""> Select Action</option>                                        
                                                    <option  value="1" >Activate</option>
                                                    <option  value="2" >Update Template</option>
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
                            <div class="alert alert-warning" role="alert">
                                @foreach ($phyto_organoleptics_admin as $item)
                                <ul><li>{{$item->name}}</li></ul>  
                                @endforeach
                            </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>

         
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3> Physicochemical Data Template</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="modal fade" id="demoModal_1" tabindex="-1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="demoModalLabel">Physicochemical</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <form  class="forms-sample" action="{{url('admin/phyto/config/physicochemdata/create')}}" method="post">
                                            {{ csrf_field() }}
            
                                            <div class="modal-body">
                                                                            
                                                <div class="card-header"><h3>Create New feature</h3></div>

                                                    <div class="form-group">
                                                        <label for="exampleInputName1">Name</label>
                                                        <input type="text" required name="name" class="form-control"  placeholder="Name">
                                                        @error('name')
                                                        <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                                            <strong>{{$message}}</strong>
                                                        </small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputName1">Result</label>
                                                        <input type="text" required name="result" class="form-control" placeholder="Result">
                                                        @error('result')
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
                            <div class="col-md-8">
                            <form  class="" action="{{url('admin/phyto/config/physicochemdata/update')}}" method="post">
                                    {{ csrf_field() }}
                             <table class="table table-inverse">                      
                                 <tbody>
                                     <tr>
                                         <th>Activation</th>
                                         <th>Name</th>
                                         <th>Result</th>
                                         <th><button type="button" class="btn btn-success" data-toggle="modal" data-target="#demoModal_1">New</button></th>

                                     </tr>
                                     @foreach ($phyto_physicochemdata as $physicochemdata)
                                     <tr>
                                        <td > 
                             
                                            <div class="form-check mx-sm-2">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="physicochem_item[]" value="{{$physicochemdata->id}}" class="custom-control-input" {{$physicochemdata->action == 1 ?'checked':''}} >
                                                    <span class="custom-control-label">&nbsp;</span>
                                                </label>
                                            </div>
                                            </td>
                                     <td class="font"><input type="text" name="name[]" value="{{$physicochemdata->name}} "></td>
         
                                     <td class="font"><input class="form-control" type="text" name="result[]" value="{{$physicochemdata->result}}"></td>
                               
                                     </tr>        
                                     @endforeach
                                </tbody>
                               </table>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select required name="action" class="form-control" id="exampleSelectGender">
                                         <option value=""> Select Action</option>                                        
                                            <option  value="1" >Activate</option>
                                            <option  value="2" >Update Template</option>
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
                                <div class="alert alert-warning" role="alert">
                                    @foreach ($phyto_physicochemdata_admin as $item)
                                    <ul><li>{{$item->name}}</li></ul>  
                                    @endforeach
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
         
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>PhytoChemical Constituents Template</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="modal fade" id="demoModal_2" tabindex="-1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="demoModalLabel">PhytoChemical Constituents </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <form  class="forms-sample" action="{{url('admin/phyto/config/chemicalconsts/create')}}" method="post">
                                            {{ csrf_field() }}
            
            
                                            <div class="modal-body">
                                                                            
                                                <div class="card-header"><h3>Create New feature</h3></div>

                                                    <div class="form-group">
                                                        <label for="exampleInputName1">Name</label>
                                                        <input type="text" required name="name" class="form-control"  placeholder="Name">
                                                        @error('name')
                                                        <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                                            <strong>{{$message}}</strong>
                                                        </small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputName1">Description</label>
                                                        <input type="text" required name="description" class="form-control" placeholder="Description">
                                                        @error('description')
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
                            <div class="col-md-8">
                            <form  class="" action="{{url('admin/phyto/config/chemicalconsts/update')}}" method="post">
                                    {{ csrf_field() }}
                             <table class="table table-inverse">                      
                                 <tbody>
                                     <tr>
                                        <th>Activation</th>
                                         <th>Name</th>
                                         <th>Description</th>
                                         <th><button type="button" class="btn btn-success" data-toggle="modal" data-target="#demoModal_2">New</button></th>

                                     </tr>
                                     @foreach ($phyto_chemicalconsts as $chemicalconst)
                                     <tr>
                                    <td >
                                        <div class="form-check mx-sm-2">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="chemicalconsts_item[]" value="{{$chemicalconst->id}}" class="custom-control-input" {{$chemicalconst->action == 1 ?'checked':''}} >
                                                <span class="custom-control-label">&nbsp;</span>
                                            </label>
                                        </div>
                                     </td>
                                     <td class="font"><input type="name" value="{{$chemicalconst->name}} "></td>
         
                                     <td class="font"><input class="form-control" type="text" name="description[]" value="{{$chemicalconst->description}}"></td>
                                    
                                     </tr>        
                                     @endforeach
                                </tbody>
                             </table>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select required name="action" class="form-control" id="exampleSelectGender">
                                         <option value=""> Select Action</option>                                        
                                            <option  value="1" >Activate</option>
                                            <option  value="2" >Update Template</option>
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
                                <div class="alert alert-warning" role="alert">
                                    @foreach ($phyto_chemicalconsts_admin as $item)
                                    <ul><li>{{$item->name}}</li></ul>  
                                    @endforeach
                                </div>
                              
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>

@endsection