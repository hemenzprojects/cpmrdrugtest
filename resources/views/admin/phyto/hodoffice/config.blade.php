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
                       
                           <div class="col-md-6">
                           <form  class="" action="{{url('admin/phyto/config/organoleptics/update')}}" method="post">
                                {{ csrf_field() }}
                                <table class="table table-inverse">                      
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <th>Feature</th>
                                            <th>Hide/show</th>
                                        </tr>
                                        @foreach ($phyto_organoleptics as $organo_item)
                                        <tr>
                                    
                                        <td class="font"><input type="text" name="name[]" value="{{$organo_item->name}} :"></td>
            
                                        <td class="font"><input class="form-control" type="text" name="feature[]" value="{{$organo_item->feature}}"></td>
                                        <td > 
                                
                                            <div class="form-check mx-sm-2">
                                                <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="organo_item[]" value="{{$organo_item->id}}" class="custom-control-input" {{$organo_item->action == 1 ?'checked':''}}>
                                                    <span class="custom-control-label">&nbsp;</span>
                                                </label>
                                            </div>
                                            </td>
                                        </tr>        
                                        @endforeach

                                     </tbody>
                                </table>
                                    <div class="row">
                                        <div class="col-md-6">
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
                       
                           <div class="col-md-6">
                                <form  class="forms-sample" action="{{url('admin/phyto/config/organoleptics/create')}}" method="post">
                                {{ csrf_field() }}

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
                    <div class="card-header"><h3> Physicochemical Data Template</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                             <table class="table table-inverse">                      
                                 <tbody>
                                     <tr>
                                         <th>Name</th>
                                         <th>Result</th>
                                         <th>Hide/show</th>
                                     </tr>
                                     @foreach ($phyto_physicochemdata as $physicochemdata)
                                     <tr>
                                  
                                     <td class="font"><input type="name" value="{{$physicochemdata->name}} :"></td>
         
                                     <td class="font"><input class="form-control" type="text" name="feature" value="{{$physicochemdata->result}}"></td>
                                     <td > 
                             
                                         <div class="form-check mx-sm-2">
                                             <label class="custom-control custom-checkbox">
                                                 <input type="checkbox" class="custom-control-input" >
                                                 <span class="custom-control-label">&nbsp;</span>
                                             </label>
                                         </div>
                                         </td>
                                     </tr>        
                                     @endforeach
                                </tbody>
                             </table>
                            </div>
                            <div class="col-md-6">
                                 <form  class="forms-sample" action="{{url('admin/phyto/config/organoleptics/create')}}" method="post">
                                 {{ csrf_field() }}
 
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
                                 <button type="submit" class="btn btn-primary mr-2">Create feature</button>
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
                    <div class="card-header"><h3>PhytoChemical Constituents Template</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                             <table class="table table-inverse">                      
                                 <tbody>
                                     <tr>
                                         <th>Name</th>
                                         <th>Description</th>
                                         <th>Hide/show</th>
                                     </tr>
                                     @foreach ($phyto_chemicalconsts as $chemicalconst)
                                     <tr>
                                  
                                     <td class="font"><input type="name" value="{{$chemicalconst->name}} :"></td>
         
                                     <td class="font"><input class="form-control" type="text" name="feature" value="{{$chemicalconst->description}}"></td>
                                     <td > 
                             
                                         <div class="form-check mx-sm-2">
                                             <label class="custom-control custom-checkbox">
                                                 <input type="checkbox" class="custom-control-input" >
                                                 <span class="custom-control-label">&nbsp;</span>
                                             </label>
                                         </div>
                                         </td>
                                     </tr>        
                                     @endforeach
                                </tbody>
                             </table>
                            </div>
                            <div class="col-md-6">
                                 <form  class="forms-sample" action="{{url('admin/phyto/config/organoleptics/create')}}" method="post">
                                 {{ csrf_field() }}
 
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
                                 <button type="submit" class="btn btn-primary mr-2">Create feature</button>
                             </form>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>

@endsection