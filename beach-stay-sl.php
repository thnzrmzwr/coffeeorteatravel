<?php include 'partials/templates.php'; 
if(isset($_GET['atid'])){
    $AttractionID = $_GET['atid'];
    $attD =AttractionDetails($db_elegantp,$AttractionID);
    //print_r($attD);
    $attProduct= explode("||", $attD['AttractionProductIds']);
    //print_r($attProduct);
}

ncheader(3, $menu, $weblink);?>
<div class="container-fluid px-0 bg-theme-color">
    <div class="owl-carousel carousel-se1 owl-theme">
        <?php for($ap=0; count($attD['AttractionPhotoArray'])>$ap; $ap++){ ?>
        <div class="position-relative">
            <img class="bgimg" style="height:70vh;" src="<?= $photo=attphoto($attD['AttractionPhotoArray'][$ap]['PhotoFileName'],$size='org'); ?>" alt="" >
            <div class="bgimgoverlay-full px-5 flex-center-items theme-gradient-bt" style="height:70vh;justify-content:end;">
                <div class="container">
                    <h2 class="text-light fs-1"><?= $attD['AttractionPhotoArray'][$ap]['PhotoName'] ?></h2>
                    <h4 class="text-ncs-light"><?= $attD['AttractionCity'] ?></h4>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="col text-ncs-light py-5 lh-lg">
                <p><?= $attD['AttractionText'] ?></p>
            </div>
        </div>
    </div>
</div>
<div class="bg-coffee">
    <div class="container-fluid bg-theme-color-7">
        <div class="container pb-5">
            <h2 class="pt-5 text-light text-center fw-bold pb-1">Near by Resorts</h2>
            <div class="row text-light">
                <?php for($p=0; count($attProduct)>$p; $p++){ 
                    $ProductID = str_replace("|", '', $attProduct[$p]);
                    $product=ProductDetailsEdited($db_elegantp,$ProductID); 
                    //print_r($product);?>
                <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                    <div class="card h-full bg-dark border border-secondary text-light">
                        <img src="<?= fphoto($product['ProductPhotoArray'][0]['ProductPhotoFileName'], 'med'); ?>" alt="" class="card-img-top h-270 center-cover">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['ProductShortDisplayName'] ?></h5>
                            <p class="text-ncs-light card-text ncs-small fw-semi">
                                <span class="float-start text-capitalize">Country: <?= $product['ProductCountryName'] ?></span><br>
                                <span class="d-block mt-2"><?=  substr_replace($product['ProductHighlight'], "...", 180) ?></span></p>
                        </div>
                        <div class="card-footer bg-secondary">
                            <a href="https://www.coffeeorteatravel.com/en/resort-single.php?resortid=<?= $product['ProductID'] ?>&country=183" class="btn btn-outline-warning btn-sm float-end">View Resort</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php ncfooter(3, $menu, $weblink); ?>
<script>
$(document).ready(function(){
    $('.carousel-se1').owlCarousel({
        autoplay: false,
        autoplayhoverpause: true,
        autoplaytimeout:300,
        items: 1,
        nav: true,
        dots: false,
        loop: false
    });
});
</script>