<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

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
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include 'header.php';

    ?>


    <section id="carousel" class="carousel carousel-fade slide lastContent" data-ride="carousel" data-interval="2500">


        <!-- Wrapper for slides -->
        <article class="carousel-inner" role="listbox">
            <figure class="item active">
                <a href="monochrome-html/monochrome.html"><img class="img-responsive" src="carousel/slideshow1.jpg" alt="..."></a>
                <figcaption class="carousel-caption">

                </figcaption>
            </figure>
            <figure class="item">
                <a href="celestial-html/celestial.html"><img class="img-responsive" src="carousel/slideshow2.jpg" alt="..."></a>
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
        <a href="monochrome-html/monochrome.html"><img class="img-responsive" src="carousel/slideshow1.jpg" alt="..."></a>
        <a href="monochrome-html/monochrome.html"><img class="img-responsive" src="carousel/carousel2.jpeg" alt="..."></a>
        <a href="celestial-html/celestial.html"><img class="img-responsive" src="carousel/slideshow2.jpg" alt="..."></a>
        <a href="celestial-html/celestial.html"><img class="img-responsive" src="carousel/carousel1.jpeg" alt="..."></a>
    </section>

    <?php
    include 'footer.php'
    ?>
</body>

</html>