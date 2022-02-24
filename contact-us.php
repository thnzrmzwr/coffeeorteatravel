<?php include 'partials/templates.php'; ?>
<?php ncheader(5, $menu, $weblink); ?>

<div class="container-fluid bg-coffee px-0">
    <div class="py-13 bg-theme-color-7 ps-xl-5 ps-lg-0">
        <h2 class="text-light px-3 px-sm-5 h1 fw-bold">CONTACT US</h2>
        <p class="text-light px-3 px-sm-5"><?php $contact=PageDetails($db_elegantp,42);
        $para = explode("|", $contact['PageTextNoneHTML']);
        echo $para[0];?></p>
    </div>
</div>
<div class="container-fluid bg-theme-color">
    <div class="row" id="visit">
        <iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Priyadarsanarama%20Road,%20Dehiwala&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <div class="row py-4 px-sm-3 px-md-5" id="contact">
        <div class="col-md-6 p-sm-3 p-md-4 p-lg-5 p-4 text-ncs-light">
            <p class="h4 text-light">Welcome</p>
            <p class="py-3"><?= $ReservationsADDRESS; ?></p>
            <p class="text-primary"><i class="far fa-envelope pe-2"></i><a href="mailto:<?= $SignatureDefaultEmail; ?>"><?= $SignatureDefaultEmail; ?></a></p>
            <p class="text-primary"><i class="fal fa-phone-alt pe-2"></i><a href="tel:<?php echo $HeadOfficePHONE; ?>"><?= $HeadOfficePHONE; ?></a></p>
            <p class="text-primary"><i class="fal fa-phone-alt pe-2"></i><a href="tel:<?= $ReservationsHOTLINE; ?>"><?= $ReservationsHOTLINE; ?></a></p>
            <p class="text-primary"><i class="fal fa-phone-alt pe-2"></i><a href="tel:<?= $ReservationsPHONE; ?>"><?= $ReservationsPHONE; ?></a></p>
            <p class="py-2"><?= $para[1]; ?></p>
            <a href="<?= $TWITTERPAGE; ?>" class="btn bg-light rounded text-primary m-1"><i class="fab fa-instagram"></i>Instagram</a>
            <a href="<?= $FACEBOOKPAGE; ?>" class="btn bg-light rounded text-primary m-1"><i class="fab fa-facebook-square pe-2"></i>Facebook</a>
        </div>
        <div class="col-md-6 p-sm-3 p-md-4 p-lg-5 pt-sm-5 p-4">
            <p class="h4 text-light">Contact Form</p>
            <form action="<?php  ?>" class="form-control-dark" method="post">
                <div class="row my-3">
                    <div class="col">
                        <label for="name" class="form-label text-ncs-light">Name</label>
                        <input type="text" class="form-control" name="name" aria-label="First name">
                    </div>
                    <div class="col">
                        <label for="phone" class="form-label text-ncs-light">Phone</label>
                        <input type="tel" class="form-control" name="phone" aria-label="phone">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-ncs-light">Email</label>
                    <input type="email" name="email" class="form-control" aria-label="email">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label text-ncs-light">Message</label>
                    <textarea class="form-control" name="message" rows="3"></textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Submit Form</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php ncfooter(5, $menu, $weblink); ?>

<!--google map api -->
<script src="<?= $weblink; ?>assets/js/google-places.js "></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=&#91;AIzaSyDdgUIix9A5bQIRrL_EWSK03DBibh2TBgA&#93;"></script>
    <script>
    jQuery(document).ready(function() {
        $("#google-reviews").googlePlaces({
            placeId: '[ChIJeX-SZjpb4joRx_zY53cmhug]',
            render: ['reviews'],
            min_rating: 5,
            max_rows: 0
        });
    });
    </script>