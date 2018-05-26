<?php	
	require_once("php/Database.php");
	require_once("php/User.php");
	require_once("php/Client.php");
	require_once("php/Account.php");
	require_once("php/Service.php");
	require_once("php/TariffPlan.php");
	require_once("php/TariffPlans.php");
	require_once("php/Payments.php");
	const SERVICE_STATUS_ACTIVE = 'Активна';
			
	session_start();
	$conn = DataBase::getConnection();	
	if (!isset($_SESSION["email"]) && !isset($_COOKIE["email"])) {
		header("location: index.php");
	} else {
		$currentEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : $_COOKIE["email"];
		$currentUser = new User(null, null, $currentEmail);	
		$currentUser  = $currentUser->getUserByEmail($conn);
	}
	
    $id = $_GET['id'];
	$service = new Service($id);
	$service = $service->getServiceById($conn);
	$account = new Account();
	$account = $account->getAccountByServiceId($conn, $service->getServiceId());
	$tariffPlan = new TariffPlan($service->getTariffPlanId());
	$tariffPlan = $tariffPlan->getTariffPlanById($conn);
	$client = new Client($service->getServiceClientId());
	$client = $client->getClientById($conn);
	$payments = new Payments();
	$payments = $payments->getPaymentsByAccountId($conn, $account->getAccountId());
	
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
   $("#create_button").button().click(function() {
      var create_dialog = $("#dialog_window");
      // если окно уже открыто, то закрыть его и сменить надпись кнопки
      if( create_dialog.dialog("isOpen") ) {
         create_dialog.dialog("close");
      } else {
         create_dialog.dialog("open");
      }
   });   
   $("#dialog_window").dialog({
      width: "30%",
      height: "auto",
	  position:['middle',100],
      autoOpen : false
   });
   $("#new_tp").change(function() {
    jQuery.ajax({
			url: "change_tariff_plan.php",
			type: "POST",
			dataType: "html",
			data: $("#ajax_form").serialize(),
			success: function(response) {
				$('#msg').html(response);
			}
		});
    });
});
		</script>
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
	<!-- end: Header -->	<div class="container-fluid content">
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
					<h3 class="page-header"><i class="fa fa-columns"></i>Информация об услуге</h3>
				</div>
			</div>
			<div class="row">
			<div id="dialog_window" class="dialog_window" title="Смена тарифного плана">
			<?php if ($service->getServiceStatus() != SERVICE_STATUS_ACTIVE): ?>
			<p>Вы не можете сменить тарифный план, так как услуга неактивна или заблокирована.</p>
			<?php else: ?>
			<p>Если Вы пока не определились с тарифным планом, на который хотите перейти, Вы можете воспользоваться нашим <a href="tariff_selection.php">Онлайн-консультантом</a>.</p>
								<form method="post" action="change_tariff_plan.php?id=<?=$id?>&action=change" id="ajax_form">
								<div class="form-group" style="display: none">
                                    <label class="control-label">Старый тарифный план</label>
                                    <input type="text" class="form-control" name="old_tp_sf" id="old_tp" value="<?=$tariffPlan->getTariffPlanSubscriptionFee()?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Новый тарифный план</label>
                                    <select class="form-control" name="new_tp_title" id="new_tp">
    									<?php foreach($tariff_plans as $tariff_plan): ?>
    								    <option value="<?=$tariff_plan->getTariffPlanTitle()?>"><?=$tariff_plan->getTariffPlanTitle()?></option>
    									<?php endforeach; ?>
    								</select>
                                </div>
                                <p id="msg"></p>
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary">Сменить</button>
                                </div>
                                </form>
                                <?php endif; ?>
								</div>
			<div class="col-md-6"><div class="panel panel-default">
						<div class="panel-heading">
                            <h2><strong>Информация об услуге</strong> 
                        </div>
						<div class="panel-body">
							<ul class="profile-details">
								<li>
									<div><i class="fa fa-asterisk"></i> Идентификатор услуги</div>
									<?=$service->getServiceId()?>
								</li>
								<li>
									<div><i class="fa fa-phone"></i> Телефонный номер</div>
									<?=$service->getServiceTelephoneNumber()?>
								</li>
								<li>
									<div><i class="fa fa-calendar"></i> Дата подключения</div>
									<?=$service->getServiceConnectionDate()?>
								</li>
								<li>
									<div><i class="fa fa-calendar"></i> Дата отключенния</div>
									<?=$service->getServiceDisconnectionDate()?>
								</li>
								<li>
									<div><i class="fa fa-bars"></i> Статус</div>
									<?=$service->getServiceStatus()?>
								</li>
								<li>
									<div><i class="fa fa-user"></i> Абонент</div>
									<a href="page_profile.php?id=<?=$client->getUserId()?>"><?=$client->getUserSurname()?></a>
								</li>
							</ul>	
							<button type="button" class="btn btn-success" id="create_button">Сменить тарифный план</button>
						</div>
					</div>
				</div><!--/.col-->	
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-default">
						<div class="panel-body text-center" style="height:180px">
							<h2 class="lime">Баланс лицевого счета №<?=$account->getAccountId()?></h2>
							<div style="width:300px;left:50%;position:absolute;margin-left:-150px;">
								<canvas id="gauge1"></canvas>
							</div>
							<span><strong class="blue"><?=$account->getAccountBalance()?> BYN</strong></span>
						</div>							
					</div>	
				</div><!--/.col-->
							<div class="col-lg-3 col-md-6">
					<div class="panel panel-default">
						<div class="panel-body text-center" style="height:180px">
							<h2 class="lime">Тарифный план</h2>
							<div style="width:300px;left:50%;position:absolute;margin-left:-150px;">
								<canvas id="gauge1"></canvas>
							</div>
							<span><strong class="blue"><?=$tariffPlan->getTariffPlanTitle()?></strong></span>
						</div>							
					</div>	
				</div><!--/.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><strong>История платежей</strong></h2>
						</div>
						<div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>Сумма, BYN</th>
                                        <th>Дата</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($payments as $payment): ?>
										<tr>
											<td>
												<?=$payment->getPaymentId()?>
											</td>
											<td><?=$payment->getPaymentMoney()?></td>
											<td><?=$payment->getPaymentDate()?></td>
										</tr>
									<?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
					</div>
				</div><!--/.col-->			</div><!--/row-->
		</div>
		<!-- end: Content -->
		<br><br><br>	</div><!--/container-->	<div class="clearfix"></div>
	<script src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript">		window.jQuery || document.write("<script src='js/jquery-2.1.1.min.js'>"+"<"+"/script>");	</script>
	<script src="js/jquery-migrate-1.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>		<script src="js/jquery-ui-1.10.4.min.js"></script>
	<script src="js/chosen.jquery.min.js"></script>
	<script src="js/jquery.autosize.min.js"></script>
	<script src="js/jquery.placeholder.min.js"></script>
	<script src="js/jquery.bootstrap.wizard.min.js"></script>
	<script src="js/jquery.maskedinput.min.js"></script>
	<script src="js/SmoothScroll.js"></script>
	<script src="js/jquery.mmenu.min.js"></script>
	<script src="js/core.min.js"></script>
	<script src="js/form-wizard.js"></script>
</body></html>