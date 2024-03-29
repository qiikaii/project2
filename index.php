<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">

<head>
    <title>DELTA - HOME PAGE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Top 1 self-designed fashion in Singapore">
    <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body> 
    <main>
        <?php
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', 1);
        ini_set('session.cookie_httponly', 1);
        
        if (session_status() == PHP_SESSION_NONE){
            session_start();
        }        

        include 'header.inc.php';
        ?>
        <section id="carousel" class="carousel carousel-fade slide lastContent" data-ride="carousel" data-interval="2500">

            <!-- Wrapper for slides -->
            <article class="carousel-inner">
                <figure class="item active">
                    <a href="monochrome-php/monochrome.php" title="Monochrome Collection Page"><img class="img-responsive" src="carousel/slideshow1.jpg" alt="Monochrome collection"></a>
                    <figcaption class="carousel-caption">

                    </figcaption>
                </figure>
                <figure class="item">
                    <a href="celestial-php/celestial.php" title="Celestial Collection Page"><img class="img-responsive" src="carousel/slideshow2.jpg" alt="Celestial collection"></a>
                    <figcaption class="carousel-caption">

                    </figcaption>
                </figure>
            </article>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </section>

        <section id="carouselMobile" class="lastContent">
            <a href="monochrome-php/monochrome.php" title="Monochrome Collection Page"><img class="img-responsive" src="carousel/slideshow1.jpg" alt="Monochrome collection"></a>
            <a href="monochrome-php/monochrome.php" title="Monochrome Collection Page"><img class="img-responsive" src="carousel/carousel2.jpeg" alt="Monochrome collection"></a>
            <a href="celestial-php/celestial.php" title="Celestial Collection Page"><img class="img-responsive" src="carousel/slideshow2.jpg" alt="Celestial collection"></a>
            <a href="celestial-php/celestial.php" title="Celestial Collection Page"><img class="img-responsive" src="carousel/carousel1.jpeg" alt="Celestial collection"></a>
        </section>
    </main>
    <?php
    include 'footer.inc.php'
    ?>
</body>

</html>