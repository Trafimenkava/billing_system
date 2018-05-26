<?php
	require_once("php/Database.php");
	require_once("php/User.php");
	require_once("php/Services.php");
	require_once("php/TariffPlans.php");
	require_once("php/Users.php");
	require_once("pChart/pChart/pData.class");
	require_once("pChart/pChart/pChart.class");
	
	$conn = DataBase::getConnection();
	session_start();	
	if (!isset($_SESSION["email"]) && !isset($_COOKIE["email"])) {
		header("location: index.php");
	} else {
		$currentEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : $_COOKIE["email"];
		$currentUser = new User(null, null, $currentEmail);	
		$currentUser  = $currentUser->getUserByEmail($conn);
	}
	
	$users = new Users();
	$users_amount = $users->getAmountOfUsers($conn);
	
	$services = new Services();
	$services_amount = $services->getAmountOfServices($conn);
	
	$tariff_plans = new TariffPlans();
	$tariff_plans_amount = $tariff_plans->getAmountOfTariffPlans($conn);
	
	$popular_tariff_plans = new TariffPlans();
	$popular_tariff_plans = $popular_tariff_plans->getPopularTariffPlans($conn);
	
	$distributed_tariff_plans = new TariffPlans();
	$distributed_tariff_plans = $distributed_tariff_plans->getDistributionOfTariffPlans($conn);
	
	$DataSet = new pData;
	$params = Array();
	$legend = Array();
	
	foreach($distributed_tariff_plans as $distributed_tariff_plan): 
		array_push($params, $distributed_tariff_plan['amount']);
		array_push($legend, $distributed_tariff_plan['title']);						
	endforeach; 
							
	$DataSet->AddPoint($params,"Serie1");
	$DataSet->AddPoint($legend,"Serie2");
	$DataSet->AddAllSeries();
	$DataSet->SetAbsciseLabelSerie("Serie2");

	// Initialise the graph
	$Test = new pChart(600,250);
	$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
	$Test->drawFilledRoundedRectangle(7,7,293,193,5,240,240,240);
	$Test->drawRoundedRectangle(5,5,295,195,5,230,230,230);

	// Draw the pie chart
	$Test->AntialiasQuality = 0;
	$Test->setShadowProperties(2,2,200,200,200);
	$Test->drawFlatPieGraphWithShadow($DataSet->GetData(),$DataSet->GetDataDescription(),120,100,60,PIE_PERCENTAGE,8);
	$Test->clearShadow();

	$Test->drawPieLegend(230,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

	$Test->Render("img/diagramm.png");
	
	$services_statistic = new Services();
	$services_statistic = $services_statistic->getMonthlyServices($conn);
	
	$DataSet = new pData();
	$params = Array();
	$legend = Array();
	
	foreach($services_statistic as $service_statistic): 
		array_push($params, $service_statistic['connection_date']);
		array_push($legend, $service_statistic['amount']);						
	endforeach;
	
	// Dataset definition 
	$DataSet->AddPoint($params,"Serie1");
	$DataSet->AddPoint($legend,"Serie2");
	$DataSet->AddAllSeries();
	$DataSet->RemoveSerie("Serie1");
	$DataSet->SetAbsciseLabelSerie("Serie1");
	$DataSet->SetXAxisName($Name="День");
    $DataSet->SetYAxisName($Name="Количество заказов");

	 // Initialise the graph
	 $Test = new pChart(1000,330);
	 $Test->drawGraphAreaGradient(132,153,172,50,TARGET_BACKGROUND);

	 // Graph area setup
	 $Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
	 $Test->setGraphArea(60,20,885,280);
	 $Test->drawGraphArea(213,217,221,FALSE);
	 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,213,217,221,TRUE,0,2);
	 $Test->drawGraphAreaGradient(162,183,202,50);
	 $Test->drawGrid(4,TRUE,230,230,230,20);

	 // Draw the line chart
	 $Test->setShadowProperties(3,3,0,0,0,30,4);
	 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
	 $Test->clearShadow();
	 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),4,2,-1,-1,-1,TRUE);

	 // Render the picture
	 $Test->Render("img/diagramm2.png"); 
