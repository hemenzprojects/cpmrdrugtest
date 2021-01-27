           <div class="app-sidebar colored">
                    <div class="sidebar-header" style="background-color: #071701">
                        <a class="header-brand" href="index.html">
                            <div class="logo-img">
                               <img style="width:100%" src="{{asset('admin/img/logo.jpg')}}" class="header-brand-img" alt=""> 
                            </div>
                            <span style="color: #fff" class="text">CPMR</span>
                        </a>
                        <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
                        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                    </div>
                    
                    <div class="sidebar-content">
                        <div class="nav-container" style="background: #0c2702;">
                            <nav id="main-menu-navigation" class="navigation-main">
                                
                                <div class="nav-item active">
                                    <a href="{{url('admin/general/home')}}"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                                </div>
                                
                                @if (Auth::guard('admin')->user()->dept_id ==4)
                                <div class="nav-lavel">Drug Analysis</div>
                                <div class="nav-item">
                                <a href="{{url('admin/sid/customer/create')}}"><i class="ik ik-user-plus"></i><span>Customers</span> 
                                        <span class="badge badge-success">New</span></a>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-menu"></i><span>Products</span> 
                                        <div class="submenu-content">
                                       <a href="{{url('admin/sid/product/create')}}" class="menu-item">New Product</a>
                                       <a href="{{url('admin/sid/product/category/create')}}" class="menu-item">Product Categories</a>
                                       <a href="{{url('admin/sid/distribution/create')}}" class="menu-item">Product Distribution</a>

          
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-folder-minus"></i><span>Report Section</span> 
                                      <div class="submenu-content">
  
                                      <a href="{{url('admin/sid/report/index')}}" class="menu-item">General Report</a>
                                        {{-- <a href="pages/ui/badges.html" class="menu-item">Montly Report</a>
                                        <a href="pages/ui/buttons.html" class="menu-item">Yearly Products</a> --}}
                                    </div>
                                </div>
                                @endif                         
                               
                    
                                     @if (Auth::guard('admin')->user()->dept_id ==1)

                                     <div class="nav-lavel">Microbiology</div>
                                     <div class="nav-item has-sub">
                                         <a href="#"><i class="ik ik-git-branch"></i><span>Lab Technicians</span></a>
                                         <div class="submenu-content">
                                             <a href="{{route('admin.micro.receiveproduct')}}" class="menu-item">Receieve Product</a>
                                             <a href="{{route('admin.micro.report.create')}}" class="menu-item">Reports Taskboard </a>
                                             <a href="" class="menu-item"></a>
                                             
                                    
                                         </div>
                                     </div>
                                        @if (Auth::guard('admin')->user()->user_type_id ==1)
                                        <div class="nav-item has-sub">
                                            <a href="#"><i class="ik ik-layout"></i><span>Hod Office</span> <span class="badge badge-success"></span></a>
                                            <div class="submenu-content">
                                            <a href="#" class="menu-item">Assign Duty</a>
                                            <a href="{{route('admin.micro.hod_office.approval')}}" class="menu-item">Report Evaluation</a>
                                            <a href="pages/ui/notifications.html" class="menu-item">Completed Reports</a>
                                            </div>
                                        </div> 
                                     
                                        @endif
                                     <div class="nav-item has-sub">
                                        <a href="#"><i class="ik ik-file-text"></i><span>Genereal Reports</span></a>
                                        <div class="submenu-content">
                                        <a href="{{route('admin.micro.general_report.index')}}" class="menu-item">Report Statistics</a>
                                            <a href="" class="menu-item">Pending Products</a>
                                            <a href="" class="menu-item"></a>
                                            
                                        </div>
                                     </div>
                              
                                     @endif
            
                              
                                     @if (Auth::guard('admin')->user()->dept_id ==2)

                                     @if (Auth::guard('admin')->user()->user_type_id == 2 || Auth::guard('admin')->user()->user_type_id == 1)
                                     <div class="nav-lavel">Pharmacology</div>
                                     <div class="nav-item has-sub">
                                         <a href="#"><i class="ik ik-git-branch"></i><span>Lab Technicians</span></a>
                                         <div class="submenu-content">
                                             <a href="{{route('admin.pharm.receiveproduct')}}" class="menu-item">Receieve Product</a>
                                             <a href="#" class="menu-item">Reports Taskboard </a> 
                                         </div>
                                     </div>

                                   
                                     <div class="nav-item has-sub">
                                         <a href="#"><i class="ik ik-filter"></i><span>Sample Preparation</span></a>
                                         <div class="submenu-content" style="">
                                             <a href="{{route('admin.pharm.samplepreparation.create')}}" class="menu-item">Perform preparation</a>
                                             <a href="{{route('admin.pharm.samplepreparation.index')}}" class="menu-item">Record Book</a>
                                         </div>
                                     </div>
                                     @endif

                                     @if (Auth::guard('admin')->user()->user_type_id == 3 ||Auth::guard('admin')->user()->user_type_id == 1)
                                     <div class="nav-item has-sub">
                                         <a href="#"><i class="ik ik-file-plus"></i><span>Animal Experimentation</span></a>
                                         <div class="submenu-content" style="">
                                             <a href="{{route('admin.pharm.animalexperimentation.create')}}" class="menu-item">Receieve Product</a>
                                             <a href="{{route('admin.pharm.animalexperimentation.maketest')}}" class="menu-item">Perform Experiment</a>
                                             
     
                                         </div>
                                     </div>
                                     <div class="nav-item has-sub">
                                        <a href="#"><i class="ik ik-file-text"></i><span>Record Book</span></a>
                                        <div class="submenu-content">
                                        <a href="{{route('admin.pharm.animalexperimentation.recordbook')}}" class="menu-item">Received Product</a>
                                            <a href="" class="menu-item"></a>

                                        </div>
                                     </div>
                                     @endif
                                     @if (Auth::guard('admin')->user()->user_type_id == 2 ||Auth::guard('admin')->user()->user_type_id == 1)
                                     <div class="nav-item has-sub">
                                        <a href="#"><i class="ik ik-file-text"></i><span>Genereal Reports</span></a>
                                        <div class="submenu-content">
                                            <a href="{{route('admin.pharm.general_report.index')}}" class="menu-item">Completed Products</a>
                                            <a href="" class="menu-item">Pending Products</a>
                                            <a href="" class="menu-item"></a>
                                        </div>
                                     </div>
                                     @endif
                                     @if (Auth::guard('admin')->user()->user_type_id ==1)
                                     <div class="nav-item has-sub">
                                         <a href="#"><i class="ik ik-layout"></i><span>Hod Office</span> <span class="badge badge-success"></span></a>
                                         <div class="submenu-content">
                                          <a href="#" class="menu-item">Assign Duty</a>
                                         <a href="{{route('admin.pharm.hod_office.approval')}}" class="menu-item">Report Evaluation</a>
                                         <a href="{{route('admin.pharm.hod_office.completedreports')}}" class="menu-item">Completed Reports</a>
                                          
                                         </div>
                                     </div>
                                     @endif

                                     @endif
                                
                            
                                     @if (Auth::guard('admin')->user()->dept_id ==3)
                                    
                                            <div class="nav-lavel">Phytochemistry</div>
                                            <div class="nav-item has-sub">
                                                <a href="#"><i class="ik ik-git-branch"></i><span>Lab Technicians</span></a>
                                                <div class="submenu-content">
                                                    <a href="{{route('admin.phyto.receiveproduct')}}" class="menu-item">Receieve Product</a>
                                                    <a href="{{route('admin.phyto.makereport.index')}}" class="menu-item">Report Preparation</a>
                                                    <a href="" class="menu-item"></a>
                                                    
                                                </div>
                                            </div>
                                                @if (Auth::guard('admin')->user()->user_type_id ==1)

                                                <div class="nav-item has-sub">
                                                    <a href="#"><i class="ik ik-layout"></i><span>Hod Office</span> <span class="badge badge-success"></span></a>
                                                    <div class="submenu-content">
                                                    <a href="#" class="menu-item">Assign Duty</a>
                                                    <a href="{{route('admin.phyto.hod_office.approval')}}" class="menu-item">Report Evaluation</a>
                                                    <a href="pages/ui/notifications.html" class="menu-item">Completed Reports</a>
                                                    
                                                    </div>
                                                </div>
                                                @endif

                                            <div class="nav-item has-sub">
                                                <a href="#"><i class="ik ik-file-text"></i><span>Genereal Reports</span></a>
                                                <div class="submenu-content">
                                                <a href="{{route('admin.phyto.general_report.index')}}" class="menu-item">Report Statistics</a>
                                                    <a href="" class="menu-item">Pending Products</a>
                                                    <a href="" class="menu-item"></a>
                                                    
                                                </div>
                                             </div>
                                      @endif
                                   
                              
                                <div class="nav-lavel">Support</div>

                                {{-- SID --}}
                                @if (Auth::guard('admin')->user()->dept_id ==4)
                                @if (Auth::guard('admin')->user()->user_type_id ==1)

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-settings"></i><span>Configuration</span> <span class="badge badge-success"></span></a>
                                    <div class="submenu-content">
                                    <a href="{{route('admin.sid.config.user.create')}}" class="menu-item">Add Users</a>
                                    <a href="#" class="menu-item">User Roles</a>
                                    <a href="#" class="menu-item"> User Permissions </a>
                                    </div>
                                </div> 
                                @endif
                                @endif

                                   {{-- MICRO CONFIG  --}}
                                @if (Auth::guard('admin')->user()->dept_id ==1)
                                @if (Auth::guard('admin')->user()->user_type_id ==1)

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-settings"></i><span>Configuration</span> <span class="badge badge-success"></span></a>
                                    <div class="submenu-content">
                                    <a href="#" class="menu-item"></a>
                                    <a href="{{route('admin.micro.hod_office.config')}}" class="menu-item">Report template settings </a>
                                   
                                    </div>
                                </div> 
                                @endif
                                @endif
                                {{-- PHARM CONFIG  --}}

                                @if (Auth::guard('admin')->user()->dept_id ==2)
                                @if (Auth::guard('admin')->user()->user_type_id ==1)

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-settings"></i><span>Configuration</span> <span class="badge badge-success"></span></a>
                                    <div class="submenu-content">
                                    <a href="#" class="menu-item"></a>
                                    <a href="#" class="menu-item">Animal Models</a>
                                    <a href="#" class="menu-item">  Signs of Toxicity</a>
                                    <a href="#" class="menu-item">  Test Conducted</a>
                                    </div>
                                </div> 
                                @endif
                                @endif

                                {{-- PHYTO CONFIG  --}}
                                @if (Auth::guard('admin')->user()->dept_id ==3)
                                @if (Auth::guard('admin')->user()->user_type_id ==1)

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-settings"></i><span>Configuration</span> <span class="badge badge-success"></span></a>
                                    <div class="submenu-content">
                                    <a href="{{route('admin.phyto.hod_office.config')}}" class="menu-item">  Report template settings</a>
                                   
                                    </div>
                                </div> 
                                @endif
                                @endif
                                <div class="nav-item">
                                    <a href="javascript:void(0)"><i class="ik ik-monitor"></i><span>Documentation</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="javascript:void(0)"><i class="ik ik-help-circle"></i><span>Submit Issue</span></a>
                                </div>
                               
                            </nav>
                        </div>
                    </div>
                </div>
               