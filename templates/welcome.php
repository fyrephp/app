<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= escape($title); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/elusivecodes/frostui@latest/dist/frost-ui.min.css" />
</head>

<body class="d-flex min-vh-100 justify-content-center align-items-center text-bg-danger bg-gradient py-5">
    <div class="container w-100">
        <div class="text-center">
            <h1 class="display-1 fw-bold mb-5">
                <span style="font-size: 150%;"><?= escape($title); ?></span>
            </h1>
            <p class="display-3">Welcome to the future.</p>
        </div>
    </div>
</body>

</html>