?>
<!DOCTYPE html>
	<head>
    	<meta charset="utf-8">
	    <title>Биллинговая система</title>		
		<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Droid+Sans:400,700' />
		<link rel="shortcut icon" href="ico/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="ico/apple-touch-icon.png" />
		<link rel="apple-touch-icon" sizes="57x57" href="ico/apple-touch-icon-57x57.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="ico/apple-touch-icon-72x72.png" />
		<link rel="apple-touch-icon" sizes="76x76" href="ico/apple-touch-icon-76x76.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="ico/apple-touch-icon-114x114.png" />
		<link rel="apple-touch-icon" sizes="120x120" href="ico/apple-touch-icon-120x120.png" />
		<link rel="apple-touch-icon" sizes="144x144" href="ico/apple-touch-icon-144x144.png" />
		<link rel="apple-touch-icon" sizes="152x152" href="ico/apple-touch-icon-152x152.png" /> 
	    <link href="css/bootstrap.min.css" rel="stylesheet">	
		<link href="css/jquery.mmenu.css" rel="stylesheet">		
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">			
	    <link href="css/style.min.css" rel="stylesheet">
		<link href="css/add-ons.min.css" rel="stylesheet">
		<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
</head>

<body>
	<!-- start: Header -->
	<div class="navbar" role="navigation">
	
		<div class="container-fluid">		
			
			<ul class="nav navbar-nav navbar-actions navbar-left">
				<li class="visible-md visible-lg"><a href="home.php#" id="main-menu-toggle"><i class="fa fa-th-large"></i></a></li>
				<li class="visible-xs visible-sm"><a href="home.php#" id="sidebar-menu"><i class="fa fa-navicon"></i></a></li>			
			</ul>
			
			<form class="navbar-form navbar-left">
				<button type="submit" class="fa fa-search"></button>
				<input type="text" class="form-control" placeholder="Поиск..."></a>
			</form>
			
	        <ul class="nav navbar-nav navbar-right">
				<li class="dropdown visible-md visible-lg">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i></a>					
					<?php include("menu.php"); ?>
				</li>
				<li class="dropdown visible-md visible-lg">
	        		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class="user-avatar" src="img/<?=$currentUser->getUserImage()?>" alt="user-mail"><?=$currentUser->getUserEmail()?></a>
	        		<ul class="dropdown-menu">
						<li class="dropdown-menu-header">
							<strong>Аккаунт</strong>
						</li>						
						<li><a href="page_profile.php?id=<?=$currentUser->getUserId()?>"><i class="fa fa-user"></i> Профайл</a></li>						
						<li><a href="logout.php"><i class="fa fa-sign-out"></i> Выйти</a></li>	
	        		</ul>
	      		</li>
			</ul>
			
		</div>
		
	</div>
	<!-- end: Header -->
	
	<div class="container-fluid content">
	
		<div class="row">
				
			<!-- start: Main Menu -->
