<?php	
	require_once("php/Database.php");
	require_once("php/User.php");
	require_once("php/Client.php");
	require_once("php/TariffPlan.php");
	require_once("php/TariffPlans.php");
	require_once("php/Service.php");
	require_once("php/Services.php");
	require_once("php/Account.php");
	require_once("php/Notification.php");
	
	const TRIGGER_TYPE_ADD_SERVICE = "Подключение услуги";
	
	session_start();
	$conn = DataBase::getConnection();	
	if (!isset($_SESSION["email"]) && !isset($_COOKIE["email"])) {
		header("location: index.php");
	} else {
		$currentEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : $_COOKIE["email"];
		$currentUser = new User(null, null, $currentEmail);	
		$currentUser  = $currentUser->getUserByEmail($conn);
	}

	$id = $_GET["id"];
	$action = isset($_GET['action']) ? $_GET['action'] : ''; 
	
	$client = new Client($id);	
	$client = $client->getClientById($conn);
	
	if ($action == 'save_service'){
		$tariff_plan_title = trim($_POST["tariff_plan_title"]);
		$telephone_number = $_POST["telephone_number"];
		$status = $_POST["status"];
		$t_plan = new TariffPlan();
		$t_plan = $t_plan->getTariffPlanByTitle($conn, $tariff_plan_title);
		$service = new Service(null, $id, $t_plan->getTariffPlanId(), $telephone_number, $status);
		$result = $service->addService($conn);
		$new_account = new Account($result);
		$new_account->addAccount($conn);
		
		$notificationParams = array(
			'$_SURNAME', $client->getUserSurname(),
			'$_NAME', $client->getUserName(),
			'$_LASTNAME', $client->getUserLastname(),
			'$_TARIFF_PLAN_TITLE', $tariff_plan_title,
			'$_TELEPHONE_NUMBER', $telephone_number
		);

		$notification = new Notification();
		$notification = $notification->getNotificationByTriggerType($conn, TRIGGER_TYPE_ADD_SERVICE)->sendNotification($conn, $client->getUserEmail(), $notificationParams);	
	}
		
	$services = new Services();
	$services = $services->getServicesByClientId($conn, $id);
	
	$tariff_plans = new TariffPlans();
	$tariff_plans = $tariff_plans->getActiveTariffPlans($conn);

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
		<link rel="icon" href="img/icon.png" type="image/x-icon">
	    <link href="css/bootstrap.min.css" rel="stylesheet">	
		<link href="css/jquery.mmenu.css" rel="stylesheet">		
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">			
	    <link href="css/style.min.css" rel="stylesheet">
		<link href="css/add-ons.min.css" rel="stylesheet">
		<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
		<script>
		$(document).ready(function() {
   // инициализация кнопок и добавление функций на событие нажатия
   $("#add_service").button().click(function() {
	   alert("1");
      var create_dialog = $("#dialog_window_1");
      var create_button = $(this);
 
      // если окно уже открыто, то закрыть его и сменить надпись кнопки
      if( create_dialog.dialog("isOpen") ) {
         create_dialog.dialog("close");
      } else {
         create_dialog.dialog("open");
      }
   });
 
   // autoOpen : false – означает, что окно проинициализируется но автоматически открыто не будет 
   $("#dialog_window_1").dialog({
      width: "30%",
      height: "auto",
	  position:['middle',100],
      autoOpen : false
   });
 
  $("#buttonlist").buttonset();
});
	
		</script>
</head>

