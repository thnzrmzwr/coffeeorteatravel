<?php include 'partials/templates.php';
if(isset($_GET['resortid']) && is_numeric($_GET['resortid'])){
    $id = $_GET['resortid'];
    $country = $_GET['country'];

}else{
    exit;
}
    //$id = 98;//$_GET['tourpackageid'];
    $details =ProductDetails($db_elegantp,$ProductID=$id);
    $productD = $details['ProductTextCategoryArray'];
    $pp = ProductPhotosGellaryEditednaz($db_elegantp,$ProductID,null);
    
    for($i=0; count($productD)>$i; $i++){
        if($productD[$i]['ProductTextCategoryName']=='Overview'){
            $overviewText = $productD[$i]['ProductTextCategoryTextArray'][0]['ProductText'];

        }else if($productD[$i]['ProductTextCategoryName']=='Location'){
            $locationText = $productD[$i]['ProductTextCategoryTextArray'][0]['ProductText'];

        }else if($productD[$i]['ProductTextCategoryName']=='Accommodation'){
            $accommodationsA = $productD[$i]['AccommodationNameArray'];

        }else if($productD[$i]['ProductTextCategoryName']=='Dining'){
            $diningA = $productD[$i]['ProductTextCategoryTextArray'];

        }else if($productD[$i]['ProductTextCategoryName']== 'The Spa'){
            $spaA = $productD[$i]['ProductTextCategoryTextArray'];

        }else if($productD[$i]['ProductTextCategoryName']=='Facilities'){
            $facilitiesA = $productD[$i]['ProductTextCategoryTextArray'];
        }
    }
    //$country = 121;
    $resortsA = GetProductSafSmartSQl($db_elegantp,"p.fldCountryID =$country",$GROUPBY=null,$ORDERBY=null,$LIMIT=null);
    for($i=0; count($resortsA)>$i; $i++){
        $pid = $resortsA[$i]['ProductID'];
        $ptags = $resortsA[$i]['ProductTagsArray'];
        for($p=0; count($ptags)>$p; $p++){
            $tagsT[] = $ptags[$p]['TagsTitle'];
        }
    }
    $tagsTi = array_unique($tagsT);

