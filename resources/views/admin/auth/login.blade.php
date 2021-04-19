@include('admin.layout.login')

<body>
<div class="wthree-dot" id="decodeIt" >
	<div class="profile">
		<div class="wrap">
			<div class="wthree-grids">
				<div class="content-left">
					<div class="content-info">

				        <img style="" src="{{ asset('img/logo.jpg') }}">
						<div class="slider">
							<div class="callbacks_container">
								<ul class="rslides callbacks callbacks1" id="slider4">
									<li>
										<div class="w3layouts-banner-info">
											<h3>Drug Analysis Unit </h3>
											<p>For all herbal product analysis for the purpose of product registration by the Food and Drugs Authority (FDA)</p>
										</div>
									</li>
									<li>
										<div class="w3layouts-banner-info">
											<h3> Drug Analysis Unit</h3>
											<p>Reports of analysis are ready within three months of submission and the cost of analysis is GHs460 for Ghanaian companies </p>
										</div>
									</li>
								</ul>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="agileinfo-follow">
							<h4 style="margin-top: -14">Sign Up with</h4>
						</div>
						<div class="agileinfo-social-grids">
							<ul>
								<a href="#"><i class="fa fa-facebook"></i></a>
								<a href="#"><i class="fa fa-twitter"></i></a>
								<a href="#"><i class="fa fa-rss"></i></a>
								<a href="#"><i class="fa fa-vk"></i></a>
								<a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
								<a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
							</ul>
						</div>
						<div class="agile-signin" style="margin: 25px">
							{{-- <h4>Are you a new client ? <a href="{{ route('register') }}">Register</a></h4> --}}
						</div>
					</div>
				</div>
				<div class="content-main">
					<div class="w3ls-subscribe">
						<h4 style="margin-top: 100px">Login </h4>
						 <form class="form-register" action="{{ url('/admin/login') }}" method="POST">
                         @csrf 
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="example@email.com" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                <p style="    color: red; font-stretch: condensed;margin-top: -2px; margin-bottom: 5px;}">
                                        	{{ $errors->first('email') }}</p>
                                    </span>
                                @endif
							 <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="password"  name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                    <p style="color: red; margin: 5px;">{{ $errors->first('password') }}</p>
                                    </span>
                                @endif
							{{-- <input type="email" name="Search" placeholder="Email" required="">
							<input type="password" name="Password" placeholder="Password" required="">
							<input type="password" name="Password" placeholder="Confirm Password" required=""> --}}
							     <div class="col-md-6">
							     <input type="submit" value="Login">
{{-- 							     <a class="fgp" href="#">Forgot Password </a>
 --}}							     
                                  @if (Route::has('password.request'))
                                    <a class="fgp" href="{{ route('password.request') }}">
                                        {{ __('Forgot Password') }}
                                    </a>
                                @endif

							     </div>
                   

						</form>
					</div>
				</div>
				<div class="clear"> </div>
			</div>
			<div class="wthree_footer_copy">
				<p>© 2020 CPMR Drug Analysis. All rights reserved | Design by <a href="http://w3layouts.com/"> CPMR SID DPTM.</a></p>
			</div>
		</div>
	</div>
</div>
<script src="{{asset('logstyle/js/responsiveslides.min.js')}}"></script>
									<script>
										// You can also use "$(window).load(function() {"
										$(function () {
										  // Slideshow 4
										  $("#slider4").responsiveSlides({
											auto: true,
											pager:true,
											nav:false,
											speed: 400,
											namespace: "callbacks",
											before: function () {
											  $('.events').append("<li>before event fired.</li>");
											},
											after: function () {
											  $('.events').append("<li>after event fired.</li>");
											}
										  });
									
										});
</script>
<!--banner Slider starts Here-->
<script language="javascript">
document.onmousedown=disableclick;
status="Right Click Disabled";
function disableclick(event)
{
if(event.button==2)
{
alert(status);
return false;    
}
}



</script>

</body>
</html>