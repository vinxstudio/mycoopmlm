@extends('layouts.loginLayout')
@section('content')
	<div class="content">
		<div class="overlay slide">
			<div id="koop-slide" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img class="d-block w-100" src="{{ url('public/img/login/ps1.jpg') }}" alt="First slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100" src="{{ url('public/img/login/ps2.jpg') }}" alt="Second slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100" src="{{ url('public/img/login/ps3.jpg') }}" alt="Third slide">
					</div>
					{{-- <div class="carousel-item">
						<img class="d-block w-100" src="{{ url('public/img/login/ps4.png') }}" alt="Third slide">
					</div> --}}
				</div>
				<a class="carousel-control-prev" href="#koop-slide" role="button" data-slide="prev">
					<span class="fas fa-angle-left fa-fw fa-2x" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#koop-slide" role="button" data-slide="next">
					<span class="fas fa-angle-right fa-fw fa-2x" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
		<div class="overlay py-5">
				<div class="container">
					<div class="row">
						<div class="col order-last order-sm-first">
							<h2 class="title display-4 text-uppercase font-weight-normal">Latest News & Updates</h2>
							<hr class="bg-light" style="height: 3px">
							<div class="post w-75 mx-auto">
								<div class="card text-center mb-3 rounded-0 border-0">
									<img class="card-img-top" src="{{ url('public/img/login/post-5.jpg') }}">
									<div class="card-body">
										<h5 class="card-title">List of Accredited Hospitals</h5>
										<a href="javascript:void(0)" class="btn btn-primary right" disable>Read More</a>
									</div>
								</div>
								<div class="card text-center mb-3 rounded-0 border-0">
									<img class="card-img-top" src="{{ url('public/img/login/post-4.jpg') }}">
									<div class="card-body">
										<h5 class="card-title">Car Plan Program</h5>
										<a href="javascript:void(0)" class="btn btn-primary right" disable>Read More</a>
									</div>
								</div>
								<div class="card text-center mb-3 rounded-0 border-0">
									<img class="card-img-top" src="{{ url('public/img/login/post-3.jpg') }}">
									<div class="card-body">
										<h5 class="card-title">The Awardees</h5>
										<p class="card-text uppercase">
											TEAM CPMPC WERPA<br/>
											LUZVIMIN CORPO<br/>
											Cash Cloud Corpo<br/>
											Elmer Mendoza<br/>
											FRANCIS HERMES JAVIER<br/>
											ZENAIDO PATRIARCA<br/>
											CASH CORPO<br/>
											Davao Eagle corpo<br/>
											susan renacia<br/>
											Ulysses Mar Josef<br/>
											CPMPC GIRLS<br/>
											EDDIE MAHILUM<br/>
											Joel baring<br/>
											Marissa Camarillo<br/>
											Raymond Dela Cruz<br/>
											Jan Gerard Jorquia<br/>
											Vivian Hernandez<br/>
											TEAM NAGABAJUG<br/>
											Nelson Lim<br/>
											IPHIL SUCCESS<br/>
											Maria Siao<br/>
											Clint Diocampo<br/>
											Jacob Layan<br/>
											Cpmpc bankers<br/>
											SUGBO SUGBO<br/>
											Living Word<br/>
											Living Water<br/>
											Nonito Gonzales<br/>
											Cpmpc Abante<br/>
											Jehlen Abella<br/>
											mary ann cristobal<br/>
											Nazareno Negapatan<br/>
											DANTE SOTES<br/>
											Elvie Pacheco<br/>
											Cerilo Senia<br/>
											jennifer crampatanta<br/>
											Josephine Labra<br/>
											Eliarde lagoc<br/>
											Rosmel Lestino<br/>
											ester palo-ay<br/>
											Editha Alegre<br/>
											Rolando Nadores<br/>
											Judee Lou Yap<br/>
											Isidro Roble<br/>
											Armando Rallos<br/>
											Charito Panibon<br/>
											GENOVEVA ARCENO<br/>
											Aileen Limosnero<br/>
											rachel lumapay<br/>
											Sirikit Carbajosa<br/>
											Renalin Martem<br/>
											Maria Marlene Ladonga<br/>
											Jason Badajos<br/>
											Efren Lauron<br/>
											marjurie hemoroz<br/>
											Emelie Ferrer<br/>
											Yvonne Cometa<br/>
											BLAST Philippines<br/>
											Rizalde Dingding<br/>
											AKLAN TEAM<br/>
											Phoebe Joan Mendoza<br/>
											Avelino Dalaguit<br/>
											Iloilo Team<br/>
											Erwin Perez<br/>
											Evan Modena<br/>
											Sharon Toquero<br/>
											wilbert natulla<br/>
											TEAM SMASHER<br/>
											Evangeline Ygona<br/>
											JULHERES EVANGELIO<br/>
											TEAM LAPULAPU<br/>
											CIELOU APAS<br/>
											SUSAN MELGAREJO<br/>
											ELMER DAMALERIO<br/>
											RITCHE DAGATAN<br/>
											MIREN BCD CORPO<br/>
											Guillermo Bande<br/>
											Marvin Dalaguit<br/>
											mary ann villasica<br/>
											AN PRAYER E-N AN PRAYER E-N<br/>
											ARLYNE LIM<br/>
											Carmela Espina<br/>
											Charlene Villapaz<br/>
											Daisy Doria<br/>
											Cebu Peoples Coop Ho<br/>
											geroselle tagalog<br/>
											CRISTINA APAS<br/>
											Team Bendita<br/>
											Alicia Fabian<br/>
											editha park<br/>
											Daphney Merida<br/>
											TEAM ABC1<br/>
											Michael Abella<br/>
											Angel Bantilan<br/>
											Analyn Sedillo<br/>
											Elenita Belisenia<br/>
											Lilibeth Venan<br/>
											TACLOBAN PAJACAA<br/>
											Rey Robert Navales<br/>
											Antonette Lico<br/>
											Isidore Pajarillo<br/>
											ELMER TABILE<br/>
											Marilou Mendrico<br/>
											AMTRACO AMTRACO<br/>
											Vicente Naquimen Jr.<br/>
											GAISANO CAPITAL<br/>
											richard viquiera<br/>
											Jocelyn Rios<br/>
											Lionel Alusin<br/>
											Nemuel Sedillo<br/>
											Rolando Pelletero<br/>
											TEAM ABC2<br/>
											Ludimar Galvez<br/>
											Ranjie Dosdos<br/>
											Team Kamaro<br/>
											Ronnie Fonacier<br/>
											Morillo Molina<br/>
											NEIL BUTIONG<br/>
											Rosevelyn Villanueva<br/>
											Save Save<br/>
											Analyn Nadela<br/>
											Balbino Yu<br/>
											HILARIO LLIDO<br/>
											Esmael Sedillo<br/>
											NELSON SALERA<br/>
											riza lugatiman<br/>
											Jerome Tago<br/>
											Antonio Nierva<br/>
											Silvera Guradillo<br/>
											Dongito Baja<br/>
											Dennis Sambilad<br/>
											Rolando Nadores Jr.<br/>
											Editha Villar<br/>
											Jocelyn Pugoy<br/>
											Ricky Pacheco<br/>
											Steffi Labayan<br/>
											Maria Theresa Yambao<br/>
											Geraldine Choi<br/>
											Charisa Gillana<br/>
											OSCAR FERNANDEZ<br/>
											Delia Catacutan<br/>
											Consolacion Reuyan<br/>
											MA JULISA RECLA<br/>
											Rey M.<br/>
											Junilo Gamutan<br/>
											ANGELO CUYAG<br/>
											PERCELA GULISAO<br/>
											zonal angels<br/>
											Armando31967 Rallos<br/>
											Jocelyn Mangin<br/>
											TEAM ROQUE<br/>
											Maida Lou Mahilum<br/>
											Marlon Jayke Batucan<br/>
											Dumaguete Explorers<br/>
											Ma. Luisa Lourdes Sensal<br/>
											Dufelden Panibon<br/>
											REXIS MINDORO<br/>
											Angelica Baylosis<br/>
											Michael Niegas<br/>
											DUMANJUG SHAKA<br/>
											Alma Alfeche<br/>
											SYRA PENAS<br/>
											LOLITA RUFO<br/>
											Graces In The Air Corporation<br/>
											SHARON TABILE<br/>
											ANASTACIO ANGOT<br/>
											Emilio Lumapay Jr.<br/>
											Jennifer Delgado<br/>
											Erwin Canuday<br/>
											Reymond Pineda<br/>
											Janice Wella Duhaylungsod<br/>
											Romnick Elesterio<br/>
											chuchi abellana<br/>
											Araceli Juario<br/>
											Errol Mendoza<br/>
											Joy Ybas<br/>
											Leo Pelletero<br/>
											Elsa Malabar<br/>
											Joselo Cimafranca<br/>
											Rudelyn Alimpolos<br/>
											Ronald Muana<br/>
											Nobleto Macalino<br/>
											Salvador Barcia<br/>
											Hanahbai Bacar<br/>
											Joseph Moloboco<br/>
											TEAM DAGOHOY<br/>
											Christian Jay Ruba<br/>
											Noraisa Dalupang<br/>
											Anna Carmela Sarsalejo<br/>
											Emmanuel Josef<br/>
											Shendy Emperado<br/>
											Dennis Corpo 1<br/>
											Japhet Tuvilla<br/>
											CORAZON ORBETA<br/>
											Irene Serad<br/>
											Russelle Silos<br/>
											Miguel Yusay<br/>
											TUDELA OMING<br/>
											Elisa Villar<br/>
											Irene Gacal<br/>
											Joephine Lazaro<br/>
											maylen Palarion<br/>
											Pelagio Carbajosa<br/>
											The Team<br/>
											Ezekiel Josef<br/>
											Junard Viscayno<br/>
											Veena Perpetua<br/>
											Roby Tagyamon<br/>
											SECRET CORP.<br/>
											CPMPC BOSS<br/>
											Ellenbert Catayas<br/>
											REMIA BASCO<br/>
											EAGLE INTERNATIONAL CORPO EAGLE INTERNATIONAL CORPO<br/>
											Rosemarie Golisao<br/>
											Vicente Taping<br/>
											TEAM 1<br/>
											Varun Mahajan<br/>
											Belinda Inao<br/>
											Jhufel Sarno<br/>
											Peter Rollon<br/>
											Nida Bercero<br/>
											Marilia Tabaranza<br/>
											Rogelio Lim<br/>
											Bai Sulaya Siao<br/>
											TEAM RANGER<br/>
											Anelia Kasilag<br/>
											Bonn Rainauld Tibod<br/>
											Florianne Marie Bitang<br/>
											Ritchel Diacosta<br/>
											LOURDES MEJALA<br/>
											Rich Corpo<br/>
											Evelyn Ejercito<br/>
											LILIBETH BUCCAT<br/>
											Francisco Jr. Egos<br/>
											Gayle Joyce Bande<br/>
											juvyan888 corpo<br/>
											Lief Limos<br/>
											Jose Ricky Misa<br/>
											Bernard Walang<br/>
											CPMPC PRETTYMOM<br/>
											Editha Murillo<br/>
											Johnny Siao<br/>
											Jose Pane<br/>
											MA.ZENAIDA MONTESCLAROS<br/>
											Tanjay Eagles<br/>
											Annie Samper<br/>
											TEAM BOBA<br/>
											Estela Oftana<br/>
											Mohammadin Kusain<br/>
											Cebu People's Coop Head Office<br/>
											Eliezer Acabal<br/>
											jeffrey caringal<br/>
											Jerry Hernandez<br/>
											Marlyn Icot<br/>
											Melvin Baltazar<br/>
											RUSSELL ALEJANDRO<br/>
											Erwin Ebarita<br/>
											ESPERANZA BALAGEO<br/>
											Lourdes Opsima<br/>
											Via Nerves<br/>
											MARLOU DAMALERIO<br/>
											Helen Bacolod<br/>
											lolita morales<br/>
											Morgan Gerobise<br/>
											Cherrylyn Hashimoto<br/>
											Cpmpc worship worship<br/>
											Fernando Samarita<br/>
											Nellie Geolamen<br/>
											Nila Viray<br/>
											JENNY DAMALERIO<br/>
											Michael Hernandez<br/>
											ROSANA PAHID<br/>
											TEAM 8<br/>
											Lielane Villaceran<br/>
											Sarena Balidio<br/>
											JOB GEOLAMEN<br/>
											Gemma Galay<br/>
											TRIFON RAMOS<br/>
											Armando II Garing<br/>
											Edward Poblete<br/>
											Jose Evagelous Lawenko<br/>
											Maria Liza Petagara<br/>
											Global Cooperative<br/>
											Jeanie Balajadia<br/>
											LISANDRO OMAR ORBETA<br/>
											Maria Vina Calamba<br/>
											TEAM 2<br/>
											Amalia Fuellas<br/>
											Arlene Yanson<br/>
											blessings 2018 corpo<br/>
											Fielpher Cortes<br/>
											JOPIT DIOCALES<br/>
											Maria Consolacion Gamez<br/>
											MARISSA BONCALES<br/>
											Wilmer Palma<br/>
											Arnold Bulak<br/>
											Delia Alcontin<br/>
											Federico Carpio<br/>
											Melecio Berdon<br/>
											Nonito Villarin<br/>
											Elenerio jr. Calising<br/>
											Junel Dela Cruz<br/>
											Pasil Chapter Corpo 1<br/>
											Ancilla Bonghanoy<br/>
											Arjelyn Liron<br/>
											Corazon Balidio<br/>
											Ferdinand Boniao<br/>
											Florence Tangente<br/>
											Jesseli Limbaga<br/>
											Jose Maria Glenn Olea<br/>
											Ma. Josenena Pacana<br/>
											Maria Brena Tabay<br/>
											Raz Corpo<br/>
											ROSALINDA VELORIA<br/>
											susan lavadia<br/>
											TEAM 5<br/>
											Zenaida Alegado<br/>
											CPMPC SUNSHINE<br/>
											Czech Team<br/>
											Florencia Nable<br/>
											Rachel Ann Sagal<br/>
											Baimon Abdulbasit<br/>
											Glendy Ponsica<br/>
											Nida Molina<br/>
											Vergil Bancaerin<br/>
											Bacolod Unified Corpo<br/>
											GLENN GINGOYON<br/>
											yuyien delos reyes<br/>
											Erwin Talacay<br/>
											Angel Sabulao<br/>
											Chester Burgos<br/>
											CPMPC SPIDERMAN<br/>
											Eduardo Tutesora<br/>
											hannah nina gecomo<br/>
											Saturnino Rios<br/>
											Romulo Polgo<br/>
											TEAM 3<br/>
											TEAM 4<br/>
											TEAM 6<br/>
											TEAM 7<br/>
											Javan Juario<br/>
											Noretha Fernandes<br/>
											Virginia Panogan<br/>
											Alice Suico<br/>
											Carmen Acabal<br/>
											Mercedita Cabibil<br/>
											Gloria Gitgano<br/>
											JENNY LUMAGBAS<br/>
											Jinky Toquero<br/>
											olive gecomo<br/>
											AIMAY TORREFIEL<br/>
											Dan-Ag Dumaguete Dan-Ag Dumaguete<br/>
											minda nambong<br/>
											ARAFAT DIPATUAN<br/>
											Jell richmond Mendoza<br/>
											Godofredo Rangas<br/>
											Adelaida Corporal<br/>
											Corpo Canlaon<br/>
											Edgardo Mudlong<br/>
											Teresita Gaite<br/>
										</p>
										<a href="javascript:void(0)" class="btn btn-primary right">Read More</a>
									</div>
								</div>
								<div class="card text-center mb-3 rounded-0 border-0">
									<img class="card-img-top" src="{{ url('public/img/login/post-1.png') }}">
									<div class="card-body">
										<h5 class="card-title">Business Solutions and Capital</h5>
										<p class="card-text">Puhunan sa negosyo, kooperatiba ang maasahan at malalapitan mo.</p>
										<a href="javascript:void(0)" class="btn btn-primary right" disable>Read More</a>
									</div>
								</div>
								<div class="card text-center mb-3 rounded-0 border-0">
									<img class="card-img-top" src="{{ url('public/img/login/post-2.png') }}">
									<div class="card-body">
										<h5 class="card-title">Education</h5>
										<p class="card-text">Anak ng miyembro, sigurado makapag-aral sa kolehiyo.</p>
										<a href="javascript:void(0)" class="btn btn-primary right">Read More</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col order-first order-sm-last">
							<div class="sign mb-3 w-75 mx-auto" id="login">
								{{ BootstrapAlert() }}
								<h2 class="title display-4 text-uppercase mb-3 font-weight-normal">Sign In</h2>
								{{ Form::open(
									[
										'class'=>'sign-in form-horizontal rounded no-overflow'
									]
								) }}
								
									<div class="form-group">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<div class="{{ $errors->first('email') ? 'has-error has-feedback' : null }}">
											<input type="text" class="form-control" placeholder="{{ Lang::get('labels.username') }}" name="email">
											{{ validationError($errors, 'email') }}
										</div>
									</div>
									<div class="form-group">
										<input type="password" class="form-control" placeholder="{{ Lang::get('labels.password') }}" name="password">
									</div>
									<button type="submit" class="btn btn-dark d-block w-100 rounded-0">LOGIN</button>
									<div class="row my-3 text-center">
										<div class="col">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value="" id="remember-pass">
												<label class="form-check-label" for="remember-pass">Remember Password</label>
											</div>
										</div>
										<div class="col">
											<a href="#" class="forgot-pass">Forgot Password?</a>
										</div>
									</div>
								{{ Form::close() }}
							</div>
							<div class="pdf mb-3 ">
								<h2 class="title text-uppercase font-weight-bold">AWARDING PRESENTATIONS</h2>
								<hr class="bg-dark" style="height: 3px">
								<div class="row pdf-list my-3">
									@for($i = 1; $i < 10; $i++)
										<div class="gallery">
											<a href="{{ url('public/img/Awarding_Presentations/CebuCoopAwarding_Presentations-'.$i.'.jpg') }}" target="_blank">
												<img width="600" height="400" src="{{ url('public/img/Awarding_Presentations/CebuCoopAwarding_Presentations-'.$i.'.jpg') }}" alt="">
											</a>
										</div>
									@endfor
								</div>
								<a class="d-block text-center font-weight-bold right" href="/auth/awarding">More Pictures Here..</a>
							</div>
							<div class="pdf mb-3 ">
								<h2 class="title text-uppercase font-weight-bold">REGISTRATION SOCIALS</h2>
								<hr class="bg-dark" style="height: 3px">
								<div class="row pdf-list my-3">
									@for($i = 1; $i < 10; $i++)
										<div class="gallery">
											<a href="{{ url('public/img/Registration_Socials/CebuCoopReg_Socials-'.$i.'.jpg') }}" target="_blank">
												<img width="600" height="400" src="{{ url('public/img/Registration_Socials/CebuCoopReg_Socials-'.$i.'.jpg') }}" alt="">
											</a>
										</div>
									@endfor
								</div>
								<a class="d-block text-center font-weight-bold right" href="/auth/registration-socials">More Pictures Here..</a>
							</div>
							<div class="pdf mb-3 ">
								<h2 class="title text-uppercase font-weight-bold">WIDE</h2>
								<hr class="bg-dark" style="height: 3px">
								<div class="row pdf-list my-3">
									@for($i = 1; $i < 9; $i++)
										<div class="gallery">
											<a href="{{ url('public/img/Wide/CebuCoopAwarding_PresentationsGP-'.$i.'.jpg') }}" target="_blank">
												<img width="600" height="400" src="{{ url('public/img/Wide/CebuCoopAwarding_PresentationsGP-'.$i.'.jpg') }}" alt="">
											</a>
										</div>
									@endfor
								</div>
								<a class="d-block text-center font-weight-bold right" href="/auth/wide">More Pictures Here..</a>
							</div>
							<div class="pdf mb-3 ">
								<h2 class="title text-uppercase font-weight-bold">Downloadable Forms</h2>
								<hr class="bg-dark" style="height: 3px">
								<div class="row pdf-list my-3">
									<div class="col-12 col-sm-4 text-center my-3">
										<a href="javascript:void(0)">
											<img src="{{ url('public/img/login/pdf.png') }}" alt="">
											<span class="d-block mt-2">Mycoop Care Card.pdf</span>
										</a>
									</div>
									<div class="col-12 col-sm-4 text-center my-3">
										<a href="javascript:void(0)">
											<img src="{{ url('public/img/login/pdf.png') }}" alt="">
											<span class="d-block mt-2">Membership Form.pdf</span>
										</a>
									</div>
									<div class="col-12 col-sm-4 text-center my-3">
										<a href="javascript:void(0)">
											<img src="{{ url('public/img/login/pdf.png') }}" alt="">
											<span class="d-block mt-2">Thru Money Form.pdf</span>
										</a>
									</div>
									<div class="col-12 col-sm-4 text-center my-3">
										<a href="javascript:void(0)">
											<img src="{{ url('public/img/login/pdf.png') }}" alt="">
											<span class="d-block mt-2">Education Form.pdf</span>
										</a>
									</div>
									<div class="col-12 col-sm-4 text-center my-3">
										<a href="javascript:void(0)">
											<img src="{{ url('public/img/login/pdf.png') }}" alt="">
											<span class="d-block mt-2">Loans Form.pdf</span>
										</a>
									</div>
									<div class="col-12 col-sm-4 text-center my-3">
										<a href="javascript:void(0)">
											<img src="{{ url('public/img/login/pdf.png') }}" alt="">
											<span class="d-block mt-2">Request Form.pdf</span>
										</a>
									</div>
									<div class="col-12 col-sm-4 text-center my-3">
										<a href="javascript:void(0)">
											<img src="{{ url('public/img/login/pdf.png') }}" alt="">
											<span class="d-block mt-2">Members Information Card Form.pdf</span>
										</a>
									</div>
									<div class="col-12 col-sm-4 text-center my-3">
										<a href="javascript:void(0)">
											<img src="{{ url('public/img/login/pdf.png') }}" alt="">
											<span class="d-block mt-2">Share Capital Subscription Agreement.pdf</span>
										</a>
									</div>
									<div class="col-12 col-sm-4 text-center my-3">
										<a href="javascript:void(0)">
											<img src="{{ url('public/img/login/pdf.png') }}" alt="">
											<span class="d-block mt-2">Damayan Mortuary.pdf</span>
										</a>
									</div>
								</div>
								<a class="d-block text-center font-weight-bold right" href="javascript:void(0)">More Forms Here..</a>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
@stop

@section('pageIncludes')
    <script src="{{ url('public/assets/global/plugins/bower_components/jquery-validation/dist/jquery.validate.min.js') }}"></script>
@stop