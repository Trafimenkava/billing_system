<?php
	require_once("php/Database.php");
	require_once("php/User.php");
	require_once("php/Notification.php");
	require_once("php/Notifications.php");
	
	session_start();
	$conn = DataBase::getConnection();		
	if (!isset($_SESSION["email"]) && !isset($_COOKIE["email"])) {
		header("location: index.php");
	} else {
		$currentEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : $_COOKIE["email"];
		$currentUser = new User(null, null, $currentEmail);
		$currentUser = $currentUser->getUserByEmail($conn);
	}
	
	$action = $_GET["action"];
	$id = $_GET["id"];
	
	$subject = $_POST["subject"];
	$content = $_POST["content"];
	$to = $_POST["to"];
	$from = $_POST["from"];
	$trigger = $_POST["trigger"];
	
	if ($action == 'add') {
		$notification = new Notification(null, $to, $from, $subject, $content, $trigger);
		$notification = $notification->addNotification($conn);
	} else if ($action == 'delete') {
		$notification = new Notification($id);
		$notification = $notification->deleteNotification($conn);
	} else if ($action == 'edit') {
		$id = $_POST["id"];
		$notification = new Notification($id, $to, $from, $subject, $content, $trigger);
		$notification = $notification->editNotification($conn);
	}
	
	$notifications = new Notifications();
	$notifications = $notifications->getNotifications($conn);
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
	  var id = tr.find(".notification_id").html();
	  var subject = tr.find(".notification_subject").html();
	  var content = tr.find(".notification_content").html();
	  var to_send = tr.find(".notification_to").html();
	  var from_send = tr.find(".notification_from").html();
	  var trigger_type = tr.find(".notification_trigger").html();
	  $('#edit_form_id').val(id);
	  $('#edit_form_subject').val(subject);
	  $('#edit_form_content').val(content);
	  $('#edit_form_to').val(to_send);
	  $('#edit_form_from').val(from_send);
	  $("#edit_form_trigger").val(trigger_type);
      // если окно уже открыто, то закрыть его и сменить надпись кнопки
      if( create_dialog.dialog("isOpen") ) {
         create_dialog.dialog("close");
      } else {
         create_dialog.dialog("open");
      }
   });
   
   // autoOpen : false – означает, что окно проинициализируется но автоматически открыто не будет 
   $("#dialog_window_1").dialog({
      width: "40%",
      height: "auto",
	  position:['middle',30],
      autoOpen : false
   });
 
  $("#dialog_window_2").dialog({
      width: "40%",
      height: "auto",
	  position:['middle',30],
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
				<li class="visible-md visible-lg"><a href="index.html#" id="main-menu-toggle"><i class="fa fa-th-large"></i></a></li>
				<li class="visible-xs visible-sm"><a href="index.html#" id="sidebar-menu"><i class="fa fa-navicon"></i></a></li>			
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
					<h3 class="page-header"><i class="fa fa-columns"></i>Правила создания</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.html">Главная</a></li>
						<li><i class="fa fa-file-text"></i><a href="#">Каталог сообщений</a></li>
						<li><i class="fa fa-columns"></i>Правила создания</li>				
					</ol>
				</div>
			</div>
			<div class="row">
				
				<div class="col-lg-12">
					<div class="panel panel-default">
					
						<div class="panel-body">
							
							<div class="panel-group" id="accordion">
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="ui-elements.html#collapseOne">
							          Использование html-тегов в теле сообщения
							        </a>
							      </h4>
							    </div>
							    <div id="collapseOne" class="panel-collapse collapse">
							      <div class="panel-body">
							        Контент сообщения может содержать html-теги для форматирования текста сообщения. Ниже приведен список основных тегов, которые можно использовать при разметке. Полный список html-тегов можно посмотреть на сайте <a href="https://html5book.ru/html-tags/">HTML-теги</a>.
									<h4>&lt;br&gt;</h4>
									<p>Перенос текста на новую строку</p>
									<h4>&lt;h1&gt;</h4>
									<p>Заголовок первого уровня</p>
									<h4>&lt;h2&gt;</h4>
									<p>Заголовок второго уровня. По аналогии указываются заголовки до шестого уровня включительно</p>
									<h4>&lt;i&gt;</h4>
									<p>Выделяет фрагмент текста курсивом</p>
									<h4>&lt;b&gt;</h4>
									<p>Задает полужирное начертание фрагмента текста</p>
									<h4>&lt;u&gt;</h4>
									<p>Выделяет фрагмент текста подчёркиванием</p>
							      </div>
							    </div>
							  </div>
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="ui-elements.html#collapseTwo">
							          Использование плейсхолдеров в сообщении
							        </a>
							      </h4>
							    </div>
							    <div id="collapseTwo" class="panel-collapse collapse">
							      <div class="panel-body">
							        Тема и контент сообщения могут содержать плейсхолдеры, которые заменяются значениями из контекста при отправке сообщения. В сообщении можно использовать следующие слова-заполнители:
									<h4>$_SURNAME</h4>
									<p>Фамилия пользователя</p>
									<h4>$_NAME</h4>
									<p>Имя пользователя</p>
									<h4>$_LASTNAME</h4>
									<p>Отчество пользователя</p>
									<h4>$_EMAIL</h4>
									<p>Адрес электронной почты пользователя</p>
									<h4>$_PASSWORD</h4>
									<p>Пароль пользователя</p>
									<h4>$_TARIFF_PLAN_TITLE</h4>
									<p>Название тарифного плана</p>
									<h4>$_TELEPHONE_NUMBER</h4>
									<p>Телефонный номер подключенной услуги</p>
							      </div>
							    </div>
							  </div>
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="ui-elements.html#collapseThree">
							          Что такое триггер?
							        </a>
							      </h4>
							    </div>
							    <div id="collapseThree" class="panel-collapse collapse">
							      <div class="panel-body">
							        Триггер - это событие, при котором происходит отправка сообщения. Например, если указать триггер <q>Регистрация</q>, то сообщение будет отправлено при успешном создании нового пользователя.
							      </div>
							    </div>
							  </div>
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="ui-elements.html#collapseFour">
							          Поле <q>От</q> - что указывать?
							        </a>
							      </h4>
							    </div>
							    <div id="collapseFour" class="panel-collapse collapse">
							      <div class="panel-body">
							        В поле <q>От</q> следует указывать Email-адрес: velcom@gmail.com.
							      </div>
							    </div>
							  </div>
							   <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="ui-elements.html#collapseFive">
							          Поле <q>Кому</q> - что указывать?
							        </a>
							      </h4>
							    </div>
							    <div id="collapseFive" class="panel-collapse collapse">
							      <div class="panel-body">
							        Нет необходимости заполнять поле <q>Кому</q> вручную. Система сама определяет, кому следует отослать письмо.
							      </div>
							    </div>
							  </div>
							</div>
							
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