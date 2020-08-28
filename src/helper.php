<?php
use App\DB;
function dump(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}
function dd(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
    exit;
}

function user(){
    if(isset($_SESSION['user'])){
        $user = DB::who($_SESSION['user']->user_email);

        if(!$user){
            unset($_SESSION['user']);
            go("/", "회원 정보를 찾을 수 없습니다. 로그아웃 됩니다.");
        } else {
            $_SESSION['user'] = $user;
            return $user;
        }
    } else {
        return false;
    }
}

function company(){
    return user() && user()->type === "company" ? user() : false;
}

function admin(){
    return user() && user()->type === "admin" ? user() : false;
}

function checkEmpty(){
    foreach($_POST as $input){
        if(trim($input) === "")
            back("모든 정보를 입력해 주세요.");
    }
}

function go($url, $message = ""){
    echo "<script>";
    if($message) echo "alert('$message');";
    echo "location.href='$url';";
    echo "</script>";
    exit;
}

function back($message = ""){
    echo "<script>";
    if($message) echo "alert('$message');";
    echo "history.back();";
    echo "</script>";
    exit;
}

function json_response($data){
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function view($viewName, $data = []){
    extract($data);

    require VIEW."/header.php";
    require VIEW."/$viewName.php";
    require VIEW."/footer.php";
    exit;
}

function extname($filename){
    return substr($filename, strrpos($filename, "."));
}

function pagination($data){
    define("PAGE__COUNT", 9);
    define("PAGE__BCOUNT", 5);

    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1;

    $totalPage = ceil(count($data) / PAGE__COUNT);
    $currentBlock = ceil($page / PAGE__BCOUNT);
    
    $start = ($currentBlock - 1) * PAGE__BCOUNT + 1;

    $end = $start + PAGE__BCOUNT - 1;
    $end = $end > $totalPage ? $totalPage : $end;

    $prevPage = $start - 1;
    $prev = $prevPage >= 1;
    
    $nextPage = $end + 1;
    $next = $nextPage <= $totalPage;
    
    $data = array_slice($data, ($page - 1) * PAGE__COUNT, PAGE__COUNT);
    
    return (object)compact("data", "next", "nextPage", "prev", "prevPage", "start" ,"end");
}

function enc($output){
    return nl2br( str_replace(" ", "&nbsp;", htmlentities($output)) );
}

function fileinfo($filename){
    $local_path = UPLOAD."/$filename";
    $file_path = "/uploads/$filename";
    $name = substr($filename, strpos($filename, "-") + 1);
    $size = number_format(filesize($local_path) / 1024, 2) . "KB";
    $extname = extname($filename);

    return (object)compact("local_path", "file_path", "name", "size", "extname");
}

function upload_base64($base64){
    $temp = explode(";base64,", $base64);
    $data = base64_decode($temp[1]);   
    $filename = time() . ".jpg";
    $filepath = UPLOAD."/$filename";
    file_put_contents($filepath, $data);
    return $filename;
}