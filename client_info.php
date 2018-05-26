				<div class="col-md-7">	
					<div class="panel panel-default">
						<div class="panel-heading">
                            <h2><strong>Информация о клиенте</strong> 
							<a style="text-decoration: none" class="fa fa-edit" href="page_profile.php?id=<?=$id?>&action=client_info_edit"></a></h2>
                        </div>
						<div class="panel-body">
								
							<ul class="profile-details">
								<li>
									<div><i class="fa fa-lock"></i> Идентификационный номер паспорта</div>
									<?=$client->getClientPassportNumber()?>
								</li>
								<li>
									<div><i class="fa fa-calendar"></i> Дата рождения</div>
									<?=$client->getClientBirthdayDate()?>
								</li>
								<li>
									<div><i class="fa fa-map-marker"></i> Адрес</div>
									<?=$client->getClientAddress()?>
								</li>	
								<li>
									<div><i class="fa fa-credit-card"></i> Номер банковской карты*</div>
									<?=$client->getClientCardNumber()?>
								</li>
								<li>
									<div><i class="fa fa-bars"></i> Статус</div>
									<?=$client->getClientStatus()?>
								</li>
							</ul>	
							<p>*Номер банковской карты вводить необязательно - только если клиент желает использовать услугу Автоматического пополнения баланса (ежемесячное списание денежных средств с привязанной карты в размере, равном суммарной абонентской плате подключенных услуг)</p>
						</div>
						
					</div>
				</div>