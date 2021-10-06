<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <title> Galeria </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <meta name="description" content="Możliwość rezerwacji sal na spotkania" />
    <meta name="keywords" content="rezerwacja, sale, konferencja" />
    <meta name="author" content="Wiktoria Nowak, Hanna Filipowska" />
    <meta name="viewport" content="widh=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="style-v2.css" />

</head>
<body>
    <?php echo require_once("navbar-alt.php")?> 

        <section class="wall">
            <section>
                <span id="big-text">Nasza Galeria</span>
                <div class="row">
                    <div class=" col-md-4">
                        <figure class="photos-gallery">
                            <img src="images/g.szkolenie.jpg" alt="Zdjęcie przykładowego szkolenia">
                        </figure>
                    </div>

                    <div class=" col-md-4">
                        <figure class="photos-gallery">
                            <img src="images/s1.bankietowa.jpg" alt="Zdjęcie sali bankietowej">
                        </figure>
                    </div>
    
    
                    <div class="col-md-4">
                        <figure class="photos-gallery">
                            <img src="images/s2.basenowa.jpg" alt="Zdjęcie sali basenowej">
                        </figure>
                    </div>
    
    
                    <div class="col-md-4">
                        <figure class="photos-gallery">
                        <img src="images/s3.lustrzana.jpg" alt="Zdjęcie sali lustrzanej">
                        </figure>
                    </div>

                    
                    <div class=" col-md-4">
                        <figure class="photos-gallery">
                            <img src="images/g.popcorn.jpg" alt="Zdjęcie smacznie wyglądającego popcornu">
                        </figure>
                    </div>

                    <div class="col-md-4">
                        <figure class="photos-gallery">
                            <img src="images/s4.ciemna.jpg" alt="Zdjęcie sali ciemnej">
                        </figure>
                    </div>
    
    
                    <div class="col-md-4">
                        <figure class="photos-gallery">
                        <img src="images/s5.kameralna.jpg" alt="Zdjęcie sali kameralnej">
                        </figure>
                    </div>
    
    
                    <div class="col-md-4">
                        <figure class="photos-gallery">
                            <img src="images/s6.szkoleniowa.jpg" alt="Zdjęcie sali szkoleniowej">
                        </figure>
                    </div>
    

                    <div class="col-md-4">
                        <figure class="photos-gallery">
                            <img src="images/smile.jpg" alt="Zdjęcie uśmiechniętej buźki">
                        </figure>
                    </div>

                </div>
            </section>
        </section>
</body>
</html>