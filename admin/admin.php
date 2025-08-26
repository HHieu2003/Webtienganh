<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</head>

<body>
    <div>
        <header>
            <?php
            include('./modules/header.php');
            ?>
        </header>

        <section class="admin-container">

            <?php
            include('./modules/menu.php');
            ?>
            <div class="admin-container2">

                <?php
                include('./modules/main.php');
                ?>
            </div>


        </section>

        <footer>
            <?php

            include('./modules/footer.php');
            ?>
        </footer>
    </div>


    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('mo_ta');
        CKEDITOR.replace('noi_dung');
    </script>

    <!-- Bootstrap và jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>