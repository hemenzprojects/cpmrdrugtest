@extends('admin.layout.main')

@section('content')

{{-- <div class="card">
    

    {{$user->sign_url}}
    <div class="card-body">
        <form method="post" action="{{url('/admin/profile/uploadfile')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
             <table class="table">
              <tr>
               <td width="40%" align="right"><label>Select File for Upload</label></td>
               <td width="30">
                   <input type="file" name="select_file" /></td>
               <td width="30%" align="left">
                   <input type="submit" name="upload" class="btn btn-primary" value="Upload"></td>
              </tr>
              <tr>
               <td width="40%" align="right"></td>
               <td width="30"><span class="text-muted">jpg, png, gif</span></td>
               <td width="30%" align="left"></td>
              </tr>
             </table>
            </div>
           </form>

           @if ($message = Session::get('success'))
           <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                   <strong>{{ $message }}</strong>
           </div>
           <img src="/images/{{ Session::get('path') }}" width="300" />
           @endif
    </div>
</div> --}}

     {{-- @foreach( $errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach --}}
       <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{ route('admin.profile.update',['id' => $user->id]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}    
                <div class="card" style="min-height: 484px;">
                    <div class="card-header">
                       
                            <div class="col-sm-4">
                                <img src="{{asset('admin/img/profile.jpg')}}" class="rounded-circle" width="40" style="margin: 5px">
                            </div>
                            <div class="col-sm-8">
                                <div class="page-header-title">
                                    <div class="d-inline">
                                        <h5>User Profile</h5>
                                        <span>{{$user->full_name}} - {{\App\Department::find($user->dept_id)->name}} </span>
                                        <span>{{App\UserType::find($user->user_type_id)->name}}</span>

                                    </div>
                                </div>
                            </div>
                
                    </div>
                    <div class="card-body">
                        <form class="forms-sample">
                            <input type="hidden" name="userprofile_update">
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Title</div>
                                </div>
                                <select required class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}">
                                    <option value="{{ $user->title}}">{{ $user->title}}</option>
                                    <option value="Mr">Mr</option>
                                    <option  value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Prof">Prof</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{$user->first_name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{$user->last_name}}">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{$user->email}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Signature. </label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="exampleInputName1"></label><br>
                                        <img src="{{asset($user->sign_url)}}" class="" width="25%">
                                    <span class="text-muted"> jpg, png, gif</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Telephone</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tell" placeholder="Telephone" value="{{$user->tell}}">
                                </div>
                            </div>
                           
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Change Password</h3>
                        <span></span>
                        
                    </div>
                    <div class="card-body">

                        <p>Password should contain characters from three of the following five groups (quoted from the Microsoft document):
                            Uppercase letters of European languages (A through Z, with diacritical marks, Greek and Cyrillic characters)<br>
                            Lowercase letters of European languages (A through Z, sharp S, with diacritical marks, Greek and Cyrillic characters)
                            Base 10 digits (0 through 9); non-alphanumeric characters (special characters): (~!@#$%^&*_-+=`|\(){}[]:;"'<>,.?/)<br>
                            </p>
                        <form method="post" action="{{route('admin.password.change')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="" style="">
                                <h4 class="card-title mt-10"></h4>
                            <div class="form-group">
                                <label for="exampleInputPassword4">Current Password</label>
                                <input type="password" name="current_password" class="form-control" id="exampleInputPassword4" placeholder="Current Password">
                            </div>
                            @if ($errors->has('current_password'))
                            <span class="invalid-feedback" role="alert">
                        <p style="color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                                    {{ $errors->first('password') }}</p>
                            </span>
                        @endif
                              
                      <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Password</div>
                            </div>
                            <input id="password" placeholder="Password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        </div>

                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                    <p style="color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                                {{ $errors->first('password') }}</p>
                        </span>
                    @endif
                    
                    </div>
                    <div class="">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Confirm Password</div>
                            </div>
                            <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required>

                        </div>
                    </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-2">Change Password</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        
   <div class="row">
       <div class="col-sm-6">
        <div class="card table-card">
            <div class="card-header">
                <h3>Permissions System Administrator access only</h3>
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
                            <th>ID</th>
                            <th>Feature</th>
                            <th>permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach(App\Admin::find($user->id)->permissions as $key => $permission)
                                <?php $i++; ?>
                                <?php if($i%2 == 0) continue; ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td class="font">{{$permission->name}}</td>
                                    <td>{!! $permission->pivot->enabled?'<span class="badge badge-success btn-xs">Enabled</span>':'<span class="badge badge-danger btn-xs">Disabled</span>' !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       </div>
       <div class="col-sm-6">
        <div class="card table-card">
            <div class="card-header">
                <h3>Permissions System Administrator access only</h3>
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
                            <th>ID</th>
                            <th>Feature</th>
                            <th>permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach(App\Admin::find($user->id)->permissions as $key => $permission)
                                <?php $i++; ?>
                                <?php if(!($i%2 == 0)) continue; ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td class="font">{{$permission->name}}</td>
                                    <td>{!! $permission->pivot->enabled?'<span class="badge badge-success btn-xs">Enabled</span>':'<span class="badge badge-danger btn-xs">Disabled</span>' !!}</td>
                                 </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       </div>

   </div>

@endsection