<?php include 'partials/templates.php'; ?>
<?php ncheader(3, $menu, $weblink);
$details = PageDetails($db_elegantp,39);
$tourPackages = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID='121'",$GROUPBY=null,$ORDERBY="tp.fldTourPackageType ASC",$LIMIT=null); //maldives
?>
<div class="container-fluid bg-theme-color text-light">
    <div class="row bg-maldives-tours center-cover pt-sm-13">
        <div class="col px-3 px-sm-5 pt-23">
            <h1 class="text-light fw-bolder text-uppercase pt-13 pt-xl-23">Maldives</h1>
            <p class="text-light"><?= $details['PageTextNoneHTML'];?></p>
        </div>
    </div>
    <div class="container-xxl">
        <div class="row p-3 p-lg-5 text-dark">
            <h2 class="fw-bold text-center pt-5 pb-3 text-light">Our Resorts</h2>
            <div class="col-sm-6 col-md-8 col-lg-9">
                <div class="owl-carousel owl-theme">
                    <?php $mPtags =ProductTagListByCountry($db_elegantp,$CountryID=121);
                    for($i=0; count($mPtags)>$i; $i++){ ?>
                    <div class="card border border-secondary">
                        <img src="<?= $weblink ?>assets/img/maldives-hotel.jpg" alt="" class="card-img-top hmx-180 center-cover">
                        <div class="card-body bg-theme-color-7">
                            <a href="<?php echo $inside_pages['Resorts Archive'].'/maldives/'.$mPtags[$i]['TagsTitle']; ?>" class="text-decoration-none">
                                <h5 class="card-title text-center text-light"><?= $mPtags[$i]['TagsTitle'] ?></h5>
                            </a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card bg-theme-color text-light border-light" style="height:246px">
                    <div class="card-body flex-center">
                        <a class="text-decoration-none text-light" href="<?php echo $inside_pages['Resorts Archive'].'/maldives/'.$mPtags[$i]['TagsTitle']; ?>">
                            <h5 class="card-title text-center">Explore Resorts...</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row py-sm-5">
        <div class="col bg-maldives-upcoming-tours pt-13 px-3 px-sm-5 pb-3">
            <h3 class="h2 fw-bold pt-5 text-dark">Upcoming Maldives Tours</h3>
            <p class="text-dark pb-3"><?= $details['PageTextNoneHTML'];?></p>
        </div>
    </div>
    <div class="container-xxl">
        <div class="row px-3 pb-3 pt-0 px-lg-5 text-dark">
            <h2 class="fw-bold text-center pt-5 pb-3 text-light">Tour Categories</h2>
            <div class="col-sm-6 col-md-8 col-lg-9">
                <div class="owl-carousel owl-theme">
                    <?php $cats =getActiveTourPackageCategories($db_sqli,$CountryID=121);
                    foreach($cats as $id=>$catNm){ ?>
                    <div class="card border border-secondary h-270">
                        <img src="<?= $weblink ?>assets/img/maldives-hotel.jpg" alt="" class="card-img-top hmx-180 center-cover">
                        <div class="card-body bg-theme-color-7">
                            <a href="<?= $inside_pages['Tour Category'].'/maldives/'.str_replace(' ','-',$catNm) ?>" class="text-decoration-none">
                                <h5 class="card-title text-center text-light"><?= $catNm ?></h5>
                            </a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-270 bg-theme-color text-light border-light">
                    <div class="card-body flex-center">
                        <a class="text-decoration-none text-light" href="<?php echo $menu['Next Trips']; ?>">
                            <h5 class="card-title text-center">Explore Categories...</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row bg-theme-color p-3 p-lg-5 text-dark">
            <?php 
            for($i=0; 3>$i; $i++){ 
                $tpp=TourPackagePhotoEdited($db_elegantp,$tourPackages[$i]['TourPackageID']); ?>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                <div class="card border border-secondary bg-dark h-full text-light">
                    <img src="<?= tiphoto($tpp['TourPackagePhotoFileName'],$size = 'std'); ?>" alt="" class="card-img-top h-270 center-cover">
                    <div class="card-body">
                        <h6 class="card-title text-capitalize"><?= strtolower($tourPackages[$i]['TourPackageTitle']); ?></h6>
                    </div>
                    <div class="card-footer bg-secondary">
                        <span class="ncs-small">From: <span class="fw-bold">US$<?= $tourPackages[$i]['TourPackagePrice'];?></span></span>
                        <a href="<?= $inside_pages['Tour Package'].'/'.$tourPackages[$i]['TourPackageID'] ?>" class="btn btn-outline-warning btn-sm float-end">View Details</a>
                    </div>
                </div>
            </div>
            <?php $tpp= null; } ?>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                <div class="card h-270 h-sm-full h-md-270 h-xl-full bg-theme-color text-light border-light">
                    <div class="card-body flex-center">
                        <a class="text-decoration-none text-light" href="<?php echo $menu['Next Trips']; ?>">
                            <h5 class="card-title">Explore Tours...</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-sm-5">
        <div class="col bg-maldives-attractions center-cover pt-13 px-3 px-sm-5 pb-3">
            <div class="pt-5">
                <h3 class="fw-bold d-block d-sm-inline">Maldives Attractions</h3>
                <a href="<?php echo $inside_pages['Maldives Attractions'];?>" class="btn btn-outline-light float-start float-sm-end">Explore Maldives</a>
            </div>
        </div>
    </div>
</div>
<div class="bg-coffee">
    <div class="container-fluid bg-theme-color-7">
        <div class="container">
            <div class="row text-light px-3 px-md-5 pt-13">
                <h2 class="fw-bold">Good to know before you visit Maldives</h2>
                <p class="text-light"><?php $details = PageDetails($db_elegantp,39);
                echo $details['PageTextNoneHTML'];?></p>            
            </div>
        </div>
        <div class="row py-3">
            <div class="col-12 col-sm-4 px-0">
                <div class="card bg-dark text-light">
                    <img src="<?= $weblink ?>assets/img/pexels-markus-spiske-3970330.jpg" class="card-img h-270" alt="...">
                    <div class="card-img-overlay dark-blend flex-center">
                        <h5 class="card-title fw-bold text-center">Actual pandemic restrictions on unesco</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 px-0">
                <div class="card bg-dark text-light">
                    <img src="<?= $weblink ?>assets/img/pexels-oscar-chan-2833379.jpg" class="card-img h-270" alt="...">
                    <div class="card-img-overlay dark-blend flex-center">
                        <h5 class="card-title fw-bold text-center">Actual pandemic restrictions during flights</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 px-0">
                <div class="card bg-dark text-light">
                    <img src="<?= $weblink ?>assets/img/pexels-kanishka-ranasinghe-2751667.jpg" class="card-img h-270" alt="...">
                    <div class="card-img-overlay dark-blend flex-center">
                        <h5 class="card-title fw-bold text-center">Actual pandemic situation and visa</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-2 py-sm-4">
        <?php $pageIds = [43,44,45,46,47,48,49];
            for($i=0; count($pageIds)>$i; $i++){ ?>
            <div class="row px-2 px-md-5 py-3 text-light">
                <h4 class="text-light fw-bold"><?php $details = PageDetails($db_elegantp,$pageIds[$i]);
                echo $details['PageTitle'];?></h4>
                <?php $para = explode('</li>', $details['PageTextHTML']); 
                    for($p=0; count($para)>$p; $p++){
                       echo '<p>'.strip_tags($para[$p]).'</p>';
                    } ?>
            </div>
            <?php } ?> 
        </div>

    </div>
</div>
<?php ncfooter(3, $menu,$weblink, $footerData); ?>
<script>
$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        items: 4,
        margin:24,
        nav: true,
        loop: true,
        responsive:{
            0: {items: 1, dits: false },
            768: {items: 2,dots: false },
            992: {items: 3,dots: false } 
        }
    });
});
</script>