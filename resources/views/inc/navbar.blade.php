<nav class="navbar navbar-inverse" style="border-color:#0088cc; background:#0088cc;">
		<div class="container">
				<div class="navbar-header">

						<!-- Collapsed Hamburger -->
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
								<span class="sr-only">Toggle Navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
						</button>

						<!-- Branding Image -->
						<a href="/" class="navbar-brand"><img src="/storage/images/logo.png" style="width:auto; height:25px;"></a>
				</div>

				<div class="collapse navbar-collapse" id="myNavbar">
						<!-- Left Side Of Navbar -->
						<ul class="nav navbar-nav">
								&nbsp;
								<!-- <li><a class="{{Request::is('items') ? 'active' : ''}}" href="/items"><font size=3 class="loginb">Items</font></a></li>
								<li><a class="{{Request::is('albums') ? 'active' : ''}}" href="/albums"><font size=3 class="loginb">Albums</font></a></li>
								<li><a class="{{Request::is('albums/create') ? 'active' : ''}}" href="/albums/create"><font size=3 class="loginb">Create Album</font></a></li>
				        <li><a class="{{Request::is('contact') ? 'active' : ''}}" href="/contact"><font size=3 class="loginb">Contact</font></a></li> -->
						</ul>

						<!-- Right Side Of Navbar -->
						<ul class="nav navbar-nav navbar-right">
								<!-- Authentication Links -->
								@if (Auth::guest())
										<li><a class="{{Request::is('/') ? 'active' : ''}}" href="/"><font size=3 class="loginb">Подать запрос</font></a></li>
										<li><a class="{{Request::is('login') ? 'active' : ''}}" href="{{ route('login') }}"><font size=3 class="loginb">Login</font></a></li>
								@else
										<li class="dropdown-dsubmenu">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
														<font size=3 class="loginb">{{ Auth::user()->name }}</font> <span class="caret"></span>
												</a>

												<ul class="dropdown-menu dropdown-dmenu" role="menu">
													<li><a href="/home">Запросы</a></li>
													<li><a href="/settings/1">Настройки</a></li>
														<li>
																<a href="{{ route('logout') }}"
																		onclick="event.preventDefault();
																						 document.getElementById('logout-form').submit();">
																		Выйти
																</a>

																<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
																		{{ csrf_field() }}
																</form>
														</li>
												</ul>
										</li>
								@endif
						</ul>
				</div>
		</div>
</nav>
