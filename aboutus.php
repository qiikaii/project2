<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DELTA - ABOUT US</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Top 1 self-designed fashion in Singapore">
        <meta name="keyword" content="fashion, designer platform, Singapore, self-designed clothes, self-designed fashion, trending fashion, trending design, trending in Singapore, Singapore fashion, Singapore home design fashion, online shopping fashion">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.css"> 
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/aboutus.css">
    </head>

    <main>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        include 'header.inc.php';
        ?>    

        <!-- TITLE: ABOUT US -->
        <section class="container-fluid">
            <article class="row">
                <section class="col-sm-12">
                    <h1>ABOUT US</h1>
                </section>
            </article>
        </section>

        <!-- PHOTOS -->
        <section class="photocon">   
            <article class="container-fluid">
                <section class="row" id="rowphoto">
                    <article class="col-sm-3">
                        <figure>
                            <img src="face/andy.png" class="abtusimg" alt="Andy" title="Andy">
                            <figcaption><p class="abtusname">ANDY</p></figcaption>
                        </figure>
                    </article>
                    <article class="col-sm-3">
                        <figure><img src="face/jks.png" class="abtusimg" alt="Jackson" title="Jackson">
                            <figcaption><p class="abtusname">JACKSON</p></figcaption>
                        </figure>
                    </article>
                    <article class="col-sm-3">
                        <figure><img src="face/kim.png" class="abtusimg" alt="Kimberly" title="Kimberly">
                            <figcaption><p class="abtusname">KIMBERLY</p></figcaption>
                        </figure>
                    </article>
                    <article class="col-sm-3">
                        <figure><img src="face/keith.png" class="abtusimg" alt="Keith Qi Kai" title="Keith Qi Kai">
                            <figcaption><p class="abtusname">KEITH</p></figcaption>
                        </figure>
                    </article>
                </section>
            </article>
        </section>

        <!-- Huge Text-->
        <section class="hugetextcon">
            <article class="container-fluid">
                <section class="row">
                    <article class="col-sm-12">
                        <h1> MISSION </h1>
                        <p>We aim to provide a platform for aspiring artists or designers to spread their content through the sales of apparels. </p>
                        <h1> ABOUT US </h1>
                        <p>Hailing from Singapore, Delta was founded in 2019 by a group of friends, Andy, Jackson, Kimberly and Qi Kai.</p> 
                        <p>Their common passion for rising artists led to the creation of an apparel brand. </p>
                        <p>Delta looks for individualistic designs that speaks to a myriad of audiences - creating apparel for all ages.</p> 
                        <p>Launched in February 2019, Delta had on board their first artist, Nikita Laurens.</p>
                        <p>Having created collections Celestial and Monochrome, Laurens is a 21 year old illustrator who specialises in line work.</p>
                        <p>The founders of Delta wants to keep the environment intact, all apparels are through sustainable means.</p>
                        <p>If you are looking for a platform to share your work, feel free to contact us.</p>
                    </article>
                </section>
            </article>
        </section>

        <section class="container-fluid">
            <article class="row">
                <section class="col-sm-6">
                    <h1 id="abtusloc">OUR LOCATION</h1>
                    <article class="container" id="mapcontainer">
                        <p>Campus address:</p>
                        <p>Nanyang Polytechnic</p>
                        <p>172A Ang Mo Kio Ave 8, Singapore 567739</p>
                        <p>(beside Blk Q of NYP campus)</p>
                        <p id="google"></p>
                        <img src="googlemap.PNG" id="gmap" alt="">
                    </article>
                </section>
                <section class="col-sm-6">
                    <h1>CONTACT US</h1>
                    <p id="telephone">( + 6 5 ) 8 1 2 3 4 5 6 7</p>
                    <h1>EMAIL US</h1>
                    <p id="email">D E L T A @ M A I L E R . C O M</p>
                </section>
            </article>
        </section>
    </main>
    <?php include 'footer.inc.php'; ?>  
</html>
