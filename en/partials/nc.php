<?php echo 'ready<br>';

include($_SERVER["DOCUMENT_ROOT"]."/config/include.config.php");
include($_SERVER["DOCUMENT_ROOT"]."/config/config.php");
include($_SERVER["DOCUMENT_ROOT"]."/function/web_function.php");

$OfferListCountry = GetDestinationList($db_elegantp);
print_r($OfferListCountry);

echo '<br><br>';

$tourPackagesSL = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID='183'",$GROUPBY=null,$ORDERBY=null,$LIMIT=null); //sri lanka 
print_r($tourPackagesSL[0]);

echo '<br><br>';

for($i=0; count($tourPackagesSL)>$i; $i++){
    $tourPackageNames[] = strtolower($tourPackagesSL[$i]['TourPackageTitle']);
}
array_unique($tourPackageNames);
print_r($tourPackageNames);
echo '<br><br>';

$p=getActiveTourPackageCategories($db_sqli,$CountryID=183);
//print_r(explode(",",$p));
print_r($p);

echo '<br><br>';


?>