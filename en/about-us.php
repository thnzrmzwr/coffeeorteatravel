<?php include 'partials/templates.php';
$paged = PageDetails($db_elegantp,1);
$para = explode("</p>", $paged['PageTextHTML']);
?>
<?php ncheader(2, $menu,$weblink, $footerData); ?>
<div class="container-fluid text-light bg-theme-color">
    <div class="row bg-about-us pt-sm-13">
        <div class="col px-3 px-sm-5 pt-23">
            <h1 class="text-light fw-bolder text-uppercase pt-13 pt-xl-23"><?= $paged['PageTitle']; ?></h1>
            <p class="text-light"><?= $paged['PageSEODescription']; ?></p>
        </div>
    </div>
    <div class="row pt-5 bg-theme-color-6 text-ncs-light ps-xl-5 ps-lg-0" id="about-us">
        <div class="col-lg-7 col-md-12 pe-md-2 ps-3 pe-1 px-sm-5 pt-4">
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
        <div class="col-12 pt-5">
            <p class="text-center"></p>
        </div>
    </div>
</div>
<?php ncfooter(2, $menu, $weblink, $footerData); ?>