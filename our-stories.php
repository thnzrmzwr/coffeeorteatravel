<?php include 'partials/templates.php'; 
$blog = BlogNewsList($db_elegantp,$Limit=null,$ORDERBY='fldNewsCreatedDateTime'); ?>
<?php ncheader(1, $menu, $weblink); ?>
<div class="container-fluid text-light bg-theme-color pb-5">
    <div class="row bg-our-stories pt-sm-13">
        <div class="col px-3 px-sm-5 pt-23">
            <h1 class="text-light fw-bolder text-uppercase pt-13 pt-xl-23">Our Stories</h1>
            <p class="text-light"><?php $page =PageDetails($db_elegantp,19);
        $para = explode("|", $page['PageTextNoneHTML']);
        echo $para[0];?></p>
        </div>
    </div>
    <div class="container py-5 text-dark">
        <div class="row pt-4">
            <?php for($i=0; count($blog)>$i; $i++){ ?>
            <div class="col-sm-6 col-lg-4 col-xl-3 p-3">
                <div class="card bg-dark h-full text-light border border-secondary">
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
            <?php } ?>
        </div>
    </div>

</div>
<?php ncfooter(1, $menu, $weblink); ?>