<?php 
include $_SERVER['DOCUMENT_ROOT'].'/config/include.config.php';
include($_SERVER["DOCUMENT_ROOT"]."/config/config.php");
include($_SERVER["DOCUMENT_ROOT"]."/function/web_function.php");
$gbed = [0=>"N/A",31=>"1C",32=>"2C",33=>"3C",34=>"4C",35=>"5C",36=>"6C",37=>"7C",38=>"8C",39=>"9C",1=>"1A",2=>"1A 1C",3=>"1A 2C",4=>"1A 3C",5=>"1A 4C",6=>"2A",7=>"2A 1C",8=>"2A 2C",9=>"2A 3C",10=>"2A 4C",11=>"3A",12=>"3A 1C",13=>"3A 2C",14=>"3A 3C",15=>"3A 4C",16=>"4A",17=>"4A 1C",18=>"4A 2C",19=>"4A 3C",20=>"4A 4C",41=>"4A 7C",21=>"5A",22=>"5A 1C",23=>"5A 2C",24=>"5A 3C",25=>"5A 4C",26=>"6A",27=>"6A 1C",28=>"6A 2C",29=>"6A 3C",30=>"6A 4C",42=>"6A 5C",43=>"6A 7C",44=>"6A 8C",45=>"6A 9C",46=>"6A 10C",47=>"6A 11C",48=>"6A 12C",49=>"7A",50=>"7A 1C",51=>"7A 2C",52=>"7A 3C",53=>"7A 4C",54=>"7A 6C",55=>"7A 7C",56=>"7A 8C",57=>"7A 9C",58=>"7A 10C",59=>"7A 11C",60=>"8A",61=>"8A 1C",62=>"8A 2C",63=>"8A 3C",64=>"8A 4C",65=>"8A 5C",66=>"8A 6C",67=>"8A 7C",68=>"8A 8C",69=>"8A 9C",70=>"9A",71=>"9A 1C",72=>"9A 2C",73=>"9A 3C",74=>"9A 4C",75=>"9A 5C",76=>"9A 6C",77=>"9A 7C",78=>"9A 8C",79=>"9A 9C",80=>"10A",81=>"10A 1C",82=>"10A 2C",83=>"10A 3C",84=>"10A 4C",85=>"10A 5C",86=>"10A 6C",87=>"10A 7C",88=>"10A 8C",89=>"10A 9C",90=>"11A",91=>"11A 1C",92=>"11A 2C",93=>"11A 3C",94=>"11A 4C",95=>"11A 5C",96=>"11A 6C",97=>"11A 7C",98=>"11A 8C",99=>"11A 9C",100=>"12A",40=>"12A",101=>"12A 1C",102=>"12A 2C",103=>"12A 3C",104=>"12A 4C",105=>"12A 5C",106=>"12A 6C",107=>"12A 7C",108=>"12A 8C",109=>"12A 9C",110=>"13A",111=>"13A 1C",112=>"13A 2C",113=>"13A 3C",114=>"13A 4C",115=>"13A 5C",116=>"13A 6C",117=>"13A 7C",118=>"13A 8C",119=>"13A 9C",120=>"14A",121=>"14A 1C",122=>"14A 2C",123=>"14A 3C",124=>"14A 4C",125=>"14A 5C",126=>"14A 6C",127=>"14A 7C",128=>"14A 8C",129=>"14A 9C",130=>"16A",132=>"23A",131=>"25A"];

//Program to display current page URL.
 $weblink = $WEBSITEDOMAIN.'/en/';
 $menu = ['Home'=>'#', 'Our Stories'=>'our-stories.php', 'About us'=>'about-us.php', 'Tours'=>['toursSub', '#', [['Maldives Tours','maldives-tours.php'],['Sri Lanka Tours','sri-lanka-tours.php']]], 'Next Trips'=>'next-trips.php', 'Contact us'=>'contact-us.php'];
 $inside_pages = ['Create your own holiday'=>'create-your-holiday.php', 'Sri Lanka Attractions'=>'attractions-sri-lanka.php', 'Resorts Archive'=>'resorts-archive.php', 'Maldives Attractions'=>'attractions-maldives.php'];

