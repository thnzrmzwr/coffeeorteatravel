<?php include 'partials/templates.php'; 
if(isset($_GET['tourpackageid']) && is_numeric($_GET['tourpackageid'])){
    $id = $_GET['tourpackageid'];
    $details = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldTourPackageID=$id",$GROUPBY=null,$ORDERBY=null,$LIMIT=null);
    //print_r($details);
    $details = $details[0];
    $itenary = $ml = null;
    if('sri lanka'==strtolower($details['TourPackageCountryName'])){
        $itenary = TourPackageDetails($db_elegantp,$id);
    }else{
        $ml =TourPackageDetailsEdited($db_elegantp,$id);
      //  print_r($ml);
    }
    $tpp=TourPackagePhotoEdited($db_elegantp,$id);
}else{
    exit;
}
ncheader(3, $menu, $weblink); ?>
<div class="container-fluid px-0 bg-theme-color position-relative">
    <img class="bgimg" src="<?= tiphoto($tpp['TourPackagePhotoFileName'],$size = 'org');  ?>" alt="">
    <div class="bgimgoverlay-full px-5 flex-center-items theme-gradient-bt">
        <h2 class="text-light px-3 px-sm-5 h1 fw-bold"><?= $details['TourPackageTitle'] ?></h2>
        <h4 class="text-light px-3 px-sm-5"><?php $nights = $details['TourPackageDuration'];
            $days = $nights+1;
            echo "$days Days/ $nights Nights Tour"; ?></h4>
    </div>
    <div class="container bg-theme-color">
        <div class="row text-light border border-secondary rounded">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card bg-theme-color border-0">
                    <div class="card-body d-flex mx-auto">
                        <span class="flex-center me-2" style="font-size: 24px;">
                            <i class="fas fa-clock"></i>
                        </span>
                        <div>
                            <p class="m-0 fw-bold">Duaration</p>
                            <p class="m-0"><?= $days.' Days/ '.$nights.' Nights'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card bg-theme-color border-0">
                    <div class="card-body d-flex mx-auto">
                        <span class="flex-center me-2" style="font-size: 24px;">
                            <i class="fas fa-users"></i>
                        </span>
                        <div>
                            <p class="m-0 fw-bold">Group Size</p>
                            <p class="m-0"><?php echo $gbed[$details['GBeddingPolicyID']] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card bg-theme-color border-0">
                    <div class="card-body d-flex mx-auto">
                        <span class="flex-center me-2" style="font-size: 24px;">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                        <div>
                            <p class="m-0 fw-bold">Price start from:</p>
                            <p class="m-0">US $<?= $details['TourPackagePrice'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card bg-theme-color border-0">
                    <div class="card-body d-flex mx-auto">
                        <span class="flex-center me-2" style="font-size: 24px;">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <div>
                            <p class="m-0 fw-bold">Expire Date</p>
                            <p class="m-0"><?= $details['PackageExpireDate'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-5 py-lg-13 text-light">
            <div class="col-md-12 col-lg-7">
                <h4>Package Desciption</h4>
                <?php
                    if(!empty($ml)){
                        $desc =$ml['TourPackageTextAd'];
                    }else{
                        $desc = $details['TourPackageDescription'];
                    }
                    $list = explode('*',$desc);
                    if(is_array($list) && count($list)>1){
                        echo '<ul class="lh-lg p">';
                        for($i=0; count($list)>$i; $i++){
                            echo ($list[$i]) ? "<li>$list[$i]</li>" :'';
                        }
                        echo "</ul>";
                    }else{
                        echo '<p class="lh-lg">'.$details['TourPackageDescription'].'</p>';
                    }
                ?>
            </div>
            <div class="col-md-12 py-5 py-lg-0 col-lg-5">
                <form class="border border-secondary p-3 rounded" action="">
                    <h4 class="mb-3 text-center">Inquire!</h4>
                    <div class="row mb-2 gx-1">
                        <div class="col">
                            <input type="date" class="form-control" placeholder="Date" aria-label="date">
                        </div>
                        <div class="col">
                            <select class="form-select" aria-label="No of nights">
                                <option selected>No of Nights</option>
                                <option value="1">1 Night</option>
                                <?php for($i=1; $i<30; $i++){ ?>
                                    <option value="<?= $i+1 ?>"><?= $i+1 ?> Nights</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2 gx-1">
                        <div class="col">
                            <select class="form-select" aria-label="adults">
                                <option selected>Adults</option>
                                <?php for($i=0; $i<5; $i++){ ?>
                                    <option value="<?= $i+1 ?>"><?= $i+1 ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-select" aria-label="adults">
                                <option selected>Childs</option>
                                <?php for($i=0; $i<5; $i++){ ?>
                                    <option value="<?= $i+1 ?>"><?= $i+1 ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2 gx-1">
                        <div class="col-3">
                            <select class="form-select" aria-label="adults">
                                <option selected>Title</option>
                                <option value="4" selected="">Dr.</option>
                                <option value="7" selected="">HRH </option>
                                <option value="6" selected="">Master.</option>
                                <option value="2" selected="">Miss.</option>
                                <option value="1" selected="">Mr.</option>
                                <option value="3" selected="">Mrs.</option>
                                <option value="5" selected="">Prof.</option>
                                <option value="" selected="">Title</option>
                            </select>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" placeholder="Name" aria-label="name">
                        </div>
                    </div>
                    <select class="form-select mb-2" aria-label="country">
                        <option selected>Country of residence</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <div class="mb-2">
                        <input type="email" class="form-control" placeholder="Email" aria-label="email">
                    </div>
                    <div class="mb-2">
                        <input type="tel" name="tel" class="form-control" placeholder="Mobile Number" aria-label="mobile">
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-warning">Request For Quotation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $item =$itenary['TourItineraryArray']; ?>
<div class="bg-coffee">
    <div class="container-fluid bg-theme-color-7">
        <div class="container pt-5">
            <?php if(empty($ml)){ ?>
            <div class="row text-light">
                <h3 class="fw-bold"><?= $days.' Days/ '.$nights.' Nights'; ?> Itenary:</h3>           
            </div>
            <div class="row py-4">
                <div class="col-12 ">
                    <div class="accordion" id="ncaccordion">
                        <?php for($i=0; count($item)>$i; $i++){ ?>
                        <div class="accordion-item border border-secondary">
                            <h2 class="accordion-header" id="heading<?= $i+1 ?>">
                                <button class="accordion-button fw-semi" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i+1 ?>" aria-expanded="true" aria-controls="collapse<?= $i+1 ?>">Day <?php echo $item[$i]['TourItineraryDay'].' - '.$item[$i]['TourItineraryDestination']; ?></button>
                            </h2>
                            <div id="collapse<?= $i+1 ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $i+1 ?>" data-bs-parent="#ncaccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12">
                                        <img class="width-full width-sm-unset" src="<?php $tipe = TourItineraryPhotoEdited($db_elegantp, $item[$i]['TourItineraryID']);
                                        if($tipe){
                                            echo tiphoto($tipe[0]['TourItineraryPhotoFileName'],$size = 'thu'); 
                                        } ?>">
                                    </div>
                                    <div class="col-12">
                                        <p class="mt-3"><?= $item[$i]['TourItineraryDescription']; ?></p>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php 
            if('sri lanka'==strtolower($details['TourPackageCountryName'])){
                $countryid = 183;
            }else{
                $countryid = 121;
            }
            $alsoLike = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID=$countryid",$GROUPBY=null,$ORDERBY=null,$LIMIT=null);
            ?>
            <div class="row py-5">
                <h3 class="fw-bold text-light">You might also like:</h3>
                <?php for($i=0; 4>$i; $i++){ $aPhoto=TourPackagePhotoEdited($db_elegantp,$alsoLike[$i]['TourPackageID']);
                    if($alsoLike[$i]['TourPackageTitle']){ ?>
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                        <div class="card bg-dark border border-secondary h-full text-light">
                            <img src="<?= tiphoto($aPhoto['TourPackagePhotoFileName'],$size = 'std'); ?>" alt="" class="card-img-top h-270 center-cover">
                            <div class="card-body">
                                <h6 class="card-title text-capitalize"><?= $alsoLike[$i]['TourPackageTitle']; ?></h6>
                            </div>
                            <div class="card-footer bg-secondary">
                                <span class="ncs-small">From: <span class="fw-bold">US$<?= $alsoLike[$i]['TourPackagePrice'];?></span></span>
                                <a href="<?= $weblink.'tour-package-single.php?tourpackageid='.$alsoLike[$i]['TourPackageID'] ?>" class="btn btn-outline-warning btn-sm float-end">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php $aPhoto=null; } } ?>
            </div>
        </div>
    </div>
</div>
<?php ncfooter(3, $menu, $weblink); ?>