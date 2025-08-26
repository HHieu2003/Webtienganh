
<?php
{
    if (isset($_GET['nav']))
    {
        $temp = $_GET['nav'];
    }
    else if (isset($_GET['course_detail']))
    {
        $temp = $_GET['course_detail'];
    }
    else {
        $temp = '';
        
    }
}

if ( $temp=='khoahoc')
{
    include("main/khoahoc.php");
}
else if($temp=='about'){
    include("main/about.php");
}
else if($temp=='question'){
    
    include("question/question.php");
}
else if($temp=='dapan'){
    
    include("question/dapan.php");
}
else if($temp=='question_detail'){
    
    include("question/question_detail.php");
}
else if($temp=='course_detail'){
    include("./pages/main/course_detail.php");
}
else if($temp=='huongdandangky'){
    include("./pages/main/huongdandangky.php");
}
else if($temp=='dangkykhoahoc'){
    include("./pages/main/dangkykhoahoc.php");
}
else {
    include("./pages/main/home.php");
}
?>
