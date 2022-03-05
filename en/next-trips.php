<?php include 'partials/templates.php'; 
$countries = GetDestinationList($db_elegantp);
$tourPackages = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID=121 AND tp.fldTourPackageCategoryIDs LIKE '%24%'",$GROUPBY=null,$ORDERBY="tp.fldTourPackageType ASC",$LIMIT=null); //maldives
$tourPackagesSL = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID=183 AND tp.fldTourPackageCategoryIDs LIKE '%24%'",$GROUPBY=null,$ORDERBY=null,$LIMIT=null); //sri lanka
?>
<?php ncheader(4, $menu, $weblink); ?>
<div class="container-fluid text-light bg-theme-color">
    <div class="row bg-next-trips pt-sm-13">
        <div class="col px-3 px-sm-5 pt-23">
            <h1 class="text-light fw-bolder text-uppercase pt-13 pt-xl-23">Next Trips</h1>
            <p class="text-light"><?php $page=PageDetails($db_elegantp,41);
        $para = explode("|", $page['PageTextNoneHTML']);
        echo $para[0];?></p>
        </div>
    </div>
    <div class="container">
        <div class="row bg-theme-color p-3 p-lg-5 text-dark">
            <h3 class="h2 text-center fw-bold pt-5 pb-3 text-light text-capitalize">Upcoming <?= strtolower($countries[1]['CountryName']);//121 ?> Tours</h3>
            <?php if(!empty($tourPackagesSL)){ 
                for($i=0; count($tourPackagesSL)>$i; $i++){ 
                $tpp=TourPackagePhotoEdited($db_elegantp,$tourPackagesSL[$i]['TourPackageID']); ?>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                <div class="card h-full border border-secondary bg-dark text-light">
                    <img src="<?= tiphoto($tpp['TourPackagePhotoFileName'],$size = 'std'); ?>" alt="" class="card-img-top h-270 center-cover">
                    <div class="card-body">
                        <h6 class="card-title text-capitalize"><?= strtolower($tourPackagesSL[$i]['TourPackageTitle']); ?></h6>
                    </div>
                    <div class="card-footer bg-secondary">
                        <span class="ncs-small">From: <span class="fw-bold">US$<?= $tourPackagesSL[$i]['TourPackagePrice'];?></span></span>
                        <a href="<?= $weblink.'tour-package-single.php?tourpackageid='.$tourPackagesSL[$i]['TourPackageID'] ?>" class="btn btn-outline-warning btn-sm float-end">View Details</a>
                    </div>
                </div>
            </div>
            <?php $tpp= null; } }else{ ?>
                <h5 class="py-5 text-center text-secondary">No Upcoming Tours at the moment please check back later...</h5>
            <?php } ?>
        </div>
    </div>
        <div class="row text-center">
            <div class="col-12 col-md-6 bg-maldives-hotels center-cover dark-blend py-5">
                <h3 class="fw-bold">Sri Lanka Tours</h3>
                <a href="<?php echo $inside_pages['Create your own holiday']; ?>" class="btn btn-outline-light">Create Your Own Holiday</a>
            </div>
            <div class="col-12 col-md-6 bg-sl-attractions center-cover dark-blend py-5">
                <h3 class="fw-bold">Sri Lanka Attractions</h3>
                <a href="<?php echo $inside_pages['Sri Lanka Attractions']; ?>" class="btn btn-outline-light">Explore Sri Lanka</a>
            </div>
        </div>
       
    <div class="container">
        <div class="row bg-theme-color p-3 p-lg-5 text-dark">
            <h3 class="h2 text-center fw-bold pt-5 pb-3 text-light text-capitalize">Upcoming <?= strtolower($countries[0]['CountryName']);//183 ?> Tours</h3>
            <?php  if(!empty($tourPackages)){ 
                for($i=0; count($tourPackages)>$i; $i++){ $tpp=TourPackagePhotoEdited($db_elegantp,$tourPackages[$i]['TourPackageID']);?>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                <div class="card h-full border border-secondary bg-dark text-light">
                    <img src="<?= tiphoto($tpp['TourPackagePhotoFileName'],$size = 'std'); ?>" alt="" class="card-img-top h-270 center-cover">
                    <div class="card-body">
                        <h6 class="card-title text-capitalize"><?= $tourPackages[$i]['TourPackageTitle']; ?></h6>
                    </div>
                    <div class="card-footer bg-secondary">
                        <span class="ncs-small">From: <span class="fw-bold">US$<?= $tourPackages[$i]['TourPackagePrice'];?></span></span>
                        <a href="<?= $weblink.'tour-package-single.php?tourpackageid='.$tourPackages[$i]['TourPackageID'] ?>" class="btn btn-outline-warning btn-sm float-end">View Details</a>
                    </div>
                </div>
            </div>
            <?php $tpp=null; } }else{ ?>
                <h5 class="py-5 text-center text-secondary">No Upcoming Tours at the moment please check back later...</h5>
            <?php } ?>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col bg-sl-attractions center-cover pt-13 px-3 px-sm-5 pb-3">
            <h3 class="fw-bold d-block d-sm-inline">Sri Lanka Attractions</h3>
            <a href="#" class="btn btn-outline-light float-start float-sm-end">Explore Sri Lanka</a>
        </div>
    </div> -->
    <div class="row text-center">
        <div class="col-12 col-md-6 bg-maldives-hotels center-cover dark-blend py-5">
            <h3 class="fw-bold">Maldives Resorts</h3>
            <a href="<?php echo $inside_pages['Maldives Resorts']; ?>" class="btn btn-outline-light">Explore Resorts</a>
        </div>
        <div class="col-12 col-md-6 bg-maldives-attractions center-cover dark-blend py-5">
            <h3 class="fw-bold">Maldives Attractions</h3>
            <a href="<?php echo $inside_pages['Maldives Attractions']; ?>" class="btn btn-outline-light">Explore Maldives</a>
        </div>
    </div>
</div>
<?php ncfooter(4, $menu,$weblink, $footerData); ?>