<body>
	<!-- start: Header -->
	<div class="navbar" role="navigation">
	
		<div class="container-fluid">		
			
			<ul class="nav navbar-nav navbar-actions navbar-left">
				<li class="visible-md visible-lg"><a href="#" id="main-menu-toggle"><i class="fa fa-th-large"></i></a></li>
				<li class="visible-xs visible-sm"><a href="#" id="sidebar-menu"><i class="fa fa-navicon"></i></a></li>			
			</ul>
			
			<form class="navbar-form navbar-left">
				<button type="submit" class="fa fa-search"></button>
				<input type="text" class="form-control" placeholder="Поиск..."></a>
			</form>
			
	        <ul class="nav navbar-nav navbar-right">
				<li class="dropdown visible-md visible-lg">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i></a>					
					<ul class="dropdown-menu update-menu" role="menu">
						<li><a href="#"><i class="fa fa-database"></i> Database </a>
                        </li>
                        <li><a href="#"><i class="fa fa-bar-chart-o"></i> Connection </a>
                        </li>
                        <li><a href="#"><i class="fa fa-bell"></i> Notification </a>
                        </li>
                        <li><a href="#"><i class="fa fa-envelope"></i> Message </a>
                        </li>
                        <li><a href="#"><i class="fa fa-flash"></i> Traffic </a>
                        </li>
						<li><a href="#"><i class="fa fa-credit-card"></i> Invoices </a>
                        </li>
                        <li><a href="#"><i class="fa fa-dollar"></i> Finances </a>
                        </li>
                        <li><a href="#"><i class="fa fa-thumbs-o-up"></i> Orders </a>
                        </li>
						<li><a href="#"><i class="fa fa-folder"></i> Directories </a>
                        </li>
                        <li><a href="#"><i class="fa fa-users"></i> Users </a>
                        </li>		
					</ul>
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
					<h3 class="page-header"><i class="fa fa-columns"></i>Профайл</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.html">Главная</a></li>
						<li><i class="fa fa-file-text"></i><a href="#">Пользователи</a></li>
						<li><i class="fa fa-heart-o"></i>Профайл</li>				
					</ol>
				</div>
			</div>

			<div class="row profile">
				<?php if ($action == "general_info_edit") 
					include("general_info_edit.php"); 
					else include("general_info.php"); 
				?>				
				
				<?php if ($action == "client_info_edit") 
					include("client_info_edit.php"); 
					else include("client_info.php"); 
				?>
			
			</div><!--/.row profile-->

			<div class="row">	
			
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><strong id="services">Основные услуги</strong>
							<a href="page_profile.php?id=<?=$id?>&action=add_service" style="text-decoration: none"  class="fa fa-plus" id="add_service"></a></h2>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-bordered bootstrap-datatable datatable">
							  <thead>
								  <tr>
									  <th>Тарифный план</th>
                                      <th>Телефонный номер</th>
                                      <th>Дата подключения</th>
									  <th>Дата отключения</th>
									  <th>Статус</th>
									  <th>Лицевой счет</th>
									  <th>Действия</th>
								  </tr>
							  </thead>   
							  <tbody>	
								<?php foreach($services as $service): ?>
								<tr>
									<?php 
										$tariff_plan = new TariffPlan($service->getTariffPlanId(), array());
										$tariff_plan = $tariff_plan->getTariffPlanById($conn);
									?>
									<td><a href=""><?=$tariff_plan->getTariffPlanTitle()?></a></td>
                                    <td><?=$service->getServiceTelephoneNumber()?></td>
                                    <td><?=$service->getServiceConnectionDate()?></td>
									<td><?=$service->getServiceDisconnectionDate()?></td>
									<td>
										<span <?php if($service->getServiceStatus() == "Активна") echo "class = 'label label-default label-success'"; else if ($service->getServiceStatus() == "Заблокирована") echo "class = 'label label-default label-danger'"; else echo "class = 'label label-default'";?>><?=$service->getServiceStatus()?></span>
									</td>									
									<?php
										$account = new Account();
										$account = $account->getAccountByServiceId($conn, $service->getServiceId());
									?>
									<td><?=$account->getAccountId()?></td>
									<td>
										<a class="btn btn-info" href="table.html#">
											<i class="fa fa-edit "></i>
										</a>
									</td>
								</tr>
								<?php endforeach; ?>
								<? if ($action == "add_service"): ?>
    								<tr>
    								    <form method="post" action="page_profile.php?id=<?=$id?>&action=save_service">
    									<td><select class="form-control" name="tariff_plan_title">
    									<?php foreach($tariff_plans as $tariff_plan): ?>
    									<option value="<?=$tariff_plan->getTariffPlanTitle()?>"><?=$tariff_plan->getTariffPlanTitle()?></option>
    									<?php endforeach; ?>
    									</select>
    									</td>
                                        <td><input type="text" class="form-control" name="telephone_number"></td>
                                        <td>-</td>
    									<td>-</td>
    									<td>
    									<select class="form-control"name="status">
    										<option>Неактивна</option>
    										<option>Активна</option>
    										<option>Заблокирована</option>
    									</select>
    									</td>									
    									<td>Создается автоматически</td>
    									<td><button class="btn btn-success"><i class="fa fa-plus"></i></button>
    										<a class="btn btn-danger" href="page_profile.php?id=<?=$id?>"><i class="fa fa-trash-o"></i></a>
    									</td>
    									</form>
    								</tr>
								<? endif; ?>
					
							  </tbody>
						  </table>            
						</div>
					</div>
				</div><!--/col-->
			
			</div><!--/row-->
							
		</div>
		<!-- end: Content -->
		<br><br><br>
		
	
		
	</div><!--/container-->
		
	<div class="clearfix"></div>
	
		
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
	<script src="http://localhost:8888/bootstrap/originAdmin/js/jquery.easy-pie-chart.min.js"></script>
	
	<!-- theme scripts -->
	<script src="js/SmoothScroll.js"></script>
	<script src="js/jquery.mmenu.min.js"></script>
	<script src="js/core.min.js"></script>
	
	
	<!-- end: JavaScript-->
	
</body>
</html>