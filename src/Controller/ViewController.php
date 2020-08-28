<?php
namespace Controller;

use App\DB;

class ViewController {
    function main(){
        view("main", [
            "notices" => DB::fetchAll("SELECT * FROM notices ORDER BY id DESC LIMIT 0, 5"),
            "artworks" => DB::fetchAll("SELECT A.*, user_name FROM artworks A LEFT JOIN users U ON U.id = A.uid WHERE rm_reason IS NULL ORDER BY id DESC LIMIT 0, 4")
        ]);
    }

    /**
     * 전주한지문화축제
     */
    function intro(){
        view("intro");
    }
    function roadmap(){
        view("roadmap");
    }
    
    /**
     * 한지상품판매관
     */
    function store(){
        view("store");
    }
    function companies(){
        $companies = DB::fetchAll("SELECT U.*, IFNULL(totalPoint, 0) totalPoint
                                    FROM users U
                                    LEFT JOIN (SELECT SUM(point) totalPoint, uid FROM history GROUP BY uid) S ON S.uid = U.id
                                    WHERE U.type = 'company'
                                    ORDER BY totalPoint DESC");

        view("companies", [
            "rankers" => array_slice($companies, 0, 4),
            "companies" => pagination(
                array_slice($companies, 4)
            )
        ]);
    }

    /**
     * 한지공예대전
     */

    function entry(){
        view("entry");
    }
    function artworks(){
        global $tags, $search;
        $tags = [];
        $search = isset($_GET['search']) && json_decode($_GET['search']) ? json_decode($_GET['search']) : [];
        $artworks = array_map(function($artwork){
            global $tags;
            $artwork->hash_tags = json_decode($artwork->hash_tags);
            array_push($tags, ...$artwork->hash_tags);
            return $artwork;
        }, DB::fetchAll("SELECT DISTINCT A.*, user_name, type, IFNULL(score, 0) score
                        FROM artworks A
                        LEFT JOIN users U ON U.id = A.uid
                        LEFT JOIN (SELECT ROUND(AVG(score), 1) score, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                        WHERE rm_reason IS NULL"));

        if(count($search) > 0){
            $artworks = array_filter($artworks, function($artwork){
                global $search;
                foreach($search as $tag){
                    if(array_search($tag, $artwork->hash_tags) !== false) return true;
                }
                return false;
            });
        }

        view("artworks", [
            "tags" => $tags,
            "search" => $search,
            "artworks" => pagination($artworks),
            "myList" => !user() ? [] : DB::fetchAll("SELECT DISTINCT A.*, user_name, type, IFNULL(score, 0) score
                                        FROM artworks A
                                        LEFT JOIN users U ON U.id = A.uid
                                        LEFT JOIN (SELECT ROUND(AVG(score), 1) score, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                        WHERE A.uid = ?", [user()->id]),
            "rankers" => DB::fetchAll("SELECT DISTINCT A.*, user_name, type, IFNULL(score, 0) score
                                        FROM artworks A
                                        LEFT JOIN users U ON U.id = A.uid
                                        LEFT JOIN (SELECT ROUND(AVG(score), 1) score, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                        WHERE A.created_at >= ? AND rm_reason IS NULL
                                        LIMIT 0, 4", [ date("Y-m-d", strtotime("-7 Day")) ])
        ]);
    }
    function artwork($id){
        $artwork = DB::find("artworks", $id);
        if(!$artwork) back("대상을 찾을 수 없습니다.");
        view("artwork", [
            "artwork" => DB::fetch("SELECT A.*, user_name, user_email, U.image user_image, type, IFNULL(S.score, 0) score, M.id reviewed
                                    FROM artworks A
                                    LEFT JOIN users U ON U.id = A.uid
                                    LEFT JOIN (SELECT ROUND(AVG(score), 1) score, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                    LEFT JOIN (SELECT * FROM scores WHERE uid = ?) M ON M.aid = A.id
                                    WHERE A.id = ?", [user() && user()->id, $id])
        ]);
    }

    /**
     * 축제공지사항
     */

    function notices(){
        view("notices", [
            "notices" => pagination(
                DB::fetchAll("SELECT * FROM notices ORDER BY id DESC")
            )
        ]);
    }
    function notice($id){
        $notice = DB::find("notices", $id);
        if(!$notice) back("대상을 찾을 수 없습니다.");
        $notice->files = json_decode($notice->files);

        view("notice", [
            "notice" => $notice
        ]);
    }
    function inquires(){
        if(!user()) go("회원만 이용할 수 있습니다.");
        else if(admin()) {
            view("inquires-admin", [
                "inquires" => DB::fetchAll("SELECT I.*, A.id answered
                                            FROM inquires I
                                            LEFT JOIN answers A ON A.iid = I.id")
            ]);
        }
        else {
            view("inquires-user", [
                "inquires" => DB::fetchAll("SELECT I.*, A.id answered
                                            FROM inquires I
                                            LEFT JOIN answers A ON A.iid = I.id
                                            WHERE I.uid = ?", [user()->id])
            ]);
        }
        
    }   

    /**
     * 사용자 관리
     */

    function signIn(){
        view("sign-in");
    }      

    function signUp(){
        view("sign-up");
    }      
}