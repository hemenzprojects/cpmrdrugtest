@extends('admin.layout.main')

@section('content')

<div class="card">

    <div class="card-body">
        <div class="row">
           <div class="col-md-4">
            <div class="content-main">
                <div class="w3ls-subscribe">
                    <h4 >New User </h4>

                    <form method="POST" action="{{ route('admin.sid.user.update',['id' => $admin->id]) }}">
                    @csrf
                    <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Title</div>
                            </div>

                                <select required class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}">
                                    <option value="{{ $admin->title}}">{{ $admin->title}}</option>
                                    <option value="Mr">Mr</option>
                                    <option  value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Prof">Prof</option>
                                </select>
                        </div>
                        <div>
                        @error('title')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                        </div>
                    </div>  
                    <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">First Name</div>
                            </div>
                        <input type="text" required class="form-control" id="inlineFormInputGroupUsername2" name="first_name" placeholder="First Name" value="{{old('first_name')? old('first_name'): $admin->first_name}}">
                        
                        </div>
                        <div>
                        @if ($errors->has('first_name'))
                            <span class="invalid-feedback" role="alert">
                        <p style="color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                        {{ $errors->first('first_name') }}
                        </p>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Last Name</div>
                            </div>
                        <input type="text" required class="form-control" name="last_name" placeholder="Last Name" value="{{old('last_name')? old('last_name'):$admin->last_name }}">
                        
                        </div>
                        <div>
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                            <p style="color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                                        {{ $errors->first('last_name') }}
                                    </p>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Position</div>
                            </div>
                        <input type="text" required class="form-control" name="position" placeholder="Position" value="{{old('position')? old('position'):$admin->position}}">
                        
                        </div>
                        <div>
                            @if ($errors->has('posision'))
                                <span class="invalid-feedback" role="alert">
                            <p style="color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                                        {{ $errors->first('last_name') }}
                                    </p>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Dept.</div>
                            </div>
                            <select required name="dept_id" style="" class="form-control select2">
                                <?php $admin_dept = old('dept_id')? old('dept_id'): ($admin->dept ? $admin->dept->id: "");?>
                                @foreach($depts as $dept)                
                                <option  value="{{$dept->id}}" {{$admin_dept == $dept->id? "selected":""}}>{{$dept->name}}</option>  
                                @endforeach
                            </select>

                        </div>
                        <div>
                            @error('dept_id')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                        </div>
                    </div>

                    <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">User Type </div>
                            </div>
                            <select required name="user_type" style="" class="form-control select2">
                                <option value="">Select User Type</option>
                                <?php $admin_usertype = old('user_type')? old('user_type'): ($admin->type ? $admin->type->id: "");?>
                                @foreach($user_types as $user_type)
                               <option  value="{{$user_type->id}}" {{$admin_usertype == $user_type->id? "selected":""}}>{{$user_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            @error('user_type')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                        </div>
                    </div>

                    <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Dept. Office/Unit</div>
                            </div>
                            <select required name="dept_office_id" style="" class="form-control select2">
                                <option value="">Select department unit</option>
                                <?php $admin_dept_office = old('dept_office_id')? old('dept_office_id'): ($admin->deptOffice ? $admin->deptOffice->id: "");?>
                                @foreach($dept_offices as $dept_office)     
                                <option  value="{{$dept_office->id}}" {{$admin_dept_office == $dept_office->id ? "selected":""}}>{{$dept_office->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            @error('dept_office_id')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                        </div>
                    </div>
                    <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Tell.</div>
                            </div>
                            <input  type="number" placeholder="Tell" class="form-control{{ $errors->has('tell') ? ' is-invalid' : '' }}" name="tell" value="{{old('tell')? old('tell'):$admin->tell}}" required autofocus>

                        </div>
                        <div>
                            @error('tell')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                        </div>
                    </div>

                    <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Email</div>
                            </div>
                            <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{old('email')? old('email'):$admin->email }}" required>

                        </div>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                        <p style="color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                                    {{ $errors->first('email') }}</p>
                            </span>
                        @endif
                    
                    </div>
                        
                     
                         <div>
                            <button type="submit" value="Register" class="btn btn-primary mb-2">Update</button>

                         </div>
                        </form>
               

                    </form>
                </div>
            </div>
           </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="dt-responsive " >
                            <table id="order-table" class="table table-striped table-bordered nowrap" >
                                <thead>
                                    <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Tell.</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>User Type</th>
                                    <th>Action</th>
                
                                  </tr> 
                                </thead>
                                <tbody>
                                    @foreach($admins as $admin)
                                <tr>
                                    <td style="display: ">{{$admin->id}}</td>
        
                                    <td class="font">{{$admin->full_name}}</td>
                                    <td class="font">{{$admin->tell}}</td>
                                    <td class="font">{{$admin->email}}</td>
                                    <td class="font">{{App\Department::find($admin->dept_id)->name}}</td>
                                    <td class="font">{{App\UserType::find($admin->user_type_id)->name}}</td>

                                    <td class="font">
                                    <div class="table-actions">
                                        {!! $admin->edit_tag !!}
                                        <a href="#"><i class="ik ik-trash-2"></i></a>
                                        <a href="#"><i class="ik ik-trash-2"></i></a>
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
    </div>
</div>
@endsection