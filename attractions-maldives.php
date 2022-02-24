<?php include('partials/templates.php');
ncheader(3, $menu, $weblink); 
$att = ListOfAttractionDetails($db_elegantp,$MyDataField='fldCountryID',$MyDataValue=121,$ORDERBY='fldAttractionTitle',$LIMIT=null); 
$details = PageDetails($db_elegantp,39);?>

<div class="container-fluid bg-theme-color text-light">
    <div class="row bg-maldives-resorts center-cover pt-sm-13">
        <div class="col px-3 px-sm-5 pt-23">
            <h1 class="text-light fw-bolder text-uppercase pt-13 pt-xl-23">Maldives Attractions</h1>
            <p class="text-light"><?= $details['PageTextNoneHTML'];?></p>
        </div>
    </div>
</div>
<div class="bg-coffee">
    <div class="container-fluid bg-theme-color-7 text-light">
        <div class="container py-3 py-sm-5">
            <?php for($i=0; count($att)>$i; $i++){ 
                if($att[$i]['AttractionTitle']){ 
                    if($i%2 == 0){?>
            <div class="row py-5">
                <div class="col-12 col-lg-6 col-xl-8 pb-3">
                    <h3><?= $att[$i]['AttractionTitle']; ?></h3>
                    <h6><?= $att[$i]['AttractionCity']; ?></h6>
                    <p class=""><?= $att[$i]['AttractionText'];?></p>
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <div class="card">
                        <img src="<?= $photo=attphoto($att[$i]['AttractionPhotoArray'][0]['PhotoFileName'],$size='org'); ?>" alt="" class="card-img">
                    </div>
                </div>
            </div>
            <?php }else{ ?>
            <div class="row py-5">
                <div class="col-12 col-lg-6 col-xl-4 order-last order-md-first">
                    <div class="card">
                        <img src="<?= $photo=attphoto($att[$i]['AttractionPhotoArray'][0]['PhotoFileName'],$size='org'); ?>" alt="" class="card-img">
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-8 pb-3">
                    <h3><?= $att[$i]['AttractionTitle']; ?></h3>
                    <h6><?= $att[$i]['AttractionCity']; ?></h6>
                    <p class=""><?= $att[$i]['AttractionText']; ?></p>
                </div>
            </div>
            <?php } } } ?>
        </div>
    </div>
</div>

<?php ncfooter(3, $menu, $weblink); ?>