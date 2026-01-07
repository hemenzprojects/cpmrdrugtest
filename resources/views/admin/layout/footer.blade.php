@if(!$canEvaluateReports)
    <div class="hidefade" id="carbonads">
         <span>
           <span class="carbon-wrap ">
            <span class="carbon-img">
                <i class="fa fa-exclamation-triangle text-warning" style="font-size: 48px;"></i>
            </span>
            <span class="carbon-text">
                <strong>Security License Notice:</strong> {{ $licenseNotification['title'] ?? 'Your evaluation license and API endpoint authorization will expire in 30 days.' }}
                <br><br>
                <small class="text-muted">Important: {{ $licenseNotification['details'] ?? 'Endpoint API source code verification is due. Please contact your administrator to renew the security license.' }}</small>
            </span>
        </span>
        </span>
    </div>
@endif
<footer class="footer">

    <div class="w-100 clearfix">
        <span class="text-center text-sm-left d-md-inline-block">Copyright © {{date('Y')}} Centre for Plant Medicine Research. All Rights Reserved.</span>
        <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Powered
            {{-- <i class="fa fa-heart text-danger"></i> --}}
             by
            <a href="#" class="text-dark" target="_blank">SID</a></span>
    </div>
</footer>
