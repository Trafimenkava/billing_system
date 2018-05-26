				<div class="col-md-5">
					
					<div class="panel panel-default">
						<div class="panel-heading">
                            <h2><strong>Общая информация</strong> 
							<a style="text-decoration: none" class="fa fa-edit" href="page_profile.php?id=<?=$id?>&action=general_info_edit"></a></h2>
                        </div>
						<div class="panel-body">
				
							<div class="text-center">
								<img class="img-profile" src="img/<?=$client->getUserImage()?>">
							</div>
							<h3 class="text-center"><strong>
							<? echo $client->getUserSurname() . " " . $client->getUserName() . " " . $client->getUserLastname();?>
							</strong></h3>
							<hr>
							
							<h4><strong>Персональная информация</strong></h4>
							
							<ul class="profile-details">
								<li>
									<div><i class="fa fa fa-user"></i> Имя</div>
									<?=$client->getUserName()?>
								</li>
								<li>
									<div><i class="fa fa fa-user"></i> Фамилия</div>
									<?=$client->getUserSurname()?>
								</li>
								<li>
									<div><i class="fa fa fa-user"></i> Отчество</div>
									<?=$client->getUserLastname()?>
								</li>	
								<li>
									<div><i class="fa fa-calendar"></i> Дата регистрации</div>
									<?=$client->getUserRegistrationDate()?>
								</li>
								<li>
									<div><i class="fa fa-star-o"></i> Роль</div>
									<?=$client->getUserRoleName()?>
								</li>
							</ul>
							<hr>		

							<h4><strong>Контактная информация</strong></h4>

							<ul class="profile-details">
								<li>
									<div><i class="fa fa-envelope"></i> E-mail</div>
									<?=$client->getUserEmail()?>
								</li>
							</ul>	
						</div>
						
					</div>
				
				</div><!--/.col-->