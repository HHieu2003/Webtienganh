
<?php {
    if (isset($_GET['nav'])) {
        $temp = $_GET['nav'];
    } else {
        $temp = '';
    }
}

if ($temp == 'courses') {
    include("modules/khoahoc/manage_courses.php");
} 

else if ($temp == 'students') {
    include("modules/hocvien/manage_students.php");
} 

else if ($temp == 'thongbao') {
    include("modules/thongbao/thongbao.php");
} 

else if ($temp == 'add_course') {
    include("modules/khoahoc/add_course.php");
} 
else if ($temp == 'edit_course') {

    include("modules/khoahoc/edit_course.php");
} 

else if ($temp == 'dangkykhoahoc') {
    include("modules/dangkykhoahoc.php");
} 

else if ($temp == 'lichhoc') {
    include("modules/lichhoc/lichhoc.php");
} 

else if ($temp == 'thanhtoan') {
    include("modules/lichsu_thanhtoan.php");
} 

else if ($temp == 'question') {
    include("modules/cauhoi/question.php");
} 

else if ($temp == 'ds_cauhoi') {
    include("modules/cauhoi/ds_cauhoi.php");
} 

else if ($temp == 'ds_dapan') {
    include("modules/cauhoi/ds_dapan.php");
} 
else if ($temp == 'kqhocvien') {
    include("modules/cauhoi/kqhocvien.php");
} 

else if ($temp == 'add_answer') {
    include("modules/cauhoi/add_answer.php");
} 

else {
    include("modules/home.php");
}
?>