<div class="sidebar ">
								
				<div class="sidebar-collapse">
					<div class="sidebar-header t-center">
                        <span><img class="text-logo" src="img/logo1.png"></span>
                    </div>										
					<div class="sidebar-menu">						
						<ul class="nav nav-sidebar">
							<li><a href="home.php"><i class="fa fa-home"></i><span class="text"> Главная</span></a></li>
							<li><a href="tariff_plans_groups.php"><i class="fa fa-list-alt"></i><span class="text"> Группы тарифных планов</span></a></li>	
							<li>
								<a href="#"><i class="fa fa-table"></i><span class="text"> Тарифные планы</span> <span class="fa fa-angle-down pull-right"></span></a>
								<ul class="nav sub">
									<li><a href="tariff_plans.php"><i class="fa fa-columns"></i><span class="text"> Список</span></a></li>
									<li><a href="tariff_selection.php"><i class="fa fa-check-square-o"></i><span class="text"> Подобрать тариф</span></a></li>
									<li><a href="tariff_plan.php?action=add"><i class="fa fa-plus-square"></i><span class="text"> Добавить тариф</span></a></li>							
								</ul>
							</li>
							<li>
								<a href="#"><i class="fa fa-users"></i><span class="text"> Пользователи</span> <span class="fa fa-angle-down pull-right"></span></a>
								<ul class="nav sub">
									<li><a href="users.php"><i class="fa fa-columns"></i><span class="text"> Список</span></a></li>
									<li><a href="add_user.php"><i class="fa fa-plus-square"></i><span class="text"> Добавить пользователя</span></a></li>
								</ul>
							</li>
							<li>
								<a href="#"><i class="fa fa-envelope-o"></i><span class="text"> Шаблоны сообщений</span> <span class="fa fa-angle-down pull-right"></span></a>
								<ul class="nav sub">
									<li><a href="notification_catalog.php"><i class="fa fa-columns"></i><span class="text"> Каталог сообщений</span></a></li>
									<li><a href="notification_rules.php"><i class="fa fa-comment-o"></i><span class="text"> Правила создания</span></a></li>
								</ul>
							</li>														
						</ul>
					</div>						
				</div>
				<div class="sidebar-footer">					
					
					<div class="sidebar-brand">
						Velcom
					</div>
					
					<ul class="sidebar-terms">
						<li><a href="index.html#">Terms</a></li>
						<li><a href="index.html#">Privacy</a></li>
						<li><a href="index.html#">Help</a></li>
						<li><a href="index.html#">About</a></li>
					</ul>
					
					<div class="copyright text-center">
						<small>&copy; 2018 All Right Reserved</small>
					</div>					
				</div>	
				
			</div>
			<!-- end: Main Menu -->
		
		<!-- start: Content -->
			<div class="main">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-laptop"></i> Главная</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.html">Главная</a></li>		  	
					</ol>
				</div>
			</div>
			<div class="row">
				
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="info-box red-bg">
						<i class="fa fa-shopping-cart"></i>
						<div class="count"><?=$services_amount?></div>
						<div class="title">Услуги</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
				
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="info-box green-bg">
						<i class="	fa fa-users"></i>
						<div class="count"><?=$users_amount?></div>
						<div class="title">Пользователи</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
				
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="info-box blue-bg">
						<i class="fa fa-mobile"></i>
						<div class="count"><?=$tariff_plans_amount?></div>
						<div class="title">Тарифные планы</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->	
				
			</div><!--/.row-->
			
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><strong>Топ-10 популярных тарифных планов</strong></h2>
						</div>
						<div class="panel-body">
							<?php foreach($popular_tariff_plans as $popular_tariff_plan): ?>
							<span><?=$popular_tariff_plan['title']?></span>
							<div class="progress">
							<span class="top_tariff_plan_amount"> <?=$popular_tariff_plan['amount']?> заказа</span>
								<div class="progress-bar" role="progressbar" aria-valuenow=<?=$popular_tariff_plan['amount']?> aria-valuemin="0" aria-valuemax="10000" style="width: <?=$popular_tariff_plan['amount']*10?>%; background: rgb(<? echo rand(0, 255);?>, <?echo rand(0, 255);?>, <?echo rand(0, 255);?>);">
								</div>
							</div>								
							<?php endforeach; ?>
						</div>
					</div>
				</div><!--/col-->
			
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><strong>Распределение тарифных планов по группам</strong></h2>
						</div>
						<div class="panel-body">
							 <img src="img/diagramm.png">
						</div>
					</div>
				</div><!--/col-->
			
			</div><!--/row-->
			
			<div class="row">
				
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><strong>Количество заказов за прошлый месяц</strong></h2>
						</div>						
						<div class="panel-body">
							 <img src="img/diagramm2.png">
						</div>
					</div>
				</div><!--/col-->			
			
			</div><!--/row-->
			
		</div>
		<!-- end: Content -->
		<br><br><br>		
		
		
	</div><!--/container-->
		
	
		
	<!-- start: JavaScript-->
	<!--[if !IE]>-->

			<script src="js/jquery-2.1.1.min.js"></script>

	<!--<![endif]-->

	<!--[if IE]>
	
		<script src="js/jquery-1.11.1.min.js"></script>
	
	<![endif]-->

	<!--[if !IE]>-->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='js/jquery-2.1.1.min.js'>"+"<"+"/script>");
		</script>

	<!--<![endif]-->

	<!--[if IE]>
	
		<script type="text/javascript">
	 	window.jQuery || document.write("<script src='js/jquery-1.11.1.min.js'>"+"<"+"/script>");
		</script>
		
	<![endif]-->
	<script src="js/jquery-migrate-1.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	
	
	<!-- page scripts -->
	<script src="js/jquery-ui-1.10.4.min.js"></script>
	
	<!-- theme scripts -->
	<script src="js/SmoothScroll.js"></script>
	<script src="js/jquery.mmenu.min.js"></script>
	<script src="js/core.min.js"></script>
	
	<!-- inline scripts related to this page -->
	
	<!-- end: JavaScript-->
	
</body>
</html>