ncheader(3, $menu, $weblink); ?>
<div class="container-fluid px-0 bg-theme-color">
    <div class="owl-carousel carousel-se1 owl-theme">
        <?php for($i=0; count($pp)>$i; $i++){ ?>
            <div class="position-relative">
               <img class="bgimg" style="height:70vh;" src="<?= fphoto($pp[$i]['ProductPhotoFileName'], 'org') ?>" alt="" >
               <div class="bgimgoverlay-full px-5 flex-center-items theme-gradient-bt" style="height:70vh;justify-content:end;">
                    <h2 class="text-light fs-1 px-3 px-sm-5"><?= $pp[$i]['ProductPhotoName'] ?></h2>
                    <h4 class="text-light px-3 px-sm-5"><?= $details['ProductShortDisplayName'] ?></h4>
                </div>
            </div>
        <?php /*$i = count($pp);*/ } ?>
    </div>
    <div class="container bg-theme-color">
        <div class="row py-5 py-lg-13 text-light">
            <div class="col-md-12 col-lg-7">
                <div class="pt-3 pb-4">
                    <h1 class="fw-bold"><?= $details['ProductName'] ?></h1> 
                    <p class="me-2 d-inline-block"><?= $details['ProductAtollDistric'].', '.$details['ProductIslandCity'].', '.$details['ProductCountryName'] ?></p>
                    <p class="text-warning d-inline-block">Ratings: <?php for($i=0; $details['ProductStarRating']>$i; $i++){echo '<i class="fas fa-star"></i>';} ?></p>
                </div>
                <div class="py-4">
                    <h4>Location</h4>
                    <p class="lh-lg Cmo"><?= $locationText ?></p>
                </div>
                <div class="py-4">
                    <h4>Overview</h4>
                    <p class="lh-lg Cmo"><?= $overviewText ?></p>
                </div>
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
                    <div class="mb-2">
                        <textarea class="form-control" placeholder="If anything write here.." id="floatingTextarea2" style="height: 100px"></textarea>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-warning">Request For Quotation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="bg-coffee">
    <div class="container-fluid bg-theme-color-7">
        <div class="container pt-5 text-light">
            <div class="py-4">
                <div class="row text-light">
                    <div class="col-12">
                        <h3 class="text-center text-sm-start fw-bold lh-base">Available Accommodations</h3>
                    </div>         
                </div>
                <div class="row py-4 g-5">
                    <?php for($a=0; count($accommodationsA)>$a; $a++){ ?>
                        <div class="col-lg-12 col-xl-6 accom<?= ($a>3)? ' scale0" style="display:none': ''; ?>">
                            <div class="row border border-warning p-3 rounded h-full bg-theme-color">
                                <div class="col-12 col-sm-5">
                                    <img class="width-full" style="height: 100%;object-fit: cover;" src="<?php $res = AccommodationPhotosEdited($db_elegantp,$accommodationsA[$a]['AccommodationID'],$LIMIT=null);
                                    echo fphoto($res[0]['AccommodationPhotoFileName'],$size = 'std'); $res=null;
                                    ?>" alt="">
                                </div>
                                <div class="col-12 pt-3 pt-sm-0 col-sm-7">
                                    <h5><?= $accommodationsA[$a]['AccommodationName'] ?></h5>
                                    <p class="text-ncs-light small CmoA"><?php 
                                        echo substr_replace($accommodationsA[$a]['AccommodationTextArray'][0]['AccommodationText'], "...", 250); ?>
                                        <span class="small pointer text-primary" data-bs-toggle="modal" data-bs-target="#seemore<?= $a ?>">See more</span>
                                    </p>
                                    <button class="btn btn-outline-warning rounded">Book Now</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="my-3 text-center">
                        <button class="btn btn-outline-warning mt-5 mx-auto laccom"><i class="fa-solid fa-rotate"></i>Load More Accommodations</button>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<div class="container-fluid bg-theme-color">
    <div class="container py-5">
        <?php for($p=0; count($productD)>$p; $p++){ 
        if(!in_array($productD[$p]['ProductTextCategoryName'],['Overview', 'Location', 'Accommodation'])){ ?>
        <div class="row">
            <div class="col-12 pt-5">
                <h3 class="fw-bold text-light pt-4 pb-2"><?= $productD[$p]['ProductTextCategoryName'] ?></h3>
                <?php if(count($productD[$p]['ProductTextCategoryTextArray'])>1){ ?>
                <div class="accordion" id="ncaccordion">
                    <?php for($i=0; count($productD[$p]['ProductTextCategoryTextArray'])>$i; $i++){ ?>
                    <div class="accordion-item border border-secondary">
                        <h2 class="accordion-header" id="heading<?= "$p$i" ?>">
                            <button class="accordion-button accordion-warning fw-semi text-ncs-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= "$p$i" ?>" aria-expanded="true" aria-controls="collapse<?= "$p$i" ?>"><?= $productD[$p]['ProductTextCategoryTextArray'][$i]['ProductTextTitle'] ?></button>
                        </h2>
                        <div id="collapse<?= "$p$i" ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= "$p$i" ?>" data-bs-parent="#ncaccordion">
                            <div class="accordion-body bg-theme-color-7 text-ncs-light">
                                <div class="row">
                                    <div class="col-12">
                                        <img class="width-full width-sm-unset" src="<?php /*$tipe = TourItineraryPhotoEdited($db_elegantp, $productD[$p]['ProductTextCategoryTextArray'][$i]['TourItineraryID']);
                                        if($tipe){
                                            echo tiphoto($tipe[0]['TourItineraryPhotoFileName'],$size = 'thu'); 
                                        } */?>">
                                    </div>
                                    <div class="col-12">
                                        <p class="mt-3"><?php echo  $productD[$p]['ProductTextCategoryTextArray'][$i]['ProductText']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php }else{ ?>
                    <h6 class="text-light fw-semi"><?= $productD[$p]['ProductTextCategoryTextArray'][0]['ProductTextTitle'] ?></h6>
                    <p class="text-ncs-light pt-2"><? if(strpos($productD[$p]['ProductTextCategoryTextArray'][0]['ProductText'], '*') !== false){ 
                        echo '<ul class="text-ncs-light">';
                        echo str_replace('*','<li>',$productD[$p]['ProductTextCategoryTextArray'][0]['ProductText']); echo '</ul>';
                    }else{
                        echo $productD[$p]['ProductTextCategoryTextArray'][0]['ProductText'];
                    } ?></p>
                <?php } ?>
            </div>
        </div>
        <?php } } ?>
    </div>
</div>
<div class="bg-coffee">
    <div class="container-fluid bg-theme-color-7">
        <div class="container pt-5 text-light">
            <div class="py-4">
                <?php if('sri lanka'==strtolower($details['TourPackageCountryName'])){
                    $countryid = 183;
                }else{
                    $countryid = 121;
                }
                $alsoLike = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID=$countryid",$GROUPBY=null,$ORDERBY=null,$LIMIT=null); ?>
                <div class="row py-5">
                    <h3 class="fw-bold text-light">Explore Resorts in <?= ($country==183) ? 'Sri Lanka' : 'Maldives'; ?>:</h3>
                    <?php for($rc=0; 4>$rc; $rc++){ ?> 
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3 resort-card" data-tags="<?= $tagsT[$rc] ?>">
                        <div class="card border border-secondary bg-dark text-light">
                            <img src="<?php $pphoto = ProductPhotoEdited($db_elegantp,$ProductID=$resortsA[$rc]['ProductID']);
                            echo fphoto($pphoto['ProductPhotoFileName'], 'med'); $pphoto =null;
                            ?>" alt="" class="card-img-top h-270 center-cover">
                            <div class="card-body">
                                <h5 class="card-title"><?= $resortsA[$rc]['ProductShortDisplayName'] ?></h5>
                                <p class="text-ncs-light card-text ncs-small fw-semi">
                                    <span class="float-start text-capitalize">Country: <?= strtolower($resortsA[$rc]['ProductCountryName']) ?></span><br><span class="d-block mt-2">Tags:<i class="fas fa-tags ms-2"></i><span class="r-tags ms-2"><?php for($pt=0; count($resortsA[$rc]['ProductTagsArray'])>$pt; $pt++){
                                                    echo $resortsA[$rc]['ProductTagsArray'][$pt]['TagsTitle'];
                                                    echo (count($resortsA[$rc]['ProductTagsArray'])==$pt+1)? '' : ', ';
                                    } ?></span></p>
                            </div>
                            <div class="card-footer bg-secondary">
                                <span class="float-start ncs-small"><?= ($resortsA[$rc]['ProductIslandCity']) ? 'City: '.strtolower($resortsA[$rc]['ProductIslandCity']) : ''; ?></span>
                                <a href="<?= $weblink.'resort-single.php?resortid='.$resortsA[$rc]['ProductID'].'&country='.$country ?>" class="btn btn-outline-warning btn-sm float-end">View Resort</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!=========modals=======>
<?php for($a=0; count($accommodationsA)>$a; $a++){ ?>
    <div class="modal fade" id="seemore<?= $a ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog p-sm-3 p-md-5" style="max-width:960px;">
            <div class="bg-coffee">
                <div class="modal-content bg-theme-color-7 border-warning">
                    <div class="modal-header text-light border-warning">
                        <h5 class="modal-title" id="exampleModalLabel"><?= $accommodationsA[$a]['AccommodationName'] ?></h5>
                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <?php $res = AccommodationPhotosEdited($db_elegantp,$accommodationsA[$a]['AccommodationID'],$LIMIT=null); ?>
                                <div class="owl-carousel carousel-se2 owl-theme">
                                    <?php for($rs=0; count($res)>$rs; $rs++){ ?>
                                        <div class="position-relative">
                                            <img class="width-full" style="height:100%;object-fit:cover;" src="<?php echo fphoto($res[$rs]['AccommodationPhotoFileName'],$size = 'org');  ?>" alt="" >
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-ncs-light pt-3"><?= $accommodationsA[$a]['AccommodationTextArray'][0]['AccommodationText'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-warning">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php ncfooter(3, $menu, $weblink); ?>
<script>
$(document).ready(function(){
    $('.carousel-se1').owlCarousel({
        autoplay: true,
        autoplayhoverpause: true,
        autoplaytimeout:300,
        items: 1,
        nav: true,
        dots: false,
        loop: true
    });
    $('.carousel-se2').owlCarousel({
        autoplay: false,
        autoplayhoverpause: true,
        autoplaytimeout:300,
        items: 1,
        nav: true,
        dots: true,
        loop: false
    });
    var hd=0;
    var laccom = document.querySelector('.laccom');
    laccom.addEventListener('click', event=>{

        var accom = document.querySelectorAll('.accom');
        let l=lc= 0;
        for(i=0; accom.length>i; i++){
            if(accom[i].style.display == 'none'){
                if(l<4){
                    accom[i].style.display = '';
                    accom[i].classList.add('animate-block');
                    l++;
                }
                lc = true;
            }else{
                lc=false;
            }
        }
        console.log(lc);
        if(lc==true){
            laccom.style.display = 'block';
        }else{
            laccom.style.display = 'none';
        }
    });

    var ind=0;
    var CmoT = [];
    var Cmo = document.querySelectorAll('.Cmo');
    for(let i=0; Cmo.length>i; i++){
        if(Cmo[i].innerText.length>500){
            CmoT.push(Cmo[i].innerText);
            let CmoP = Cmo[i].innerText.substring(0, 480)+'...';
            document.querySelectorAll('.Cmo')[i].innerText = CmoP;
            let span =document.createElement('span');
            span.innerText = 'See more';
            span.classList = 'CmoB text-primary small pointer';
            span.dataset.pid = ind;
            Cmo[i].appendChild(span);
            span.addEventListener('click', Event=>{
                seeMore(span.dataset.pid,Cmo[i]);
            });
            ind++;
        }
    }

    function seeMore(text, element){
        element.innerText=CmoT[text]+'...';
        let span = document.createElement('span');
        span.classList = 'Cmols text-secondary small pointer';
        span.dataset.pid = text;
        span.innerText = 'See less'
        element.appendChild(span);
        span.addEventListener('click', Event=>{
            seeLess(element, 480, text);
        });
    }

    function seeLess(element, length, index){
       element.innerText = element.innerText.substring(0, length)+'...';
       let span = document.createElement('span');
       span.classList = 'CmoB text-primary small pointer';
       span.innerText = 'See more';
       span.dataset.pid = index;
       element.appendChild(span);
       span.addEventListener('click', Event=>{
        seeMore(index, element);
       });
    }

});
</script>