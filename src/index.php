<?php
use config\Config;
use service\FunkoService;
use services\CategoriaService;

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
    <title>Funkos</title>
</head>
<body>
<?php require_once 'header.php'?>
<?php
$config = Config::getInstance();
?>

<main class="main flow">
    <div class="container mt-3">

        <div class="row">
            <?php
            $search= $_GET['search'] ?? null;
            $funkoService = new FunkoService($config->db);
            $funkos = $funkoService->findAllWithCategoryName($search);
            ?>
            <?php foreach ($funkos as $funko): ?>
                <div class="col-md-4 mb-4">
                    <div class="card cards__card">
                        <img src="<?php echo htmlspecialchars($funko->imagen); ?>" class="card-img-top" alt="imagen">
                        <div class="card-body">
                            <h5 class="card-title "><?php echo htmlspecialchars($funko->nombre); ?></h5>
                            <span class="badge bg-primary">ID: <?php echo htmlspecialchars($funko->id); ?></span>
                            <p class="card-text">Categoria: <?php echo htmlspecialchars($funko->categoriaNombre); ?></p>
                            <p class="card-text">Precio: <?php echo htmlspecialchars($funko->precio); ?></p>
                            <p class="card-text">Cantidad: <?php echo htmlspecialchars($funko->cantidad); ?></p>
                            <a href="details.php?id=<?php echo $funko->id; ?>" class="card__cta cta">Detalles</a>
                            <?php if($_SESSION['isAdmin']): ?>
                                <a href="edit.php?id=<?php echo $funko->id; ?>" class="btn btn-warning">Editar</a>
                                <a href="cambiar-imagen.php?id=<?php echo $funko->id; ?>" class="btn btn-warning">Cambiar Imagen</a>
                                <a href="delete.php?id=<?php echo $funko->id; ?>" class="btn btn-danger">Eliminar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if($_SESSION['isAdmin']): ?>
                <div class="col-md-12 mb-4 text-center">
                    <a href="add.php" class="btn btn-success">Añadir nuevo Funko</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>





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



    .main {
        max-width: 75rem;
        padding: 3em 1.5em;
    }
    .card {
        --flow-space: 0.5em;
        --hsl: var(--hue), var(--saturation), var(--lightness);
        flex: 1 1 14rem;
        padding: 1.5em 2em;
        display: grid;
        grid-template-rows: auto auto auto 1fr;
        align-items: start;
        gap: 1.25em;
        color: #eceff1;
        background-color: #2b2b2b;
        border: 1px solid #eceff133;
        border-radius: 15px;
    }

    .card:nth-child(1) {
        --hue: 165;
        --saturation: 82.26%;
        --lightness: 51.37%;
    }

    .card:nth-child(2) {
        --hue: 291.34;
        --saturation: 95.9%;
        --lightness: 61.76%;
    }

    .card:nth-child(3) {
        --hue: 338.69;
        --saturation: 100%;
        --lightness: 48.04%;
    }



    .card__bullets li::before {
        display: inline-block;
        content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='16' title='check' fill='%23dddddd'%3E%3Cpath d='M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z' /%3E%3C/svg%3E");
        transform: translatey(0.25ch);
        margin-right: 1ch;
    }



    .flow > * + * {
        margin-top: var(--flow-space, 1.25em);
    }

    .cta {
        display: block;
        align-self: end;
        margin: 1em 0 0.5em 0;
        text-align: center;
        text-decoration: none;
        color: #fff;
        background-color: #0d0d0d;
        padding: 0.7em;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
    }

    .overlay .card {
        background-color: hsla(var(--hsl), 0.15);
        border-color: hsla(var(--hsl), 1);
        box-shadow: 0 0 0 1px inset hsl(var(--hsl));
    }

    .overlay .cta {
        display: block;
        grid-row: -1;
        width: 100%;
        background-color: hsl(var(--hsl));
        box-shadow: 0 0 0 1px hsl(var(--hsl));
    }

    :not(.overlay) > .card {
        transition: 400ms background ease;
        will-change: background;
    }

    :not(.overlay) > .card:hover {
        --lightness: 95%;
        background: hsla(var(--hsl), 0.1);
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