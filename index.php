<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English</title>
    <link rel="stylesheet" href="./css/icon/fontawesome-free-6.4.2-web/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS và jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./pages/main.css">
</head>

<body>

    <?php
    include('./config/config.php');

    session_start();
    ?>
    <div class="wrapper">
        <header>
            <?php
            include('./pages/header.php');
            ?>
        </header>

        <section>
            <?php
            include('./pages/main.php');
            ?>
        </section>
        <footer>
            <?php
            include('./pages/footer.php');
            ?>
        </footer>
    </div>

</body>

</html>