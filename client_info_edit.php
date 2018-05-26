				<div class="col-md-7">
					
					<div class="panel panel-default">                               
                        <div class="panel-heading">
                            <h2><strong>Информация о клиенте</strong>
							<a style="text-decoration: none" class="fa fa-times-circle" href="page_profile.php?id=<?=$id?>"></a></h2>
                        </div>
                        <div class="panel-body">
                            <form method="post" enctype="multipart/form-data" action="edit_user.php?id=<?=$id?>&action=edit_client_info" class="form-vertical hover-stripped">
                                <div class="form-group">
                                    <label class="control-label">Идентификационный номер паспорта</label>
                                    <input type="text" class="form-control" name="passport_number" value="<?=$client->getClientPassportNumber()?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Дата рождения</label>
                                    <input type="date" class="form-control" name="birthday_date" value="<?=$client->getClientBirthdayDate()?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Адрес</label>
                                    <textarea class="form-control" name="address"><?=$client->getClientAddress()?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Номер банковской карты</label>
                                    <input type="text" class="form-control" name="card_number" value="<?=$client->getClientCardNumber()?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Статус</label>
                                    <input type="text" class="form-control" name="status" value="<?=$client->getClientStatus()?>" disabled>
                                </div>
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary">Сохранить</button>
                                </div>
                                        
                            </form>
                        </div>
                    </div>
				
				</div><!--/.col-->