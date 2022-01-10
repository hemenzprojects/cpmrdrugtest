<div class="row clearfix">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="widget">
            <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                        <h6>Report(s) withheld</h6>
                       <h2>{{count($final_hod_withhelds)}}</h2>
                    </div>
                    <div class="icon">
                        <i class="ik ik-alert-circle"></i>
                    </div>
                </div>
                <small class="text-small mt-10 d-block">Total number of product withheld</small>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="widget">
            <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                        <h6> Approved Report(s)</h6>
                        <h2>{{count($final_hod_approvals )}}</h2>
                    </div>
                    <div class="icon">
                        <i class="ik ik-thumbs-up"></i>
                    </div>
                </div>
                <small class="text-small mt-10 d-block">Total number of report in Approved</small>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="widget">
            <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                        <h6>Completed Report(s) </h6>
                        <h2>{{count($completeds)}}</h2>
                    </div>
                    <div class="icon">
                        <i class="ik ik-calendar"></i>
                    </div>
                </div>
                <small class="text-small mt-10 d-block">Total number of report completed this year</small>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
            </div>
        </div>
    </div>
</div>