<?php
	require_once("php/Database.php");
	require_once("php/QueryConsts.php");
	require_once("php/User.php");
	require_once("php/Users.php");
	require_once("php/Client.php");
	require_once("php/Clients.php");
	
	session_start();	
	$conn = DataBase::getConnection();
	if (!isset($_SESSION["email"]) && !isset($_COOKIE["email"])) {
		header("location: index.php");
	} else {
		$currentEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : $_COOKIE["email"];
		$currentUser = new User(null, null, $currentEmail);	
		$currentUser  = $currentUser->getUserByEmail($conn);
	}

	$action = $_GET["action"];
	$page = $_GET["page"];
	$id = $_GET["id"];
	$searchField = trim($_GET["searchField"]);
	$clients = array();
	
	if ($action == "delete") {
		if (isset($id)) {
			$user = new Client($id, null, null);
			$user->deleteUser($conn);
			$user->deleteClient($conn);
			header("location: users.php");
		}
	} else if (!empty($searchField)) {
		$user = new Client(null, $searchField, null);
		$selectedClient = $user->getClientByFio($conn);
		if ($selectedClient != null) {
			array_push($clients, $selectedClient);
		}
	} else if (empty($action)) {
		if ($page == null || $page <= 0) {
			$page = 1;
		} 
	
		$users = new Clients();
		$rowsAmount = $users->getAmountOfUsers($conn);
		$pageAmount = ceil($rowsAmount / 10);
		if ($page > $pageAmount) {
			$page = $pageAmount;
		} 
		$offset = ($page - 1) * 10;	
		$clients = $users->getClients($conn, array($offset)); 
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
		<script>
		$(document).ready(function(){
		$("#deletelink").on("click", function(e) {
			var link = this;
			e.preventDefault();
			$("<div>Вы уверены, что хотите удалить данную запись?</div>").dialog({
				buttons: {
					"Да": function() {
						window.location = link.href;
					},
					"Нет": function() {
						$(this).dialog("close");
					}
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
			
			<form class="navbar-form navbar-left" action="" method="get">
				<button type="submit" class="fa fa-search"></button>
				<input type="text" class="form-control" name="searchField" placeholder="Поиск..."></a>
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
					<h3 class="page-header"><i class="fa fa-columns"></i>Абоненты</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.html">Главная</a></li>
						<li><i class="fa fa-file-text"></i><a href="#">Пользователи</a></li>
						<li><i class="fa fa-columns"></i>Абоненты</li>				
					</ol>
				</div>
			</div>
		
			<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-content">
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th>ФИО</th>
        <th>Дата регистрации</th>
        <th>Email</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
	<?php if ($clients) foreach($clients as $client): ?>
	<tr>
        <td><?php echo $client->getUserSurname() . " " . $client->getUserName() . " " . $client->getUserLastname(); ?></td>
        <td class="center"><?=$client->getUserRegistrationDate()?></td>
        <td class="center"><?=$client->getUserEmail()?></td>
        <td class="center">
            <span <?php if($client->getClientStatus() == "Активный") echo "class = 'label label-default label-success'"; else if ($client->getClientStatus() == "Заблокированный") echo "class = 'label label-default label-danger'"; else echo "class = 'label label-default'";?>><?=$client->getClientStatus()?></span>
        </td>
        <td class="center">
            <a class="btn btn-success" href="page_profile.php?id=<?=$client->getUserId()?>">
                <i class="fa fa-info"></i>
                Подробнее
            </a>
            <a class="btn btn-danger" id="deletelink" href="users.php?action=delete&id=<?=$client->getUserId()?>">
                <i class="fa fa-trash-o"></i>
                Удалить
            </a>
        </td>
    </tr>
	<?php endforeach; ?>
    </tbody>
    </table>
	<ul class="pagination">
		<?php if (empty($searchField)) {?>
		<li><a href="users.php?page=<?=($page-1)?>">Prev</a></li>
		<?php 
			for ($i = 1; $i <= $pageAmount; $i++) { 
				$li = "<li>";
				if ($i == $page) $li = "<li class='active'>";
				echo "$li<a href='users.php?page=$i'>$i</a></li>";
			}
		?>
		<li><a href="users.php?page=<?=($page+1)?>">Next</a></li>
		<? } ?>
		<?php if (!empty($searchField)) { ?>
		<a href="users.php">Все абоненты</a>
		<? } ?>
	</ul> 
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->		
			
		</div>
		<!-- end: Content -->
		<br><br><br>		
		
		
	</div><!--/container-->
		
	
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Modal title</h4>
				</div>
				<div class="modal-body">
					<p>Here settings can be configured...</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
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
	
	<!-- theme scripts -->
	<script src="js/SmoothScroll.js"></script>
	<script src="js/jquery.mmenu.min.js"></script>
	<script src="js/core.min.js"></script>
	
	<!-- inline scripts related to this page -->
	
	<!-- end: JavaScript-->
	
</body>
</html>