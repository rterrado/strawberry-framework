<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Strawberry Framework</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600&display=swap" rel="stylesheet"> 
        <?php scripts() ?>
        <?php stylesheets(); ?>
    </head>
    <body>
        <app xstrawberry="app">
            <?php component('Loader'); ?>
            <main id="main">
                <?php component('Welcome'); ?>
            </main>
        </app>
    </body>
</html>
