@extends('admin.layout.main')

@section('content')

<div class="card">

    <div class="card-body">
        <div class="row">
           <div class="col-md-4">
            <div class="content-main">
                <div class="w3ls-subscribe">
                    <h4 >New Client</h4>

                    <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input id="title" type="text" placeholder="Title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>
                    <select name="dept_id" id="">
                        <option value="1">Microbiology</option>
                    </select>
                        <input id="name" type="text" placeholder="First Name" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="name" value="{{ old('first_name') }}" required autofocus>

                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                            <p style="color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                            {{ $errors->first('first_name') }}
                            </p>
                                </span>
                            @endif
                            <input id="last_name" type="text" placeholder="Last Name" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('first_name') }}" required autofocus>

                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                            <p style="color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                                        {{ $errors->first('last_name') }}
                                    </p>
                                </span>
                            @endif
                         <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                            <p style="color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                                        {{ $errors->first('email') }}</p>
                                </span>
                            @endif
                         <input id="password" placeholder="Password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                            <p style="color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                                        {{ $errors->first('password') }}</p>
                                </span>
                            @endif
                         <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required>
                        <input type="submit" value="Register">
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
                                    <td class="font">{{$admin->email}}</td>
                                    <td class="font">{{$admin->tell}}</td>
                                    <td class="font">{{App\Department::find($admin->dept_id)->name}}</td>
                                    <td class="font">{{App\UserType::find($admin->user_type_id)->name}}</td>

                                    <td class="font">
                                    <div class="table-actions">
                                        <a href="#"><i class="ik ik-trash-2"></i></a>
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