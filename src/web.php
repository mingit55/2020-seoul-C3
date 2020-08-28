<?php
use App\Router;

Router::get("/", "ViewController@main");

// 전주한지문화축제
Router::get("/intro", "ViewController@intro");
Router::get("/roadmap", "ViewController@roadmap");

// 한지상품판매관
Router::get("/companies", "ViewController@companies");
Router::get("/store", "ViewController@store");

Router::post("/insert/papers", "ActionController@insertPaper", "company");
Router::post("/insert/inventory", "ActionController@insertInventory");

Router::get("/api/papers", "ApiController@getPapers");

// 한지공예대전
Router::get("/entry", "ViewController@entry", "user");
Router::get("/artworks", "ViewController@artworks");
Router::get("/artworks/{id}", "ViewController@artwork");

Router::post("/update/inventory/{id}", "ActionController@updateInventory", "user");
Router::post("/delete/inventory/{id}", "ActionController@deleteInventory", "user");
Router::post("/insert/artworks", "ActionController@insertArtwork", "user");
Router::post("/update/artworks/{id}", "ActionController@updateArtwork", "user");
Router::get("/delete/artworks/{id}", "ActionController@deleteArtwork", "user");
Router::post("/delete-admin/artworks/{id}", "ActionController@deleteArtworkByAdmin", "admin");
Router::post("/insert/scores", "ActionController@insertScore", "user");

Router::get("/api/inventory", "ApiController@getInventory", "user");

// 축제공지사항
Router::get("/notices", "ViewController@notices");
Router::get("/notices/{id}", "ViewController@notice");
Router::get("/inquires", "ViewController@inquires");

Router::get("/download/{filename}", "ActionController@downloadFile");
Router::post("/insert/notices", "ActionController@insertNotice", "admin");
Router::post("/update/notices/{id}", "ActionController@updateNotice", "admin");
Router::get("/delete/notices/{id}", "ActionController@deleteNotice", "admin");
Router::post("/insert/inquires", "ActionController@insertInquire", "user");
Router::post("/insert/answers", "ActionController@insertAnswer", "admin");

Router::get("/api/inquires/{id}", "ApiController@getInquire");

// 회원관리
Router::get("/sign-up", "ViewController@signUp");
Router::get("/sign-in", "ViewController@signIn");

Router::post("/sign-up", "ActionController@signUp");
Router::post("/sign-in", "ActionController@signIn");
Router::get("/logout", "ActionController@logout");
Router::get("/init/admin", "ActionController@initAdmin");

Router::get("/api/users/{user_email}", "ApiController@getUser");


Router::start();