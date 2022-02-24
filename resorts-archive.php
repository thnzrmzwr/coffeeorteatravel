<?php include 'partials/templates.php';
if(isset($_GET['country-resort']) && is_numeric($_GET['country-resort'])){
    $country = $_GET['country-resort'];
    $gtag = $_GET['r-tag'];
}else{
    exit;
}
$resortsA = GetProductSafSmartSQl($db_elegantp,"p.fldCountryID =$country",$GROUPBY=null,$ORDERBY=null,$LIMIT=null);
for($i=0; count($resortsA)>$i; $i++){
    $pid = $resortsA[$i]['ProductID'];
    $ptags = $resortsA[$i]['ProductTagsArray'];
    for($p=0; count($ptags)>$p; $p++){
        $tagsT[] = $ptags[$p]['TagsTitle'];
    }
}
$tagsTi = array_unique($tagsT); ?>
<?php ncheader(3, $menu, $weblink); ?>

<div class="container-fluid bg-theme-color text-light">
    <div class="row bg-bottom-cover pt-sm-13" style="<?= ($country==121) ? 'background: linear-gradient(#fff0 0%, #fff0 50%, #161616), url(https://www.coffeeorteatravel.com/en/assets/img/pexels-asad-photo-maldives-1483053.jpg);':'background: linear-gradient(#fff0 0%, #fff0 50%, #161616), url(https://www.coffeeorteatravel.com/en/assets/img/sl-kandy.jpg);';?>">
        <div class="col px-3 px-sm-5 pt-23">
            <h1 class="text-light fw-bolder text-uppercase pt-13 pt-xl-23"><?= ($country==121)? 'Maldives' : 'Sri Lanka'; ?> Resorts</h1>
            <p class="text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </div>
    <div class="container">
        <div class="row bg-theme-color p-3 p-lg-5 text-dark" id="maldives-resorts">
            <h3 class="h2 text-center text-md-start fw-bold pt-5 pb-3 text-light">Filter Resort by Tag</h3>
            <div id="resort-buttons" class="py-4">
                <button class="btn btn-light" onclick="resortFilter(this, 0)">All</button>
                <?php for($i=0; count($tagsTi)>$i; $i++){ ?>
                    <button class="btn <?= ($gtag == $tagsTi[$i]) ? 'btn-secondary' : 'btn-light'; ?>" onclick="resortFilter(this, '<?= $tagsTi[$i] ?>')"><?= $tagsTi[$i] ?></button>
                <?php } ?>
            </div>
            <?php for($rc=0; count($resortsA)>$rc; $rc++){ ?> 
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3 resort-card" data-tags="<?= $tagsT[$rc] ?>">
                <div class="card h-full bg-dark border border-secondary text-light">
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

        <div class="row py-5">
            <br>
        </div>
    </div>
</div>
<?php ncfooter(3, $menu, $weblink); ?>
<script>
    function resortFilter(elem, selValue){
  var resorts = document.querySelectorAll('.resort-card');
  let btns = document.querySelectorAll('#resort-buttons button');
  if(elem !== ''){
    for(b=0; btns.length>b; b++){
      btns[b].classList.remove('btn-secondary');
      btns[b].classList.add('btn-light');
    }
    elem.classList.remove('btn-light');
    elem.classList.add('btn-secondary');
  }
  if(resorts.length > 0){
    for(r=0; resorts.length > r; r++){
      if(selValue == 0){
        resorts[r].classList.remove('animate-none');
        resorts[r].classList.add('animate-block');
      }else{
          resorts[r].classList.remove('animate-block');
          resorts[r].classList.add('animate-none');
          let tags = document.querySelectorAll('.r-tags')[r].innerText;
          let tagsA = tags.split(', ');
          if(tagsA.indexOf(selValue) !== -1){
            resorts[r].classList.remove('animate-none');
            resorts[r].classList.add('animate-block');
          }
      }
      if(resorts[r].classList.contains('animate-none')){
        setTimeout(dNone, 400, resorts[r],0);
      }else{
        setTimeout(dNone, 400, resorts[r],1);
      }
    }
  }
}
function dNone(rcard,visible){
  if(visible==0){
    rcard.style.display = 'none';
  }else{
    rcard.style.display = 'block';
  }
}
window.addEventListener('load', function () {
    try{
      console.log('triggerd');
      <?php echo ($gtag) ? "setTimeout(resortFilter, 600, '', '$gtag')" : ''; ?>
    }catch(e){
        console.log(e);
    }
})
</script>