<?php
namespace Controller;

use App\DB;

class ActionController {
    // 회원가입
    function signUp(){
        checkEmpty();
        extract($_POST);

        $image = $_FILES['image'];
        $filename = time() . "-" . $image['name'];
        move_uploaded_file($image['tmp_name'], UPLOAD."/$filename" );

        DB::query("INSERT INTO users (user_email, password, user_name, image, type) VALUES (?, ?, ?, ?, ?)", [$user_email, hash("sha256", $password), $user_name, $filename, $type]);

        go("/", "회원가입 되었습니다.");
    }
    // 로그인
    function signIn(){
        checkEmpty();
        extract($_POST);

        $user = DB::who($user_email);
        if(!$user) back("아이디와 일치하는 회원이 존재하지 않습니다.");
        else if($user->password !== hash("sha256", $password)) back("비밀번호가 일치하지 않습니다.");

        $_SESSION['user'] = $user;

        go("/", "로그인 되었습니다.");
    }
    // 로그아웃
    function logout(){
        unset($_SESSION['user']);
        go("/", "로그아웃 되었습니다.");
    }
    // 관리자 생성
    function initAdmin(){
        DB::query("INSERT INTO users(user_email, password, user_name, type) VALUES (?, ?, ?, ?)" ,[
            "admin",
            hash("sha256", "1234"),
            "관리자",
            "admin"
        ]);
    }

    // 공지사항 추가
    function insertNotice(){
        checkEmpty();
        extract($_POST);

        $files = $_FILES['files'];
        $fileLength = count($files['name']);
        $filenames = [];

        if(mb_strlen($title) > 50) back("제목은 50자 이하여야 합니다.");


        for($i = 0; $i < $fileLength; $i++){
            if($files['name'][$i] === "") continue;
            $name = $files['name'][$i];
            $filename = time() . "-" . $name;
            $tmp_name = $files['tmp_name'][$i];
            $size = $files['size'][$i];

            if($size > 1024 * 1024 * 10) back("파일은 10MB 이하만 업로드 가능합니다.");
            if($i > 3) back("파일은 4개까지만 업로드 가능합니다.");

            move_uploaded_file($tmp_name, UPLOAD."/$filename");

            $filenames[] = $filename;
        }

        
        DB::query("INSERT INTO notices(title, content, files) VALUES (?, ?, ?)", [$title, $content, json_encode($filenames)]);

        go("/notices", "공지사항을 작성했습니다.");
    }

    // 공지사항 수정
    function updateNotice($id){
        $notice = DB::find("notices", $id);
        if(!$notice) back("대상을 찾을 수 없습니다.");

        checkEmpty();
        extract($_POST);

        $files = $_FILES['files'];
        $fileLength = count($files['name']);
        $filenames = json_decode($notice->files);

        if(mb_strlen($title) > 50) back("제목은 50자 이하여야 합니다.");

        if($fileLength >= 1 && $files['name'][0] !== ""){
            $filenames = [];
            for($i = 0; $i < $fileLength; $i++){
                if($files['name'][$i] === "") continue;
                $name = $files['name'][$i];
                $filename = time() . "-" . $name;
                $tmp_name = $files['tmp_name'][$i];
                $size = $files['size'][$i];
    
                if($size > 1024 * 1024 * 10) back("파일은 10MB 이하만 업로드 가능합니다.");
                if($i > 3) back("파일은 4개까지만 업로드 가능합니다.");
    
                move_uploaded_file($tmp_name, UPLOAD."/$filename");
    
                $filenames[] = $filename;
            }
        }

        DB::query("UPDATE notices SET title = ?, content = ?, files = ? WHERE id = ?", [$title, $content, json_encode($filenames), $id]);

        go("/notices/$id", "수정되었습니다.");
    }

    // 공지사항 삭제
    function deleteNotice($id){
        $notice = DB::find("notices", $id);
        if(!$notice) back("대상을 찾을 수 없습니다.");

        DB::query("DELETE FROM notices WHERE id = ?", [$id]);
        go("/notices", "삭제되었습니다.");
    }

    // 파일 다운로드
    function downloadFile($filename){
        $file = fileinfo($filename);
        header("Content-Disposition: attachement; filename={$file->name}");
        readfile($file->local_path);
    }

    // 문의하기 추가
    function insertInquire(){
        checkEmpty();
        extract($_POST);

        DB::query("INSERT INTO inquires(uid, title, content) VALUES (?, ?, ?)", [user()->id, $title, $content]);

        go("/inquires", "작성되었습니다.");
    }

    // 답변 추가
    function insertAnswer(){
        checkEmpty();
        extract($_POST);
        
        $inquire = DB::find("inquires", $iid);
        if(!$inquire) back("대상을 찾을 수 없습니다.");

        DB::query("INSERT INTO answers(iid, comment) VALUES (?, ?)", [$inquire->id, $comment]);
        go("/inquires", "답변이 추가되었습니다.");
    }

