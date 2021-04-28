<div class="">
    <div class="">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6> Products at the lab</h6>
                                <h2> {{count($pharm_products)}}
                                </h2>
                            </div>
                            <div class="icon">
                               <i class="ik ik-square"></i> 
                                                       </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total number of distributed products </small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Completed Products</h6>
                                <h2>{{count($pharm_completedproduct)}}</h2>
                            </div>
                            <div class="icon">
                               <i class="ik ik-square"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total number of product tested in a year</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Pending Products</h6>
                                <h2>{{count($pharm_pendingproduct)}}</h2>
                            </div>
                            <div class="icon">
                               <i class="ik ik-square"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total number of Pending products in a year</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Failed Products</h6>
                                <h2>{{count($pharm_failedproduct)}}</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-message-square"></i>
                            </div>
                        </div>
                        <small class="text-small mt-10 d-block">Total number of failed products in a year</small>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        
    </div>
    <div class="col-md-4">
        <div class="card" style="min-height: 422px;">
            <div class="card-header"><h3> Sample Preparations</h3></div>
            <div class="card-body"  style=" overflow-x: hidden;overflow-y: auto; height:450px; margin-bottom: 10px">
                
                    <div class="card ticket-card">
                        <div class="card-body">
                            <p class="mb-30 bg-red lbl-card"><i class="ik ik-activity"></i>  Anual Data </p>

                            <div class="text-center">
                                        <h2 class="mb-0 d-inline-block text-red">{{count($pharm_sample_products)}}</h2>
                                        <p class="mb-0 d-inline-block"> Pending </p>                                   
                                <p class="mb-0 mt-15"><i class="fas fa-caret-down mr-10 f-18 text-red"></i>From the begining of this Year</p>
                            </div>
                        </div>
                    </div>
                        <div class="card ticket-card">
                            
                            <div class="card-body">
                                <p class="mb-30 bg-green lbl-card"><i class="fas fa-database"></i> Anual Data </p>

                                <div class="text-center">
    
                                    <div class="row">
                            
                                        <div class="col-md-6">
                                        <h2 class="mb-0 d-inline-block text-green">{{count($prepared_samples)}}</h2><br>
                                            <p class="mb-0 d-inline-block"> Completed Samples</p>
                                        </div>
                                        <div class="col-md-6">
                                               
                                        <h2 class="mb-0 d-inline-block text-green">{{count($prepared_samples_animalhouse)}}</h2><br>
                                        <p class="mb-0 d-inline-block">Samples @ Animal House</p>
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-15"><i class="fas fa-caret-up mr-10 f-18 text-green"></i>From the begining of this Year</p>
                                </div>
                            </div>
                        </div>
                        <div class="card ticket-card">
                            
                            <div class="card-body">
                                <p class="mb-30 bg-red lbl-card"><i class="ik ik-activity"></i>  Anual Data </p>

                                <div class="text-center">
    
                                    <div class="row">
                            
                                        <div class="col-md-6">
                                        <h2 class="mb-0 d-inline-block text-red">{{count($samples_notsubmited)}}</h2><br>
                                            <p class="mb-0 d-inline-block">Completed but measurement to animal house not recorded / submited</p>
                                        </div>
                                        <div class="col-md-6">
                                               
                                        <h2 class="mb-0 d-inline-block text-red">{{count($samples_submited_pending)}}</h2><br>
                                        <p class="mb-0 d-inline-block"> Completed but pending samples at animal house </p>
                                        </div>
                                    </div>
                                <p class="mb-0 mt-15"><i class="fas fa-caret-up mr-10 f-18 text-red"></i> <span class="mb-0 d-inline-block text-red">{{count($samples_animalhouse_pending)}} pending samples</span><br> from the begining of this Year</p>
                                </div>
                            </div>
                        </div>
            
            </div>
        </div>
    </div>
</div>