function ncheader($page_index, $menu, $weblink){ 
include $_SERVER['DOCUMENT_ROOT'].'/config/include.config.php';
$specific = [0,3,8];?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo "$WEBSITE_NAME | ";
            $x=0; foreach($menu as $item=>$link){
            echo($page_index==$x) ? "$item" : ''; $x++; } 
        ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $weblink; ?>assets/css/all.min.css">
    <!-- specific scripts -->
    <?php if(in_array($page_index, $specific)){ ?>
        <link rel="stylesheet" href="<?= $weblink; ?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?= $weblink; ?>assets/css/owl.theme.default.min.css">
    <?php } ?>
    <link rel="stylesheet" href="<?= $weblink; ?>assets/css/ncStyle.css">
</head>
<body>
    <header class="bg-theme-color text-ncs-light">
        <div class="col py-2 px-1 px-sm-3 px-md-5">
            <p class="text-ncs-light me-sm-3 ps-xl-5 ps-lg-0 text-center d-block d-md-inline-block mb-0"><i class="far fa-map me-2"></i><?= $HeadOfficeADDRESS; ?></p>
            <p class="text-ncs-light d-md-inline-block d-block mb-0 mt-2 text-center"><i class="fal fa-phone-alt me-2"></i><?= $HeadOfficePHONE; ?></p>
            <!-- <input type="text" name="search" class="float-end bg-ncs-light border" id=""> -->
        </div>
        <hr class="text-ncs-light mt-0">
        <nav class="navbar navbar-dark navbar-expand-lg pt-0 px-xl-5 px-lg-0 col-12">
            <div class="container-fluid px-sm-3 px-md-5">
                <a class="navbar-brand" href="<?= $weblink; ?>">
                    <img class="logo" src="<?= $weblink; ?>assets/img/logo-white.png" alt="" width="30" height="24">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mob-menu" >
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav light text-uppercase">
                        <?php $x=0;
                        foreach($menu as $item=>$link){
                            if(!is_array($link)){
                                echo '<li class="nav-item px-1"><a class="nav-link'; 
                                echo($page_index==$x) ? ' active" aria-current="page"': '"';
                                echo 'href="'.$weblink.$link.'">'.$item.'</a></li>';
                            }else{ ?>
                                <li class="nav-item px-1 dropdown">
                                    <a class="nav-link <?php echo($page_index==$x) ? 'active ': ''; ?>dropdown-toggle" href="<?php echo $link[1]; ?>" id="<?php echo $link[0]; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo $item; ?>
                                    </a>
                                    <ul class="dropdown-menu bg-theme-color" aria-labelledby="<?php echo $link[0]; ?>">
                                        <?php 
                                        for($i=0; count($link[2])>$i; $i++){ 
                                            echo '<li><a class="dropdown-item text-ncs-light" style="font-size:14px;" href="'.$link[2][$i][1].'">'.$link[2][$i][0].'</a></li>';
                                        } ?>
                                    </ul>
                                </li>
                        <?php    }
                        $x++;
                        } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<?php } ?>

