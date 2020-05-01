<?php header("HTTP/1.0 404 Not Found"); ?>
<!DOCTYPE html>
<html lang="en">
<body>
    <head>
        <title>Custom_MVC_Framework</title>
    </head>

    <h1 align="center">404 Not Found</h1></br>
    <h2 align="center">The page "<?= $exception->getRoute() ?>" was not found</h2>
</body>
</html>
