<?php
require('tfpdf.php');
require_once("php/Database.php");
require_once("php/QueryConsts.php");
require_once("php/TariffPlan.php");

$conn = DataBase::getConnection();	
$tariff_plan_id = $_GET["id"];
$tariff_plan = new TariffPlan($tariff_plan_id, array());
$tariff_plan = $tariff_plan->getTariffPlanById($conn);

$pdf = new tFPDF();
$pdf->SetMargins(20, 20, 20);

$pdf->AddPage();

$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
$pdf->SetFont('DejaVu', '', 24);
$pdf->SetTextColor(0, 0, 0);

$pdf->Image('B:/home/localhost/www/billing_system/img/logo1.png', 15, 10, 40);
$pdf->Ln(15);

$pdf->Cell(0, 2, $tariff_plan->getTariffPlanTitle(), 0, 0, 'C');
$pdf->Ln(15);

$pdf->SetFont('DejaVu', '', 12);

$data = array(
			array('Группа тарифного плана', $tariff_plan->getTariffPlanTitle()),
			array('Интернет-трафик (Мб)', $tariff_plan->getTariffPlanInternetTrafficMb()),
			array('Исходящие внутри сети (мин)', $tariff_plan->getTariffPlanPhoneTrafficWithinNetworkMin()),
			array('Исходящие во все сети (мин)', $tariff_plan->getTariffPlanPhoneTrafficAllNetworksMin()),
			array('Международные звонки (мин)', $tariff_plan->getTariffPlanInternationalCallsTrafficMin()),
			array('Количество SMS внутри сети', $tariff_plan->getTariffPlanSmsWithinNetwork()),
			array('Количество SMS во все сети', $tariff_plan->getTariffPlanSmsAllNetworks()),
			array('Количество MMS внутри сети', $tariff_plan->getTariffPlanMmsWithinNetwork()),
			array('Количество MMS во все сети', $tariff_plan->getTariffPlanMmsAllNetworks()),
			array('Количество любимых номеров', $tariff_plan->getTariffPlanFavoriteNumbersAmount()),
			array('Состояние', $tariff_plan->getTariffPlanState()),
			array('Абонентская плата (руб/мес)', $tariff_plan->getTariffPlanSubscriptionFee())
		);

foreach($data as $row){
    foreach($row as $col)
		$pdf->Cell(80, 8, $col, 1, 0, 'L'); 
		$pdf->Ln();
}

$pdf->Output();
?>
