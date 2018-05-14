				<div class="col-sm-9">
					
					<div class="panel panel-default">
						<div class="panel-heading">
                            <h2><strong>Информация о тарифном плане</strong> 
							<a style="text-decoration: none" class="fa fa-edit" href="tariff_plan_page.php?id=<?=$id?>&action=edit"></a></h2>
                        </div>
						<div class="panel-body">
				
							<ul class="tariff-plan-details">
								<li>
									<div class="li_title"><i class="fa fa-star"></i> Название</div>
									<?=$tariff_plan->getTariffPlanTitle()?>
								</li>
								<li>
									<div class="li_title"><i class="fa fa-ellipsis-h"></i> Описание</div>
									<?=$tariff_plan->getTariffPlanDescription()?>
								</li>
								<li>
									<div class="li_title"><i class="fa fa-columns"></i> Группа тарифного плана</div>
									<?=$tariff_plan->getTariffPlanGroupTitle()?>
								</li>
								<li>
									<div class="li_title"><i class="fa fa-laptop"></i> Объем интернет-трафика (МБ)</div>
									<?=$tariff_plan->getTariffPlanInternetTrafficMb()?>
								</li>
								<li>
									<div class="row"> 
									<div class="col-sm-6">
									<div class="li_title"> Количество включенных минут внутри сети</div>
									<?=$tariff_plan->getTariffPlanPhoneTrafficWithinNetworkMin()?></div>
									<div class="col-sm-6">
									<div class="li_title"> Количество включенных минут во все сети</div>
									<?=$tariff_plan->getTariffPlanPhoneTrafficAllNetworksMin()?></div>
									</div>
								</li>
								<li>
									<div class="row"> 
									<div class="col-sm-6">
									<div class="li_title"> Количество включенных минут в страны СНГ</div>
									<?=$tariff_plan->getTariffPlanInternationalCallsTrafficMin()?></div>
									<div class="col-sm-6">
									<div class="li_title"> Количество любимых номеров</div>
									<?=$tariff_plan->getTariffPlanFavoriteNumbersAmount()?></div>
									</div>
								</li>
								<li>
									<div class="row"> 
									<div class="col-sm-6">
									<div class="li_title"> Количество включенных SMS внутри сети</div>
									<?=$tariff_plan->getTariffPlanSmsWithinNetwork()?></div>
									<div class="col-sm-6">
									<div class="li_title"> Количество включенных SMS во все сети</div>
									<?=$tariff_plan->getTariffPlanSmsAllNetworks()?></div>
									</div>
								</li>
								<li>
									<div class="row"> 
									<div class="col-sm-6">
									<div class="li_title"> Количество включенных MMS внутри сети</div>
									<?=$tariff_plan->getTariffPlanMmsWithinNetwork()?></div>
									<div class="col-sm-6">
									<div class="li_title"> Количество включенных MMS во все сети</div>
									<?=$tariff_plan->getTariffPlanMmsAllNetworks()?></div>
									</div>
								</li>
								<li>
									<div class="li_title"><i class="fa fa-lock"></i> Состояние</div>
									<?=$tariff_plan->getTariffPlanState()?>
								</li>
								<li>
									<div class="li_title"><i class="fa fa-dollar"></i> Абонентская плата (руб/мес)</div>
									<?=$tariff_plan->getTariffPlanSubscriptionFee()?>
								</li>
							</ul>
							
							<img src="img/pdf.png"><a href="report.php?id=<?=$id?>">Загрузить полную версию в формате PDF</a>
						</div>
						
					</div>
				
				</div><!--/.col-->