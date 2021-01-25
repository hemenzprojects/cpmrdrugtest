@include('admin.layout.general.head')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            {{-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif --}}

            <div class="container">
                <div class="text-center"> 
                    <img src="{{asset('admin/img/logo.jpg')}}" class="" width="11%">
                    <div class="title m-b-md" style="margin-top:30px" >
                        <p style="font-size: 50px;font-family: system-ui;margin-top: -5px; margin-bottom: -5px;"> <strong>DRUG</strong> </p>

                        <p style="font-size: 50px; margin-bottom: 40px;">ANALYSIS MANAGEMENT SYSTEM </p>
                        <p style="font-size: 20px; ">Please click your department tab to login </p>
                    </div>
                   </div>
                <div class="links">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="widget bg-teal">
                                <div class="widget-header">
                                    <h3 class="widget-title">SID</h3>
                                    <div class="widget-tools pull-right">
                                        <button type="button" class="btn btn-widget-tool remove-widget "></button>
                                    </div>
                                    <div class="progress mt-3 mb-1" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 30%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            <a href="{{route('admin.login')}}">
                                <div class="widget-body">
                                    Login  <i class="ik ik-log-in"></i>
                                </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <div class="widget bg-teal">
                                <div class="widget-header">
                                    <h3 class="widget-title">Pharmacology</h3>
                                    <div class="widget-tools pull-right">
                                        <button type="button" class="btn btn-widget-tool remove-widget "></button>
                                    </div>
                                    <div class="progress mt-3 mb-1" style="height: 6px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 30%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <a href="{{url('admin/login')}}">
                                <div class="widget-body">
                                    Login  <i class="ik ik-log-in"></i>
                                </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="widget bg-teal">
                                <div class="widget-header">
                                    <h3 class="widget-title">Microbiology</h3>
                                    <div class="widget-tools pull-right">
                                        <button type="button" class="btn btn-widget-tool remove-widget "></button>
                                    </div>
                                    <div class="progress mt-3 mb-1" style="height: 6px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 30%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <a href="{{url('admin/login')}}">
                                <div class="widget-body">
                                    Login  <i class="ik ik-log-in"></i>
                                </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="widget bg-teal">
                                <div class="widget-header">
                                    <h3 class="widget-title">Phytochemistry</h3>
                                    <div class="widget-tools pull-right">
                                        <button type="button" class="btn btn-widget-tool remove-widget "></button>
                                    </div>
                                    <div class="progress mt-3 mb-1" style="height: 6px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 30%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <a href="{{route('admin.login')}}">
                                <div class="widget-body">
                                    Login  <i class="ik ik-log-in"></i>
                                </div>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                  
                    {{-- <a href="http://localhost/drugProject/public/admin/login">Pharmacology</a>
                    <a href="http://localhost/drugProject/public/admin/login">Microbiology</a>
                    <a href="http://localhost/drugProject/public/admin/login">Phytochemistry</a>
                    <a href="http://localhost/drugProject/public/admin/login">Administration</a>
                    <a href="http://localhost/drugProject/public/admin/login">System Administrators</a> --}}
                
                </div>
            </div>
        </div>
    </body>
</html>