<!-- footer -->
<?php function ncfooter($page_index,$menu, $weblink){ 
include $_SERVER['DOCUMENT_ROOT'].'/config/include.config.php';
$specific = [0,3,8]; ?>
    <!-- mobile menu -->
    <div class="offcanvas bg-theme-color text-ncs-light offcanvas-start" tabindex="-1" id="mob-menu" aria-labelledby="mob-menuLabel">
        <div class="offcanvas-header">
            <a class="navbar-brand ms-2" href="<?= $weblink; ?>">
                <img class="logo" src="<?= $weblink; ?>assets/img/logo-white.png" alt="" width="20" height="15">
            </a>
            <h5 class="d-none text-light fw-bolder h5 text-uppercase" id="mob-menuLabel">Coffee or Tea</h5>
            <button type="button" class="btn-close text-reset bg-light rounded-circle me-1 me-sm-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="nav flex-column">
                <?php $x=0;
                    foreach($menu as $item=>$link){
                        echo '<a class="nav-link fs-4 fw-bolder';
                        echo($page_index==$x) ? ' text-light"': ' text-ncs-light"';
                        echo 'href="'.$weblink.$link.'">'.$item.'</a>';
                        $x++;
                    } ?>
            </nav>
        </div>
    </div>
    <!-- footer -->
    <div class="container-fluid footer-coffee">
    <div class="h-50p"></div>
    <div class="row px-5 pt-5">
        <div class="col-lg-4 col-md-6 px-0 px-md-4 px-lg-5 py-3">
            <a class="navbar-brand" href="#">
                <img class="logo" src="<?php echo $weblink; ?>assets/img/logo-white.png" alt="" width="30" height="24">
            </a>
            <p class="text-ncs-light mt-2">
                Coffee or Tea is an inbound tour operator for Sri Lanka and the Maldives based in Colombo Sri Lanka. We created this company after years of experience in the Sri Lankan and the Maldives tourism industry.
            </p>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6 py-3 px-0 px-md-4 px-lg-2 px-xl-4">
            <p class="h5 fw-bold text-light">Quick Links</p>
            <div class="pe-p60">
                <hr class="text-ncs-light">
            </div>
            <?php 
                foreach($menu as $itm=>$link){
                    echo '<p class="text-capitalize fw-normal"><i class="far fa-play me-2"></i><a class="text-ncs-light text-decoration-none" href="'.$link.'">'.$itm.'</a></p>';
                }
            ?>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 py-3 px-0 px-md-4 px-lg-3 px-xl-4">
            <p class="h5 fw-bold text-light">Next Trips</p>
            <div class="pe-p60">
                <hr class="text-ncs-light">
            </div>
            <div class="mb-2">
                <span class="text-capitalize fw-normal d-inline-block mb-2"><i class="far fa-play me-2"></i><a class="text-ncs-light text-decoration-none" href="/">28 Jan 2022</a></span>
                <p class="text-ncs-light">Maldives Natural islands/ snorkeling tour</p>
            </div>
            <div class="mb-2">
                <span class="text-capitalize fw-normal d-inline-block mb-2"><i class="far fa-play me-2"></i><a class="text-ncs-light text-decoration-none" href="/">21 Feb 2022</a></span>
                <p class="text-ncs-light">Maldives Natural islands/ snorkeling tour</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 py-3 px-0 px-md-3 px-lg-4">
            <p class="h5 fw-bold text-light">Contacts</p>
            <div class="pe-p60">
                <hr class="text-ncs-light">
            </div>
            <div class="mb-2">
                <p class="text-ncs-light"><?= $ReservationsADDRESS; ?></p>
            </div>
            <p><i class="fas fa-phone-alt text-ncs-light me-2"></i><a class="text-ncs-light" href="tel:<?= $HeadOfficePHONE; ?>"><?= $HeadOfficePHONE; ?></a></p>
            <p><i class="fas fa-envelope text-ncs-light me-2"></i><a class="text-ncs-light" href="mailto:info@coffeeandtea.com">info@coffeeandtea.com</a></p>
            <a class="btn bg-theme-color-6 text-light me-1 mb-1" href="<?= $menu['Contact us'].'#contact' ?>">Contact us</a>
            <a class="btn bg-theme-color-6 text-light me-1 mb-1" href="<?= $menu['Contact us'].'#visit' ?>">Visit us</a>
        </div>
        <div class="h-50"></div>
    </div>
    <div class="row px-5 py-5">
        <hr class="text-ncs-light">
        <div class="col-12 col-sm-6">
                <p class="text-light text-center text-sm-start fw-bolder h5">Cofee or Tea</p>
        </div>
        <div class="col-12 col-sm-6">
                <p class="text-ncs-light text-center text-sm-end"><?php echo $Copyright; ?></p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- load necessary specific scripts -->
<?php if(in_array($page_index, $specific)){?>
    <script src="<?= $weblink; ?>assets/js/jquery.min.js"></script>
    <!-- owl carousel -->
    <script src="<?= $weblink; ?>assets/js/owl.carousel.min.js"></script>
<?php } ?>
    <script src="<?php echo $weblink; ?>assets/js/ncScript.js"></script>
</body>
</html>
<?php } ?>