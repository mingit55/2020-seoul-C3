<!-- 비주얼 -->
<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="배경 이미지" title="배경 이미지">
    </div>
    <div class="visual__content container">
        <div class="text-center">
            <div class="fx-2 text-gray">한지공예대전</div>
            <div class="fx-7 text-white mt-1">참가작품</div>
        </div>
    </div>
</div>
<!-- /비주얼 -->


<!-- 검색 -->
<div class="container py-5">
    <form class="p-3 border d-flex justify-content-center align-items-center bg-light">
        <div id="search-area" data-name="search" class="w-100">
            
        </div>
        <button class="icon ml-3 text-red">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>
<!-- /검색 -->
<script>
    let module = new HashModule("#search-area", <?= json_encode($tags) ?>);
    module.tags = <?=json_encode($search)?>;
    module.render();
</script>

<div class="container py-5">
    <hr>
    <div class="title">등록한 작품</div>
    <div class="mt-3 pt-3 border-top">
        <div class="row">
            <?php foreach($myList as $artwork):?>
                <div class="col-lg-3">
                    <div class="bg-white border" onclick="location.href='/artworks/<?=$artwork->id?>'" <?= $artwork->rm_reason ? "disabled" : "" ?>>
                        <img src="/uploads/<?=$artwork->image?>" alt="" class="hx-200 fit-contain">
                        <div class="p-3 border-top">
                            <div class="fx-2"><?=enc($artwork->title)?></div>
                            <div class="mt-2">
                                <p class="fx-n2 text-muted"><?=enc($artwork->content)?></p>
                            </div>
                            <div class="mt-3 d-between">
                                <div>
                                    <span class="fx-n1"><?=enc($artwork->user_name)?></span>
                                    <span class="badge badge-primary"><?= $artwork->type == "company" ? "기업" : "일반" ?></span>
                                </div>
                                <span class="fx-n2"><?= date("Y-m-d", strtotime($artwork->created_at))?></span>
                            </div>
                            <div class="mt-2">
                                <div class="text-red">
                                    <i class="fa fa-star"></i>
                                    <?= $artwork->score ?>
                                </div>
                            </div>
                            <div class="mt-2 fx-n2 text-muted d-flex flex-wrap">
                                <?php foreach(json_decode($artwork->hash_tags) as $tag):?>
                                    <span class="m-1">#<?=$tag?></span>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <?php if($artwork->rm_reason):?>
                    <div class="bg-white border p-3 border-top-0">
                        <div class="fx-n2 text-muted">삭제 사유</div>
                        <div class="fx-1"><?=$artwork->rm_reason?></div>
                    </div>
                    <?php endif;?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<div class="container py-5">
    <hr>
    <div class="title">우수 작품</div>
    <div class="mt-3 pt-3 border-top">
        <div class="row">
            <?php foreach($rankers as $artwork):?>
                <div class="col-lg-3">
                    <div class="bg-white border" onclick="location.href='/artworks/<?=$artwork->id?>'">
                        <img src="/uploads/<?=$artwork->image?>" alt="" class="hx-200 fit-contain">
                        <div class="p-3 border-top">
                            <div>
                                <span class="fx-2"><?=enc($artwork->title)?></span>
                                <span class="badge badge-danger">우수작품</span>
                            </div>
                            <div class="mt-2">
                                <p class="fx-n2 text-muted"><?=enc($artwork->content)?></p>
                            </div>
                            <div class="mt-3 d-between">
                                <div>
                                    <span class="fx-n1"><?=enc($artwork->user_name)?></span>
                                    <span class="badge badge-primary"><?= $artwork->type == "company" ? "기업" : "일반" ?></span>
                                </div>
                                <span class="fx-n2"><?= date("Y-m-d", strtotime($artwork->created_at))?></span>
                            </div>
                            <div class="mt-2">
                                <div class="text-red">
                                    <i class="fa fa-star"></i>
                                    <?= $artwork->score ?>
                                </div>
                            </div>
                            <div class="mt-2 fx-n2 text-muted d-flex flex-wrap">
                                <?php foreach(json_decode($artwork->hash_tags) as $tag):?>
                                    <span class="m-1">#<?=$tag?></span>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<div class="container py-5">
    <hr>
    <div class="title">모든 작품</div>
    <div class="mt-3 pt-3 border-top">
        <div class="row">
            <?php foreach($artworks->data as $artwork):?>
                <div class="col-lg-3">
                    <div class="bg-white border" onclick="location.href='/artworks/<?=$artwork->id?>'">
                        <img src="/uploads/<?=$artwork->image?>" alt="" class="hx-200 fit-contain">
                        <div class="p-3 border-top">
                            <div class="fx-2"><?=enc($artwork->title)?></div>
                            <div class="mt-2">
                                <p class="fx-n2 text-muted"><?=enc($artwork->content)?></p>
                            </div>
                            <div class="mt-3 d-between">
                                <div>
                                    <span class="fx-n1"><?=enc($artwork->user_name)?></span>
                                    <span class="badge badge-primary"><?= $artwork->type == "company" ? "기업" : "일반" ?></span>
                                </div>
                                <span class="fx-n2"><?= date("Y-m-d", strtotime($artwork->created_at))?></span>
                            </div>
                            <div class="mt-2">
                                <div class="text-red">
                                    <i class="fa fa-star"></i>
                                    <?= $artwork->score ?>
                                </div>
                            </div>
                            <div class="mt-2 fx-n2 text-muted d-flex flex-wrap">
                                <?php foreach($artwork->hash_tags as $tag):?>
                                    <span class="m-1">#<?=$tag?></span>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="mt-5 d-flex justify-content-center align-items-center">
        <a href="/artworks?page=<?=$artworks->prevPage?>" class="icon bg-yellow text-white mx-1" <?=$artworks->prev ? "" : "disabled"?>>
            <i class="fa fa-angle-left mt-2"></i>
        </a>
        <?php for($i = $artworks->start; $i <= $artworks->end; $i++):?>
            <a href="/artworks?page=<?=$i?>" class="icon bg-yellow text-white mx-1"><?=$i?></a>
        <?php endfor;?>
        <a href="/artworks?page=<?=$artworks->nextPage?>" class="icon bg-yellow text-white mx-1" <?=$artworks->next ? "" : "disabled"?>>
            <i class="fa fa-angle-right mt-2"></i>
        </a>
    </div>
</div>