<?php

use config\Config;
use service\FunkoService;
use service\CategoriaService;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/service/FunkoService.php';
require_once __DIR__ . '/service/CategoriaService.php';
require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/models/Funkos.php';
require_once __DIR__ . '/service/SessionService.php';

$session = $sessionService = \service\SessionService::getInstance();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
          rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet"/>
    <title>Categoria-Funkos</title>
</head>
<body>
<?php require_once 'header.php'?>
<?php
$config = Config::getInstance();
?>
<?php
require_once 'service/CategoriaService.php';
$categoriaService = new CategoriaService($config->db);
$id = $_GET['id'];
$funkos = $categoriaService->findFunkosByCategoria($id);
?>

<div class="container mt-5">
    <h1 class="mb-4">Funkos de la categoría</h1>
    <ul class="list-group">
        <?php foreach ($funkos as $funko): ?>
            <li class="list-group-item text-white">
                <?php echo $funko->nombre; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"
></script>
<style>
    @import url("https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700;800;900&display=swap");

    *,
    *::after,
    *::before {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html,
    body {
        height: 100%;
        min-height: 100vh;
    }

    body {
        font-family: "League Spartan", system-ui, sans-serif;
        font-size: 1.1rem;
        line-height: 1.2;
        background-color: #212121;
        color: #ddd;
    }
    li{
        color: #dddddd;
    }



    .card__bullets li::before {
        display: inline-block;
        content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='16' title='check' fill='%23dddddd'%3E%3Cpath d='M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z' /%3E%3C/svg%3E");
        transform: translatey(0.25ch);
        margin-right: 1ch;
    }





</style>

<script>
    console.clear();

    const cardsContainer = document.querySelector(".cards");
    const cardsContainerInner = document.querySelector(".cards__inner");
    const cards = Array.from(document.querySelectorAll(".card"));
    const overlay = document.querySelector(".overlay");

    const applyOverlayMask = (e) => {
        const overlayEl = e.currentTarget;
        const x = e.pageX - cardsContainer.offsetLeft;
        const y = e.pageY - cardsContainer.offsetTop;

        overlayEl.style = `--opacity: 1; --x: ${x}px; --y:${y}px;`;
    };

    const createOverlayCta = (overlayCard, ctaEl) => {
        const overlayCta = document.createElement("div");
        overlayCta.classList.add("cta");
        overlayCta.textContent = ctaEl.textContent;
        overlayCta.setAttribute("aria-hidden", true);
        overlayCard.append(overlayCta);
    };

    const observer = new ResizeObserver((entries) => {
        entries.forEach((entry) => {
            const cardIndex = cards.indexOf(entry.target);
            let width = entry.borderBoxSize[0].inlineSize;
            let height = entry.borderBoxSize[0].blockSize;

            if (cardIndex >= 0) {
                overlay.children[cardIndex].style.width = `${width}px`;
                overlay.children[cardIndex].style.height = `${height}px`;
            }
        });
    });

    const initOverlayCard = (cardEl) => {
        const overlayCard = document.createElement("div");
        overlayCard.classList.add("card");
        createOverlayCta(overlayCard, cardEl.lastElementChild);
        overlay.append(overlayCard);
        observer.observe(cardEl);
    };

    cards.forEach(initOverlayCard);
    document.body.addEventListener("pointermove", applyOverlayMask);

</script>
</body>
</html>


