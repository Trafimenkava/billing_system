				<div class="col-md-5">
				
                    <div class="panel panel-default">                               
                        <div class="panel-heading">
                            <h2><strong>Общая информация</strong>
							<a style="text-decoration: none" class="fa fa-times-circle" href="page_profile.php?id=<?=$id?>"></a></h2>
                        </div>
                        <div class="panel-body">
                            <form method="post" enctype="multipart/form-data" action="edit_user.php?id=<?=$id?>&action=edit_general_info" class="form-vertical hover-stripped">
                                <div class="form-group">
                                    <label class="control-label">Имя</label>
                                    <input type="text" class="form-control" name="name" value="<?=$client->getUserName()?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Фамилия</label>
                                    <input type="text" class="form-control" name="surname" value="<?=$client->getUserSurname()?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Отчество</label>
                                    <input type="text" class="form-control" name="lastname" value="<?=$client->getUserLastname()?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Дата регистрации</label>
                                    <input type="date" class="form-control" name="registration_date" value="<?=$client->getUserRegistrationDate()?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?=$client->getUserEmail()?>">
                                </div>
								<div class="form-group">
                                    <label class="control-label">Изображение</label>
                                    <input type="file" class="form-control" name="file" id="file">
                                </div>
                                
                                <div class="form-group">
                                <input type="checkbox"  <?php if ($client->getUserRole() == 1) echo "checked";?>  class="form-check-input" name="is_admin">
                                    <label>Администратор</label>
                                </div>
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary">Сохранить</button>
                                </div>
                                        
                            </form>
                        </div>
                    </div>
					
				
				</div><!--/.col-->