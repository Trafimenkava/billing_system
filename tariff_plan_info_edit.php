<div class="col-sm-9">
						<div class="panel panel-default">
						<div class="panel-heading">
                            <h2><strong>Информация о тарифном плане</strong>
							<a style="text-decoration: none" class="fa fa-times-circle" href="tariff_plan_page.php?id=<?=$id?>"></a></h2>
                        </div>
						<div class="panel-body">
						 <form method="post" action="edit_tariff_plan.php?action=<?=$action?>&id=<?=$tariff_plan->getTariffPlanId()?>" id="tab">
						<div class="form-group">
						<label>Название:</label>
						<input type="text" name="title" value="<?=$tariff_plan->getTariffPlanTitle()?>" class="form-control" required>
						</div>
						<div class="form-group">
						  <label>Описание:</label>
						  <textarea name="description" rows="3" class="form-control"><?=$tariff_plan->getTariffPlanDescription()?></textarea>
						</div>
						<div class="form-group">
						  <label>Группа тарифного плана:</label>
						  <select name="tariff_plan_group_title" class="form-control" required>
								<?php foreach($tariff_plans_groups as $tariff_plans_group): ?>
									<option <? if ($tariff_plan->getTariffPlanGroupTitle() == $tariff_plans_group->getTariffPlanGroupTitle())echo "selected";?>><?=$tariff_plans_group->getTariffPlanGroupTitle()?></option>
								<?php endforeach; ?>
						  </select>
						</div>
						  <div class="form-group">
						  <label>Объем интернет-трафика (МБ):</label>
						<input type="text" name="internet_traffic" value="<?=$tariff_plan->getTariffPlanInternetTrafficMb()?>" class="form-control">
						</div>
						<div class="row">
						<div class="col-sm-6">
						<div class="form-group">
						<label>Количество включенных минут внутри сети:</label>
						<input type="text" name="phone_traffic_within_network" value="<?=$tariff_plan->getTariffPlanPhoneTrafficWithinNetworkMin()?>" class="form-control">
						</div>
						</div>
						<div class="col-sm-6">
						<div class="form-group">
						<label>Количество включенных минут во все сети:</label>
						<input type="text" name="phone_traffic_all_networks" value="<?=$tariff_plan->getTariffPlanPhoneTrafficAllNetworksMin()?>" class="form-control">
						</div>	
						</div>		
						</div>
						<div class="row">
						<div class="col-sm-6">
						<div class="form-group">
						<label>Количество включенных минут в страны СНГ:</label>
						<input type="text" name="international_calls_traffic" value="<?=$tariff_plan->getTariffPlanInternationalCallsTrafficMin()?>" class="form-control">
						</div>
						</div>
						<div class="col-sm-6">
						<div class="form-group">
						<label>Количество любимых номеров:</label>
						<input type="number" name="favorite_numbers" value="<?=$tariff_plan->getTariffPlanFavoriteNumbersAmount()?>" min="0" max="5" class="form-control">
						</div>
						</div>
						</div>
						<div class="row">
						<div class="col-sm-6">
						<div class="form-group">
						<label>Количество включенных SMS внутри сети:</label>
						<input type="text" name="sms_within_network" value="<?=$tariff_plan->getTariffPlanSmsWithinNetwork()?>" class="form-control">
						</div>
						</div>
						<div class="col-sm-6">
						<div class="form-group">
						<label>Количество включенных SMS во все сети:</label>
						<input type="text" name="sms_all_networks" value="<?=$tariff_plan->getTariffPlanSmsAllNetworks()?>" class="form-control">
						</div>
						</div>
						</div>
						<div class="row">
						<div class="col-sm-6">
						<div class="form-group">
						<label>Количество включенных MMS внутри сети:</label>
						<input type="text" name="mms_within_network" value="<?=$tariff_plan->getTariffPlanMmsWithinNetwork()?>" class="form-control">
						</div>
						</div>
						<div class="col-sm-6">
						<div class="form-group">
						<label>Количество включенных MMS во все сети:</label>
						<input type="text" name="mms_all_networks" value="<?=$tariff_plan->getTariffPlanMmsAllNetworks()?>" class="form-control">
						</div>
						</div>
						</div>	
						<div class="form-group">
						  <label>Состояние:</label>
						  <select name="state" class="form-control" required>
								<option <?php if($tariff_plan->getTariffPlanState() == "Действующий") echo "selected";?>>Действующий</option>
								<option <?php if($tariff_plan->getTariffPlanState() == "Архивный") echo "selected";?>>Архивный</option>
						  </select>
						</div>						
						<div class="form-group">
						<label>Абонентская плата (руб/мес):</label>
						<input type="text" name="subscription_fee" value="<?=$tariff_plan->getTariffPlanSubscriptionFee()?>" class="form-control" required>
						</div>
						<div class="btn-toolbar list-toolbar">
						<button class="btn btn-success"><i class="fa fa-save"></i> Сохранить</button>
						<a class="btn btn-danger" id="deletelink" href="tariff_plan_page.php?action=delete&id=<?=$tariff_plan->getTariffPlanId()?>"> Удалить</a>
						</div>							
						</form>
						</div>	
					</div>
				</div>