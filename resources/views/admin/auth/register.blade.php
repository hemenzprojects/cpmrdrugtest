@include('admin.layout.admin.login')

<body>
<div class="wthree-dot" >
   @foreach( $errors->all() as $error)
        <li>{{$error}}</li>
	@endforeach
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
											<h3>Drug Analysis Unit</h3>
											<p>For all herbal product analysis for the purpose of product registration by the Food and Drugs Authority (FDA)</p>
										</div>
									</li>
									<li>
										<div class="w3layouts-banner-info">
											<h3>Drug Analysis Unit</h3>
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
						<div class="agile-signin">
							<h4>Already have an account <a href="{{ route('login') }}">Sign In</a></h4>
						</div>
					</div>
				</div>
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
</body>
</html>