<meta charset="utf-8"/>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="styleclic.css"/>
    <title> </title>
    <link href="styleclic.css" rel="stylesheet">
    <script type="text/javascript">
        function me(){
            const toast = document.querySelector('#notification');
            toast.classList.add("show");
            setTimeout(()=>{
                toast.classList.remove("show");
            }, 2000);
        }
    </script>
</head>

<body onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..message perso .. '; return true;" >

<div class="box" data-tilt data-tilt-transition="false">

    <div class="innerbox">
        <h1 class="titre">© Projet PHP 2021</h1>
        <p class="text" style="background:linear-gradient(to bottom,#e318bc 49%, #1100ff)"> Bilel Medimegh </p>
        <p class="text" style="background:linear-gradient(to bottom,#ff0001 30%, #7500f3)">Eliott Rogeaux</p>
        <p class="text belbaz" style="background:linear-gradient(to bottom,#c2eec2 60%,#b9d216)">
            <a href=javascript:void(0); onclick=me()>Benjamin Elbaz</a></p>
        <p class="text" style="background:linear-gradient(to bottom,#e318bc 49%, #f1bc0e);"> Stéphane Lay</p>
        <p class="text" style="background:linear-gradient(to bottom,#f69d3c 50%, #3ea5e0)">Raphael Gruet</p>
        <a class="boutonAccueil" href="#" onclick="window.close();location.href ='../index.html'" title="fermer la fenetre">
            <!--suppress CheckImageSize -->
            <img src="/icones/accueil.png" width="35" alt=""/>
        </a>
    </div>
</div>

<div id="notification">

    <div class="container">
        <div class="slot"></div>
        <button class="test" id="div" style="visibility: hidden">reclique</button>
    </div>
    &#127881; Project Finish ! &#127881;

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.2/vanilla-tilt.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js"></script>
<script src="emojis.js"></script>

<script type="text/javascript">
    function showDiv() {
        document.getElementById("div").style.visibility="visible";
    }
    setTimeout("showDiv()", 2000);

    //div.hidden = true;
</script>
</body>
</html>