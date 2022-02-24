<?php include 'partials/templates.php'; ?>
<?php ncheader(3, $menu, $weblink); 
$details = PageDetails($db_elegantp,40);
$tourPackagesSL = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID='183'",$GROUPBY=null,$ORDERBY=null,$LIMIT=null); //sri lanka
for($i=0; count($tourPackagesSL)>$i; $i++){
    $tourPackage['Names'][] = strtolower($tourPackagesSL[$i]['TourPackageTitle']);
    $tourPackage['Id'][] = $tourPackagesSL[$i]['TourPackageID'];
}
array_unique($tourPackage['Names']);
?>

<div class="container-fluid bg-theme-color text-light">
    <div class="row bg-cyoh center-cover pt-sm-13">
        <div class="col px-3 px-sm-5 pt-23">
            <h1 class="text-light fw-bolder text-uppercase pt-13 pt-xl-23">create your own holiday on sri lanka</h1>
            <p class="text-light"><?= $details['PageTextNoneHTML'];?></p>
        </div>
    </div>
    <div class="container">
        <?php for($a=0; count($tourPackage['Names'])>$a; $a++){ 
            if($tourPackage['Names'][$a] !== 'upcoming tour'){ ?> 
        <div class="row bg-theme-color p-3 p-lg-5 text-dark">
            <h3 class="h2 text-center text-md-start fw-bold pt-5 pb-3 text-light text-capitalize"><?= $tourPackage['Names'][$a]; ?></h3>
            <?php for($i=0; count($tourPackagesSL)>$i; $i++){
                if( strtolower($tourPackagesSL[$i]['TourPackageTitle']) == $tourPackage['Names'][$a]){
                    $tpp=TourPackagePhotoEdited($db_elegantp,$tourPackagesSL[$i]['TourPackageID']); ?>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                <div class="card">
                    <img src="<?= tiphoto($tpp['TourPackagePhotoFileName'],$size = 'std'); ?>" alt="" class="card-img-top h-270 center-cover">
                    <div class="card-body">
                        <h6 class="card-title text-capitalize"><?= strtolower($tourPackagesSL[$i]['TourPackageTitle']); ?></h6>
                        <p class="text-ncs-coffee-light card-text ncs-small fw-semi"><span class="float-start text-capitalize"><?= strtolower($tourPackagesSL[$i]['TourPackageCountryName']);?></span><span class="float-end">
                        <?php $days=$tourPackagesSL[$i]['TourPackageDuration'];
                            echo $days; echo' Nights/'; echo $days+1;?> Days</span><br><span class="d-block text-end mt-2">Expire On:<i class="fas fa-calendar-alt ms-2"></i><span class="ms-2"><?= $tourPackagesSL[$i]['PackageExpireDate'] ?></span></p>
                    </div>
                    <div class="card-footer">
                        <span class="ncs-small">From: <span class="fw-bold">US$<?= $tourPackagesSL[$i]['TourPackagePrice'];?></span></span>
                        <a href="#" class="btn btn-outline-dark btn-sm float-end">View Details</a>
                    </div>
                </div>
            </div>
            <?php } } ?>
        </div>
        <?php } } ?>
        <!-- <div class="row bg-theme-color p-3 p-lg-5 text-dark">
            <h3 class="h2 text-center text-md-start fw-bold pt-5 pb-3 text-light">Sri Lanka round Tours</h3>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                <div class="card">
                    <img src="assets/img/pexels-lyn-hoare-5042817.jpg" alt="" class="card-img-top h-270 center-cover">
                    <div class="card-body">
                        <h5 class="card-title">Lorem Ipsum Tour</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="card-footer">
                        <i class="fas fa-calendar-alt"></i><span class="ms-2">2022-01-25</span>
                        <a href="#" class="btn btn-outline-dark btn-sm float-end">Inquire</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                <div class="card">
                    <img src="assets/img/elephants-sl.jpg" alt="" class="card-img-top h-270 center-cover">
                    <div class="card-body">
                        <h5 class="card-title">Lorem Ipsum Tour</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="card-footer">
                        <i class="fas fa-calendar-alt"></i><span class="ms-2">2022-01-25</span>
                        <a href="#" class="btn btn-outline-dark btn-sm float-end">Inquire</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                <div class="card">
                    <img src="assets/img/buddha-sl.jpg" alt="" class="card-img-top h-270 center-cover">
                    <div class="card-body">
                        <h5 class="card-title">Lorem Ipsum Tour</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="card-footer">
                        <i class="fas fa-calendar-alt"></i><span class="ms-2">2022-01-25</span>
                        <a href="#" class="btn btn-outline-dark btn-sm float-end">Inquire</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                <div class="card">
                    <img src="assets/img/lotus-tower-sl.jpg" alt="" class="card-img-top h-270 center-cover">
                    <div class="card-body">
                        <h5 class="card-title">Lorem Ipsum Tour</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="card-footer">
                        <i class="fas fa-calendar-alt"></i><span class="ms-2">2022-01-25</span>
                        <a href="#" class="btn btn-outline-dark btn-sm float-end">Inquire</a>
                    </div>
                </div>
            </div>

        </div> -->
        <div class="row bg-theme-color p-3 p-lg-5 text-dark">
            <h3 class="h2 text-center fw-bold pt-5 pb-3 text-light">Create your own holiday</h3>
        </div>

    </div>
</div>

<?php ncfooter(3, $menu, $weblink); ?>