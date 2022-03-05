<?php include 'partials/templates.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>slider check</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.mins.css">
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Montserrat&amp;display=swap"rel="stylesheet'>
    <link rel="stylesheet" href="<?php echo $weblink; ?>assets/css/3dslider.css">
</head>
<body>
    <!-- slider start -->
    <div class="app">
        <div class="ncrow">
            <div class="nccol app">
                <div class="cardList">
                    <button class="cardList__btn btn btn--left">
                        <div class="icon">
                            <svg>
                                <use xlink:href="#arrow-left"></use>
                            </svg>
                        </div>
                    </button>
                    <div class="cards__wrapper">
                        <div class="card current--card">
                            <div class="card__image">
                                <img src="<?php echo $weblink; ?>assets/img/3.jpeg">
                            </div>
                        </div>
                        <div class="card next--card">
                            <div class="card__image">
                                <img src="<?php echo $weblink; ?>assets/img/1.jpeg">
                            </div>
                        </div>
                        <div class="card previous--card">
                            <div class="card__image">
                                <img src="<?php echo $weblink; ?>assets/img/2.jpeg">
                            </div>
                        </div>
                    </div>
                    <button class="cardList__btn btn btn--right">
                        <div class="icon">
                            <svg>
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </div>
                    </button>
                </div>
                <div class="infoList">
                    <div class="info__wrapper">
                        <div class="info current--info">
                            <!-- <span class="text name">Maldives</span> -->
                            <h5 class="text location">Sri Lanka</h5>
                            <p class="text description">A harmonious home to wild elephants, turtles and whales with fascinating nature adorned with waterfalls, tea plantations and golden beaches</p>
                        </div>
                        <div class="info next--info">
                            <!-- <h1 class="text name">Highlands</h1> -->
                            <h5 class="text location">Maldives</h5>
                            <p class="text description">Turquoise sea, white sand and an amazing diverse underwater world – simply - Eden on Earth</p>
                        </div>
                        <div class="info previous--info">
                            <!-- <h1 class="text name">Highlands</h1> -->
                            <h5 class="text location">Maldives+Sri Lanka</h5>
                            <p class="text description">The perfect combination of unforgettable experiences with absolute relaxation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app__bg">
            <div class="app__bg__image current--image">
                <img src="<?php echo $weblink; ?>assets/img/3.jpeg">
            </div>
            <div class="app__bg__image next--image">
                <img src="<?php echo $weblink; ?>assets/img/1.jpeg">
            </div>
            <div class="app__bg__image previous--image">
                <img src="<?php echo $weblink; ?>assets/img/2.jpeg">
            </div>
        </div>
    </div>
    <div class="loading__wrapper" style="display:none">
        <div class="loader--text">Loading...</div>
        <div class="loader">
            <span></span>
        </div>
    </div>
    <!-- end of slider -->
    <svg class="icons" style="display: none;">
        <symbol id="arrow-left" xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>
            <polyline points='328 112 184 256 328 400'
            style='fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:48px' />
        </symbol>
        <symbol id="arrow-right" xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>
            <polyline points='184 112 328 256 184 400'
            style='fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:48px' />
        </symbol>
    </svg>
    <script src="<?php echo $weblink; ?>assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="<?php echo $weblink; ?>assets/js/gsap.min.js"></script>
    <script src="<?php echo $weblink; ?>assets/js/3dslider.js"></script>
</body>
</html>