<?php include 'partials/templates.php'; ?>
<?php ncheader(0, $menu, $weblink); 
$paged = PageDetails($db_elegantp,1);
$para = explode("</p>", $paged['PageTextHTML']); ?>
<div class="container-fluid bg-coffee">
    <div class="row bg-theme-color-7" style="align-items:center;">
        <div class="col-xxl-3 text-center text-xxl-start text-light px-3 px-sm-5 px-xxl-3 py-5 py-xxl-2 order-2 order-xxl-1">
            <span>Choose your dream destination</span>
            <h2 class="mt-1 lh-base fw-bold h4">Pick your tailor-made holiday or beach stay and our travel experts will take care of every tiny detail for you. You can just order a cup of coffee or tea and enjoy the mystic and majestic experience the little exotic island will cast on you.</h2>
            <a href="https://www.coffeeorteatravel.com/en/contact-us.php" class="btn btn-outline-light mt-3">Explore</a>
        </div>
        <div class="col-12 col-xxl-9 px-0 order-1 order-xxl-2" style="height:80vh;">
            <iframe src="<?php echo $weblink; ?>slider.php" frameborder="0" width="100%" height="100%" class="iframe_slider px-0"></iframe>
        </div>
    </div>
    <div class="row pt-5 bg-theme-color-6 text-ncs-light ps-xl-5 ps-lg-0" id="about-us">
        <div class="col-lg-7 col-md-12 pe-md-2 ps-3 pe-1 px-sm-5 pt-4">
            <p class="h3 fw-bold text-uppercase text-light text-center text-sm-start">About Us...</p>
            <p class="text-center text-sm-start"><?= $paged['PageSEODescription']; ?></p>
            <div class="row py-3">
                <div class="col-1">
                    <p><hr class="text-light h-2"></p>
                </div>
                <div class="col-10">
                    <p class="lh-base"><?= $para[0]; ?></p>
                </div>
            </div>
            <div class="row py-3">
                <div class="col-1">
                    <p><hr class="text-light h-2"></p>
                </div>
                <div class="col-10">
                    <p class="lh-base"><?= $para[1]; ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 pt-4 bg-sigiriya-arial py-5">
            <div class="py-5 my-5"></div>
        </div>
    </div>
    <div class="row pt-5 bg-theme-color-6 text-ncs-light pb-md-4">
        <div class="col-lg-5 col-md-12 pt-4 bg-elephant-group-bath py-5 d-none d-lg-block">
            <div class="py-5 my-5"></div>
        </div>
        <div class="col-lg-7 col-md-12 pe-1 px-md-5 ps-3 pt-4">
            <div class="row py-3">
                <div class="col-1">
                    <p><hr class="text-light h-2"></p>
                </div>
                <div class="col-10">
                    <p class="lh-base"><?= $para[2]; ?></p>
                </div>
            </div>
            <div class="row py-3">
                <div class="col-1">
                    <p><hr class="text-light h-2"></p>
                </div>
                <div class="col-10">
                    <p class="lh-base"><?= $para[3]; ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 pt-4 bg-elephant-group-bath py-5 d-lg-none">
            <div class="py-5 my-5"></div>
        </div>
    </div>
    <div class="row py-5 bg-theme-color-7 px-md-5 px-sm-1">
        <div class="row"><div id="google-reviews"></div></div>
        <div class="row mx-auto mb-lg-5">
            <h3 class="h2 text-light py-3 fw-bolder text-uppercase text-center">What our clients say</h3>
            <div class="elfsight-app-03ff99b3-691d-4b3e-b28f-3a92d7e52a3f"></div>
            <!-- <div class="col-md-6 col-lg-4 pb-2 mt-2 px-2">
                <div class="card float-end p-lg-0 p-xl-3" style="width: 100%;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto col-md-2">
                                <img src="assets/img/next-trips.jpg" alt="" width="50px" height="50px">
                            </div>
                            <div class="col-auto col-sm-10 ps-sm-0 ps-md-4">
                                <h6 class="card-title fw-bold">Hilda Ross</h6>
                                <p class="card-subtitle p mb-2 text-muted">East Karianneside</p>
                            </div>
                        </div>
                        <hr class="text-ncs-light">
                        <div class="rating ">
                            <img src="assets/img/star-5.svg" class="pb-1" alt="5 star rating"><span class="ms-2">(5.0)</span>
                        </div>
                        
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni quos ullam odit molestias voluptatem autem.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 pb-2 mt-2 px-2 px-2">
                <div class="card px-auto p-lg-0 p-xl-3" style="width: 100%;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto col-md-2">
                                <img src="assets/img/next-trips.jpg" alt="" width="50px" height="50px">
                            </div>
                            <div class="col-auto col-sm-10 ps-sm-0 ps-md-4">
                                <h6 class="card-title fw-bold">Hilda Ross</h6>
                                <p class="card-subtitle p mb-2 text-muted">East Karianneside</p>
                            </div>
                        </div>
                        <hr class="text-ncs-light">
                        <div class="rating ">
                            <img src="assets/img/star-5.svg" class="pb-1" alt="5 star rating"><span class="ms-2">(5.0)</span>
                        </div>
                        
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni quos ullam odit molestias voluptatem autem.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 pb-2 mt-2 px-2">
            <div class="card float-start p-lg-0 p-xl-3" style="width: 100%;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto col-md-2">
                                <img src="assets/img/next-trips.jpg" alt="" width="50px" height="50px">
                            </div>
                            <div class="col-auto col-sm-10 ps-sm-0 ps-md-4">
                                <h6 class="card-title fw-bold">Hilda Ross</h6>
                                <p class="card-subtitle p mb-2 text-muted">East Karianneside</p>
                            </div>
                        </div>
                        <hr class="text-ncs-light">
                        <div class="rating ">
                            <img src="assets/img/star-5.svg" class="pb-1" alt="5 star rating"><span class="ms-2">(5.0)</span>
                        </div>
                        
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni quos ullam odit molestias voluptatem autem.</p>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <div class="row bg-theme-color-7 py-5">
        <div class="col-12 px-0">
            <h3 class="h2 text-light fw-bolder text-uppercase text-center text-sm-start px-sm-5 pb-2">Upcoming Tours</h3>
            <div class="owl-carousel owl-theme">
                <?php
                     $tourPackagesSL = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID='183'",$GROUPBY=null,$ORDERBY=null,$LIMIT=null); //sri lanka
                     for($i=0; count($tourPackagesSL)>$i; $i++){ 
                         $tpp=TourPackagePhotoEdited($db_elegantp,$tourPackagesSL[$i]['TourPackageID']); ?>
                 <div class="card bg-dark text-white mx-2 position-relative">
                     <img src="<?= tiphoto($tpp['TourPackagePhotoFileName'],$size = 'std'); ?>" class="card-img objfit-500" alt="...">
                     <div class="card-img-overlay b-tb-gradient">
                         <h5 class="card-title text-capitalize"><?= strtolower($tourPackagesSL[$i]['TourPackageTitle']); ?></h5>
                         <div class="card-footer">
                         <span class="ncs-small nc-block">From: <span class="fw-bold">US$<?= $tourPackagesSL[$i]['TourPackagePrice'];?></span></span>
                         <a href="<?= $weblink.'tour-package-single.php?tourpackageid='.$tourPackagesSL[$i]['TourPackageID'] ?>" class="btn btn-outline-light btn-sm float-end nc-block">View Details</a>
                         </div>
                     </div>
                 </div>
                 <?php } 
                    $tourPackages = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID='121'",$GROUPBY=null,$ORDERBY="tp.fldTourPackageType ASC",$LIMIT=null); //maldives
                    for($i=0; count($tourPackages)>$i; $i++){ 
                        $tpp=TourPackagePhotoEdited($db_elegantp,$tourPackages[$i]['TourPackageID']); ?>
                <div class="card bg-dark text-white mx-2 position-relative">
                    <img src="<?= tiphoto($tpp['TourPackagePhotoFileName'],$size = 'std'); ?>" class="card-img objfit-500" alt="...">
                    <div class="card-img-overlay b-tb-gradient">
                        <h5 class="card-title text-capitalize"><?= strtolower($tourPackages[$i]['TourPackageTitle']); ?></h5>
                        <div class="card-footer">
                        <span class="ncs-small nc-block">From: <span class="fw-bold">US$<?= $tourPackages[$i]['TourPackagePrice'];?></span></span>
                        <a href="<?= $weblink.'tour-package-single.php?tourpackageid='.$tourPackages[$i]['TourPackageID'] ?>" class="btn btn-outline-light btn-sm float-end nc-block">View Details</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>
<?php ncfooter(0, $menu,$weblink, $footerData); ?>
<script src="https://apps.elfsight.com/p/platform.js" defer></script>
<script>
setTimeout(() => {
    let a = document.getElementsByTagName('a');
    for(let i=0; a.length>i; i++){
        if(a[i].attributes.href.nodeValue=='https://elfsight.com/google-reviews-widget/?utm_source=websites&utm_medium=clients&utm_content=google-reviews&utm_term=www.coffeeorteatravel.com&utm_campaign=free-widget'){
            a[i].style.display = 'none';
        }
    }
}, 3000);
$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        autoplay: true,
        autoplayhoverpause: true,
        autoplaytimeout:100,
        items: 5,
        nav: true,
        loop: true,
        responsive:{
            0: {items: 1, dits: false },
            485: {items: 2,dots: false },
            728: {items: 3,dots: false },
            960:{items: 4,dots: true },
            1200: {items: 5,dots: true }
        }
    });
});
</script>