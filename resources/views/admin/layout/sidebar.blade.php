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
                                    <a href=""><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                                </div>
                                <div class="nav-lavel">Drug Analysis</div>
                                <div class="nav-item">
                                <a href="{{url('admin/sid/customer/create')}}"><i class="ik ik-user-plus"></i><span>Customers</span> 
                                        <span class="badge badge-success">New</span></a>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-menu"></i><span>Products</span> 
                                        <div class="submenu-content">
                                       <a href="{{url('admin/sid/product/create')}}" class="menu-item">New Product</a>
                                       <a href="{{url('admin/sid/distribution/create')}}" class="menu-item">Product Distribution</a>

          
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-folder-minus"></i><span>Reports</span> 
                                      <div class="submenu-content">
  
                                        <a href="pages/ui/alerts.html" class="menu-item">Daily Report</a>
                                        <a href="pages/ui/badges.html" class="menu-item">Montly Report</a>
                                        <a href="pages/ui/buttons.html" class="menu-item">Yearly Products</a>
                                    </div>
                                </div>
                               
                                <div class="nav-lavel">Test Labs</div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-layout"></i><span>Microbiology</span></a>
                                    <div class="submenu-content">
                                        <a href="{{route('admin.micro.receiveproduct')}}" class="menu-item">Receieve Product</a>
                                        <a href="{{route('admin.micro.report.create')}}" class="menu-item">Create Reports</a>
                                        <a href="pages/ui/buttons.html" class="menu-item">Rejected Products</a>
                                        <a href="pages/ui/navigation.html" class="menu-item">Report</a>
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-layout"></i><span>Pharmacology</span> <span class="badge badge-success"></span></a>
                                    <div class="submenu-content">
                                    <a href="{{route('admin.pharm.receiveproduct')}}" class="menu-item">Recieve Products</a>
                                    <a href="pages/ui/notifications.html" class="menu-item">Completed Products</a>
                                        <a href="pages/ui/carousel.html" class="menu-item">Rejected Products</a>
                                        <a href="pages/ui/range-slider.html" class="menu-item">Report</a>
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-layout"></i><span>Phytochemistry</span></a>
                                      <div class="submenu-content">
                                        <a href="{{route('admin.phyto.receiveproduct')}}" class="menu-item">Recieved Products</a>
                                        <a href="pages/ui/badges.html" class="menu-item">Completed Products</a>
                                        <a href="pages/ui/buttons.html" class="menu-item">Rejected Products</a>
                                        <a href="pages/ui/navigation.html" class="menu-item">Report</a>
                                    </div>
                                </div>
                               
                                <div class="nav-lavel">Accounts</div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-edit"></i><span>Receive Payments</span></a>
                                    <div class="submenu-content">
                                        <a href="pages/form-components.html" class="menu-item">All trasactions</a>
                                        <a href="pages/form-addon.html" class="menu-item">Report</a>
                                    </div>
                                </div>
                                <div class="nav-item">
                                    <a href="pages/form-picker.html"><i class="ik ik-terminal"></i><span>Form Picker</span> <span class="badge badge-success">New</span></a>
                                </div>

                               
                                <div class="nav-lavel">Support</div>
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