    // 한지 추가
    function insertPaper(){
        checkEmpty();
        extract($_POST);

        $image = $_FILES['image'];
        $filename = time() . "-" . $image['name'];
        move_uploaded_file($image['tmp_name'], UPLOAD."/".$filename);

        DB::query("INSERT INTO papers(paper_name, uid, width_size, height_size, point, hash_tags, image) VALUES (?, ?, ?, ?, ?, ?, ?)", [$paper_name, user()->id, $width_size, $height_size, $point, $hash_tags, "/uploads/$filename"]);


        $pid = DB::lastInsertId();
        DB::query("INSERT INTO inventory(uid, pid, count) VALUES (?, ?, ?)", [user()->id, $pid, -1]);
        
        go("/store", "등록되었습니다.");
    }

    // 인벤토리 추가
    function insertInventory(){
        checkEmpty();
        extract($_POST);

        $cartList = json_decode($cartList);

        if(user()->point < $totalPoint) back("포인트가 부족하여 구매할 수 없습니다.");

        foreach($cartList as $cartItem){
            $paper = DB::find("papers", $cartItem->id);

            if($paper->uid === user()->id) continue;
            
            $exist = DB::fetch("SELECT * FROM inventory WHERE pid = ? AND uid = ?", [$paper->id, user()->id]);
            if($exist){
                DB::query("UPDATE inventory SET count = count + ? WHERE uid = ? AND pid = ?", [$cartItem->buyCount, user()->id, $paper->id]);
            } else {
                DB::query("INSERT INTO inventory (uid, pid, count) VALUES (?, ?, ?)", [user()->id, $paper->id, $cartItem->buyCount]);
            }

            DB::query("UPDATE users SET point = point - ? WHERE id = ?", [$cartItem->buyCount * $paper->point, user()->id]);
            DB::query("UPDATE users SET point = point + ? WHERE id = ?", [$cartItem->buyCount * $paper->point, $paper->uid]);
            DB::query("INSERT INTO history(uid, point) VALUES (?, ?)", [user()->id, $paper->point]);
        }

        go("/store", "총 {$totalCount}개의 한지가 구매되었습니다.");
    }

    // 인벤토리 수정
    function updateInventory($id){
        $inventory = DB::find("inventory", $id);
        if(!$inventory || $inventory->uid !== user()->id) return;

        checkEmpty();
        extract($_POST);
        
        DB::query("UPDATE inventory SET count = ? WHERE id = ?", [$count, $id]);
    }

    // 인벤토리 삭제
    function deleteInventory($id){
        $inventory = DB::find("inventory", $id);
        if(!$inventory || $inventory->uid !== user()->id) return;

        DB::query("DELETE FROM inventory WHERE id = ?", [$id]);
    }

    // 작품 추가
    function insertArtwork(){
        checkEmpty();
        extract($_POST);

        $filename = upload_base64($image);
        DB::query("INSERT INTO artworks(uid, title, content, image, hash_tags) VALUES (?, ?, ?, ?, ?)", [user()->id, $title, $content, $filename, $hash_tags]);

        go("/entry", "작품을 추가했습니다.");
    }
    function updateArtwork($id){
        $artwork = DB::find("artworks", $id);
        if(!$artwork || $artwork->uid !== user()->id) back("대상을 찾을 수 없습니다.");

        checkEmpty();
        extract($_POST);

        DB::query("UPDATE artworks SET title = ?, content = ?, hash_tags = ? WHERE id = ?", [$title, $content, $hash_tags, $id]);

        go("/artworks/$id", "수정되었습니다.");
    }
    function deleteArtwork($id){
        $artwork = DB::find("artworks", $id);
        if(!$artwork || $artwork->uid !== user()->id) back("대상을 찾을 수 없습니다.");

        DB::query("DELETE FROM artworks WHERE id = ?", [$id]);
        go("/artworks", "삭제되었습니다.");
    }
    function deleteArtworkByAdmin($id){
        $artwork = DB::find("artworks", $id);
        if(!$artwork) back("대상을 찾을 수 없습니다.");

        checkEmpty();
        extract($_POST);

        DB::query("UPDATE artworks SET rm_reason = ? WHERE id = ?", [$rm_reason, $id]);
        go("/artworks", "삭제되었습니다.");
    }
    function insertScore(){
        checkEmpty();
        extract($_POST);
        $artwork = DB::find("artworks", $aid);
        if(!$artwork) back("대상을 찾을 수 없습니다.");      

        DB::query("INSERT INTO scores(uid, aid, score) VALUES (?, ?, ?)", [user()->id, $artwork->id, $score]);

        go("/artworks/$aid");
    }
};