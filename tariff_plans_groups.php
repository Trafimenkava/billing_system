<?php
	require_once("php/Database.php");
	require_once("php/User.php");
	require_once("php/TariffPlans.php");
	require_once("php/TariffPlanGroup.php");
	require_once("php/TariffPlanGroups.php");
	
	session_start();
	$conn = DataBase::getConnection();		
	if (!isset($_SESSION["email"]) && !isset($_COOKIE["email"])) {
		header("location: index.php");
	} else {
		$currentEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : $_COOKIE["email"];
		$currentUser = new User(null, null, $currentEmail);	
		$currentUser  = $currentUser->getUserByEmail($conn);
	}
	
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	$id = isset($_GET['id']) ? $_GET['id'] : '';
	$title = isset($_POST['title']) ? $_POST['title'] : ''; 
	$description = isset($_POST['description']) ? $_POST['description'] : '';
	
	if ($action == 'add') {
		$tariff_plan_group = new TariffPlanGroup(null, $title, $description);
		$tariff_plan_group = $tariff_plan_group->addTariffPlanGroup($conn);
	} else if ($action == 'delete') {
		$tariff_plan_group = new TariffPlanGroup($id, null, null);
		$tariff_plan_group = $tariff_plan_group->deleteTariffPlanGroup($conn);
	} else if ($action == 'edit') {
		$id = $_POST["id"];
		$tariff_plan_group = new TariffPlanGroup($id, $title, $description);
		$tariff_plan_group = $tariff_plan_group->editTariffPlanGroup($conn);
	}
	
	$tariff_plans_groups = new TariffPlanGroups();
	$tariff_plans_groups = $tariff_plans_groups->getTariffPlanGroups($conn);
	
?>
<!DOCTYPE html>
<html>
	<head>
    	<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="T-Great - Admin Template">
		<meta name="author" content="Creative Template">
		<meta name="keyword" content="T-Great, Admin, Admin Template, Dashboard, Bootstrap, Twitter Boostrap, Template, Theme, Responsive, Jquery, Administration, Administration Template, Administration Theme, Fluid, Retina">
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
   $("#create_button").button().click(function() {
      var create_dialog = $("#dialog_window_1");
      var create_button = $(this);
 
      // если окно уже открыто, то закрыть его и сменить надпись кнопки
      if( create_dialog.dialog("isOpen") ) {
         create_dialog.dialog("close");
      } else {
         create_dialog.dialog("open");
      }
   });
 
	$(".edit_button").click(function() {
      var create_dialog = $("#dialog_window_2");
      var edit_button = $(this);
	  var tr = edit_button.parent().parent();
	  var id = tr.find(".tariff_plan_group_id").html();
	  var title = tr.find(".tariff_plan_group_title").html();
	  var description = tr.find(".tariff_plan_group_description").html();
	  $('#edit_form_id').val(id);
	  $('#edit_form_title').val(title);
	  $('#edit_form_description').val(description);
      // если окно уже открыто, то закрыть его и сменить надпись кнопки
      if(create_dialog.dialog("isOpen")) {
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
 
  $("#dialog_window_2").dialog({
      width: "30%",
      height: "auto",
	  position:['middle',100],
      autoOpen : false
   });
});
	
		</script>	
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
					<h3 class="page-header"><i class="fa fa-columns"></i>Группы тарифных планов</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.html">Главная</a></li>
						<li><i class="fa fa-columns"></i>Группы тарифных планов</li>				
					</ol>
				</div>
			</div>
			<div class="row">
			
				<div class="col-lg-12">                           
                    <div class="panel panel-default">  
                                <div id="dialog_window_1" class="dialog_window" title="Создание группы тарифных планов">
								<form method="post" action="tariff_plans_groups.php?action=add">
                                <div class="form-group">
                                    <label class="control-label">Название</label>
                                    <input type="text" class="form-control" name="title" id="title">
                                </div>
								<div class="form-group">
                                    <label class="control-label">Описание</label>
                                    <textarea class="form-control" name="description" id="description" rows="7"></textarea>
                                </div>
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary">Добавить</button>
                                </div>
                                </form>
								</div>
								<div id="dialog_window_2" class="dialog_window" title="Редактирование группы тарифных планов">
								<form method="post" action="tariff_plans_groups.php?action=edit">
                                <div class="form-group" style="display: none">
                                    <label class="control-label">Идентификатор</label>
                                    <input type="text" class="form-control" name="id" id="edit_form_id">
                                </div>
								<div class="form-group">
                                    <label class="control-label">Название</label>
                                    <input type="text" class="form-control" name="title" id="edit_form_title">
                                </div>
								<div class="form-group">
                                    <label class="control-label">Описание</label>
                                    <textarea class="form-control" name="description" id="edit_form_description" rows="7"></textarea>
                                </div>
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary">Сохранить</button>
                                </div>
                                </form>
								</div>
                        <div class="panel-body">
						<button type="button" class="btn btn-primary" id="create_button">Добавить группу</button>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>Название</th>
                                        <th>Описание</th>
                                        <th>Включает ТП</th>
										<th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($tariff_plans_groups as $tariff_plans_group): ?>
                                    <tr>
                                        <td class="tariff_plan_group_id"><?=$tariff_plans_group->getTariffPlanGroupId()?></td>
                                        <td class="tariff_plan_group_title"><?=$tariff_plans_group->getTariffPlanGroupTitle()?></td>
                                        <td class="tariff_plan_group_description"><?=$tariff_plans_group->getTariffPlanGroupDescription()?></td>
										<?php
											$tariff_plans = new TariffPlans();
											$tariff_plans = $tariff_plans->getTariffPlansByTariffPlanGroupId($conn, $tariff_plans_group->getTariffPlanGroupId());
										?>
                                        <td style="min-width: 180px">
										<?php foreach($tariff_plans as $tariff_plan): ?>
											<a href=""><?=$tariff_plan->getTariffPlanTitle()?></a><br>
										<?php endforeach; ?>
										</td>
										<td>
										<a class="btn btn-danger" id="deletelink" href="tariff_plans_groups.php?action=delete&id=<?=$tariff_plans_group->getTariffPlanGroupId()?>">
										<i class="fa fa-trash-o"></i></a>
										<button type="button" class="btn btn-info edit_button">
										<i class="fa fa-pencil-square"></i></button>
										</td>
                                    </tr>
									<?php endforeach; ?>
								
                                </tbody>
                            </table>
                        </div>
                    </div>                 
				</div><!--/col-->
			
			</div><!--/row-->
		</div>
		<!-- end: Content -->
		
		
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
	<script src="js/chosen.jquery.min.js"></script>
	<script src="js/jquery.autosize.min.js"></script>
	<script src="js/jquery.placeholder.min.js"></script>
	<script src="js/jquery.bootstrap.wizard.min.js"></script>
	<script src="js/jquery.maskedinput.min.js"></script>
	
	<!-- theme scripts -->
	<script src="js/SmoothScroll.js"></script>
	<script src="js/jquery.mmenu.min.js"></script>
	<script src="js/core.min.js"></script>
	
	<!-- inline scripts related to this page -->
	<script src="js/form-wizard.js"></script>
	
	<!-- end: JavaScript-->
	
</body>
</html>