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
<div class="card">

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{url('/admin/profile/uploadfile')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="text-center"> 
                    <img src="{{asset('admin/img/profile.jpg')}}" class="rounded-circle" width="100">
                <h4 class="card-title mt-10">{{$user->full_name}}</h4>
                <p class="card-subtitle">{{\App\Department::find($user->dept_id)->name}} Department</p>     
                </div>
                 <div class="row" style="margin: 5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputName1">First Name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{$user->first_name}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputName1">Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{$user->last_name}}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputName1">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{$user->email}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Signature. </label><br>
                                <input type="file" name="select_file" />
                                <img src="{{asset($user->sign_url)}}" class="" width="25%">
                            <span class="text-muted"> jpg, png, gif</span>
                            </div>
            
                            <div class="form-group">
                                <label for="exampleInputName1">Telephone</label>
                                <input type="text" class="form-control" name="tel" placeholder="Telephone" value="{{$user->tell}}">
                            </div>
                            
                            <div class="form-group">
                            <input onclick="return confirm('Note: Changes made will affect details of user activities.')" type="submit" name="upload" class="btn btn-primary" value="Upload">
                            </div>
                    </div>
                  </div>
               
            </form>
         </div>

            <div class="col-md-6">
                
            </div>
        </div>
    </div>
</div>
@endsection