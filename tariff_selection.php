<?php
	require_once("php/Database.php");
	require_once("php/QueryConsts.php");
	require_once("php/User.php");
	
	session_start();
	$conn = DataBase::getConnection();		
	if (!isset($_SESSION["email"]) && !isset($_COOKIE["email"])) {
		header("location: index.php");
	} else {
		$currentEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : $_COOKIE["email"];
		$currentUser = new User(null, null, $currentEmail);	
		$currentUser  = $currentUser->getUserByEmail($conn);
	}

	$result = $conn->selectRow(QueryConsts::GET_MIN_AND_MAX_SUBSCRIPTION_FEE_QUERY);
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
	<script>
	
	function AjaxFormRequest(ajax_form, url) {
		$('#tab23').html("");
		jQuery.ajax({
			url: url,
			type: "POST",
			dataType: "html",
			data: $("#"+ajax_form).serialize(),
			success: function(response) {
				$('#tab23').html(response);
			},
			error: function(response) {
				$('#tab23').html("Не удалось найти данных.");
			}
		});
	}
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
					<h3 class="page-header"><i class="fa fa-columns"></i>Подобрать тариф</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.html">Главная</a></li>
						<li><i class="fa fa-file-text"></i><a href="#">Тарифные планы</a></li>
						<li><i class="fa fa-columns"></i>Подобрать тариф</li>				
					</ol>
				</div>
			</div>
			
			
			<div class="row">

				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							
							<div id="wizard2" class="wizard-type2">		
							Консультант по выбору тарифа поможет вам выбрать тарифный план, максимально отвечающий вашим потребностям в мобильной связи. Он учитывает такие параметры, как назначение тарифного плана, величина абонентской платы и т. д.
							Воспользоваться консультантом очень просто – достаточно указать нужные параметры, чтобы получить совет по выбору тарифного плана. Он будет тем точнее, чем больше полей вы заполните.<hr>							
								<ul class="steps">
								  	<li><a href="form-wizard.html#tab21" data-toggle="tab"><span class="badge badge-info"><i class="fa fa-star"></i></span> Основные требования</a></li>
									<li><a href="form-wizard.html#tab22" data-toggle="tab"><span class="badge badge-info"><i class="fa fa-credit-card"></i></span> Дополнительные требования</a></li>
									<li><a href="form-wizard.html#tab23" onclick="AjaxFormRequest('ajax_form', 'recommend.php')" data-toggle="tab"><span class="badge badge-info"><i class="fa fa-check"></i></span> Рекомендации</a></li>
								</ul>
								<div class="progress thin">
									<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
									</div>
								</div>	
								<form method="post" id="ajax_form" action="">								
								<div class="tab-content">
								    <div class="tab-pane" id="tab21">
							                <div class="form-group">
							                    <label>Назначение</label>
												<select class="form-control" name="purpose">
													<option value="для звонков">для звонков</option>
													<option value="для доступа в интернет">для доступа в интернет</option>
													<option value="для звонков и доступа в интернет">для звонков и доступа в интернет</option>
												</select>				                    
							                </div>
									  		<div class="form-group">
									    		<label>Минимальная абонплата (BYN)</label>
									    		<input type="text" class="form-control" name="minabonplata" value=<?=$result["min_subscription_fee"]?>>
									  		</div>
											<div class="form-group">
												<label>Максимальная абонплата (BYN)</label>
									    		<input type="text" class="form-control" name="maxabonplata" value=<?=$result["max_subscription_fee"]?>>
									  		</div>
								    </div>
								    <div class="tab-pane" id="tab22">
									
											<div class="form-group">
							                    <label>Объем включенного  трафика</label>
												<select class="form-control" name="traffic">
													<option></option>
													<option value="1-">до 1 Гб включительно</option>
													<option value="1-5">1 - 5 Гб</option>
													<option value="5-10">5 - 10 Гб</option>
													<option value="10+">от 10 Гб и выше</option>
												</select>				                    
							                </div>
								 		<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
											    	<label>Количество любимых номеров</label>
											    	<input type="number" class="form-control" min="0" max="5" name="favoritenumbers">
											  	</div>
												<div>
											    	<input type="checkbox" class="form-check-input" name="internationalcalls">
													<label>Международные звонки</label>
											  	</div>

											</div>

										</div><!--/row-->

								    </div>
									
									<div class="tab-pane" id="tab23"></div>
									<div class="actions">
										<input type="button" class="btn btn-default button-previous" name="prev" value="Prev">
										<input type="button" class="btn btn-success button-next pull-right" name="next" value="Next" onclick="AjaxFormRequest('ajax_form', 'recommend.php')">
									</div>
								</div>
							</form>								
							</div>
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