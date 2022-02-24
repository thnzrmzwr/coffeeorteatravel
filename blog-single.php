<?php include 'partials/templates.php';
if(isset($_GET['blogid']) && is_numeric($_GET['blogid'])){
    $id = $_GET['blogid'];
    $blogd = BlogNewsDetails($db_elegantp,$NewsID=$id);
    $blog = BlogNewsList($db_elegantp,$Limit=null,$ORDERBY='fldNewsCreatedDateTime');
}else{
    exit;
}
$blog = BlogNewsList($db_elegantp,$Limit=null,$ORDERBY='fldNewsCreatedDateTime'); ?>
<?php ncheader(1, $menu, $weblink); ?>
<div class="container-fluid bg-coffee px-0">
    <div class="py-13 bg-theme-color-7 ps-xl-5 ps-lg-0">
        <h1 class="text-light px-3 px-sm-5 h2 fw-bold"><?= $blogd['NewsTitle'] ?></h1>
        <p class="text-light px-3 px-sm-5 mb-2">Post Date: <?php $date = new DateTime($blogd['NewsCreatedDateTime']); echo $date->format("Y-m-d"); ?></p>
        <!-- <p class="text-light px-3 px-sm-5">Category: <?php // echo $blogd['NewsCategoryArray'][0]['TagsTitle'] ?></p> -->
    </div>
</div>
<div class="container-fluid px-0 bg-theme-color">
    <div class="container pt-5 text-light">
        <div class="row">
            <div class="col">
                <img class="img-fluid pb-4 rounded" src="<?= bnphoto($filename=$blogd['NewsPhotoArray'][0]['PhotoFileName'],$size = 'org') ?>" alt="">
            </div>
        </div>
        <div class="row pb-3">
            <div class="col text-light lh-lg pb-5">
                <p><?= $blogd['NewsTextHTML'] ?></p>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid bg-coffee px-0">
    <div class="bg-theme-color-7 p-0">
        <div class="container py-3">
            <div class="row py-5">
                <h4 class="fw-bold py-3 text-light">You might also like:</h4>
                <?php for($i=0; 4>$i; $i++){ 
                    if( $blog[$i]['NewsTitle']){ ?>
                <div class="col-sm-6 col-lg-4 col-xl-3 p-3">
                    <div class="card h-full bg-dark text-light border border-secondary">
                        <img src="<?php echo bnphoto($filename=$blog[$i]['NewsPhotoArray'][0]['PhotoFileName'],$size = 'std'); ?>" alt="" class="card-img-top h-180 center-cover">
                        <div class="card-body">
                            <h6 class="card-title text-capitalize"><?php if(strlen($blog[$i]['NewsTitle'])>70){
                                echo substr_replace($blog[$i]['NewsTitle'], "...", 70);
                            }else{
                                echo $blog[$i]['NewsTitle'];
                            } ?></h6>
                            <p class="text-ncs-light card-text ncs-small fw-semi"><?php $des = substr_replace($blog[$i]['NewsTextNoneHTML'], "...", 150);
                                $des = str_replace("<p>", '', $des);
                                echo str_replace("</p>", '', $des);
                            $des= null; ?></p>
                        </div>
                        <div class="card-footer bg-secondary">
                            <span class="text-end"><i class="fas fa-calendar-alt me-2"></i><?php $date = new DateTime($blog[$i]['NewsCreatedDateTime']);
                            echo $date->format("Y-m-d"); ?></span>
                            <a href="<?= $weblink.'blog-single.php?blogid='.$blog[$i]['NewsID'] ?>" class="btn btn-outline-light btn-sm float-end">View Details</a>
                        </div>
                    </div>
                </div>
                <?php } } ?>
            </div>
        </div>
    </div>
</div>
<?php ncfooter(1, $menu, $weblink); ?>