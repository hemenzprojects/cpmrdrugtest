@extends('admin.layout.main')

@section('content')
<form action="{{url('admin/permissions/update')}}" class="form-inline" method="POST">
    {{ csrf_field() }} 
<div class="card">
    <div class="row">
        <input type="hidden" name="user_types_id" value="{{$user_type->id}}">
        <div class="col-sm-4">
            <div class="card table-card">
                <div class="card-header">
                    <h3>All user Types</h3>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="ik ik-chevron-left action-toggle"></i></li>
                            <li><i class="ik ik-minus minimize-card"></i></li>
                            <li><i class="ik ik-x close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_usertypes as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                <td><a href="{{route('admin.sid.config.user.permissions.edit',['id' => $item->id])}}"><i class="ik ik-edit f-16 mr-15 text-green"></i></a></td>
                                </tr> 
                                @endforeach
                                 
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
         
        <div class="col-sm-4">
            <div class="card">
                <table class="table table-hover mb-0">
                    <?php $i = 0; ?>
                    @foreach ($user_types as $item)
                    @foreach ($item->permissions as $item)
                    <?php $i++; ?>
                    <?php if(!($i%2 == 0)) continue; ?>
                    <tr>
                        <td class="font"> 
                           {{ucfirst(App\AdminFeature::find($item->pivot->admin_feature_id)? App\AdminFeature::find($item->pivot->admin_feature_id)->name:'Null')}}
                           {{ucfirst(App\AdminFeature::find($item->pivot->admin_feature_id)? App\AdminFeature::find($item->pivot->admin_feature_id)->id:'Null')}}

                        </td>
                        <td>@if($item->pivot->enabled === 0)
                            <span class="badge badge-danger"><i class="ik ik-alert-circle"></i></span> 
                            @endif
                            @if($item->pivot->enabled === 1)
                            <span class="badge badge-success"><i class="ik ik-check"></i></span>
                             @endif</td>
                        <td class="font"> 
                            {{ Form::select('permit['.$item->id.']',  array(0 => 'Disabled', 1 => 'Enabled'), $item->pivot->enabled) }}
                
                        <span class="help-inline">{{$errors->first('permit['.$item->id.']')}}</span>
                    </td>
                        </tr>
                    @endforeach                    
                     @endforeach
                </table>  
            </div>
        </div>
    
    
        <div class="col-sm-4">
            <div class="card">
                <table class="table table-hover mb-0">
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($user_types as $item)
                        @foreach ($item->permissions as $item)
                        <?php $i++; ?>
                        <?php if($i%2 == 0) continue; ?>
                        <tr>
                        <td class="font">        
                         {{ucfirst(App\AdminFeature::find($item->pivot->admin_feature_id)? App\AdminFeature::find($item->pivot->admin_feature_id)->name:'Null')}}
                         {{ucfirst(App\AdminFeature::find($item->pivot->admin_feature_id)? App\AdminFeature::find($item->pivot->admin_feature_id)->id:'Null')}}

                        </td>
                        <td>@if($item->pivot->enabled === 0)
                            <span class="badge badge-danger"><i class="ik ik-alert-circle"></i></span> 
                            @endif
                            @if($item->pivot->enabled === 1)
                            <span class="badge badge-success"><i class="ik ik-check"></i></span>
                             @endif
                        </td>
                        <td class="font">                                       
		                    {{ Form::select('permit['.$item->id.']',  array(0 => 'Disabled', 1 => 'Enabled'), $item->pivot->enabled) }}
                            <span class="help-inline">{{$errors->first('permit['.$item->id.']')}}</span>
                        </td>
                            </tr>
                        @endforeach 
                        
                         @endforeach
    
                    </tbody>
                </table>  
            </div>
    
       
       
            <button type="submit" class="btn btn-primary mr-2">Save</button>
    
       
        </div>
    </div>
</div>
</form>
@endsection