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

<div class="container py-5">
    <hr>
    <div class="title">작품 소개</div>
    <div class="pt-3 mt-3 border-top">
        <div class="row">
            <div class="col-lg-4">
                <img src="/uploads/<?= $artwork->image ?>" alt="이미지" class="fit-cover hx-250">
            </div>
            <div class="col-lg-8">
                <span class="fx-2"><?= enc($artwork->title) ?></span>
                <div class="mt-1">
                    <p class="fx-n2 text-muted"><?= enc($artwork->content) ?></p>
                </div>
                <div class="mt-2">
                    <span class="fx-n2 text-muted">제작일자</span>
                    <span class="ml-2 fx-n1"><?= $artwork->created_at ?></span>
                </div>
                <div class="mt-2">
                    <span class="fx-n2 text-muted">제작자</span>
                    <span class="ml-2 fx-n1"><?= $artwork->user_name ?></span>
                </div>
                <div class="mt-2">
                    <span class="fx-n2 text-muted">평점</span>
                    <span class="ml-2 fx-n1"><?= $artwork->score ?></span>
                </div>
                <div class="mt-2">
                    <div class="d-flex flex-wrap text-muted fx-n2">
                        <?php foreach(json_decode($artwork->hash_tags) as $tag):?>
                            <div class="m-1">#<?=$tag?></div>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php if(user() && user()->id == $artwork->uid):?>
                <div class="mt-2">
                    <button class="btn-filled" data-target="#edit-modal" data-toggle="modal">수정하기</button>
                    <a href="/delete/artworks/<?= $artwork->id ?>" class="btn-bordered">삭제하기</a>
                </div>
                <?php elseif(admin()):?>
                <div class="mt-2">
                    <button class="btn-filled" data-target="#remove-modal" data-toggle="modal">삭제하기</button>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php if(user() && !$artwork->reviewed && $artwork->uid !== user()->id):?>
    <form action="/insert/scores" method="post" class="my-3 p-3 border bg-white d-flex align-itesm-center">
        <input type="hidden" name="aid" value="<?=$artwork->id?>">
        <select name="score" class="fa form-control text-red" style="width: 150px;">
            <option class="fa" value="5"><?= str_repeat("&#xf005;", 5) ?></option>
            <option class="fa" value="4.5"><?= str_repeat("&#xf005;", 4) ?>&#xf123;</option>
            <option class="fa" value="4"><?= str_repeat("&#xf005;", 4) ?></option>
            <option class="fa" value="3.5"><?= str_repeat("&#xf005;", 3) ?>&#xf123;</option>
            <option class="fa" value="3"><?= str_repeat("&#xf005;", 3) ?></option>
            <option class="fa" value="2.5"><?= str_repeat("&#xf005;", 2) ?>&#xf123;</option>
            <option class="fa" value="2"><?= str_repeat("&#xf005;", 2) ?></option>
            <option class="fa" value="1.5"><?= str_repeat("&#xf005;", 1) ?>&#xf123;</option>
            <option class="fa" value="1"><?= str_repeat("&#xf005;", 1) ?></option>
            <option class="fa" value="0.5"><?= str_repeat("&#xf005;", 0) ?>&#xf123;</option>
        </select>
        <button class="btn-filled ml-3">확인</button>
    </form>
    <?php endif;?>
    <div class="my-3 p-3 border bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3">
                <img src="/uploads/<?= $artwork->user_image ?>" alt="이미지" class="fit-contain p-3 hx-100">
            </div>
            <div class="col-lg-9">
                <div>
                    <span class="fx-2"><?= $artwork->user_name ?></span>
                    <span class="badge badge-primary"><?= $artwork->type === "company" ? "기업" :"일반" ?></span>
                </div>
                <div class="fx-n1 text-muted"><?= $artwork->user_email ?></div>
            </div>
        </div>
    </div>
</div>


<form action="/update/artworks/<?=$artwork->id?>" method="post" id="edit-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">수정하기</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>제목</label>
                    <input type="text" class="form-control" name="title" value="<?= $artwork->title ?>" required>
                </div>
                <div class="form-group">
                    <label>내용</label>
                    <input type="text" class="form-control" name="content" value="<?= $artwork->content ?>" required>
                </div>
                <div class="form-group">
                    <label>해시태그</label>
                    <div id="edit-tags" data-name="hash_tags"></div>    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">수정 완료</button>
            </div>
        </div>
    </div>
</form>
<script>
    let module = new HashModule("#edit-tags", []);
    module.tags = <?= $artwork->hash_tags ?>;
    module.render();
</script>

<form action="/delete-admin/artworks/<?= $artwork->id ?>" method="post" id="remove-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">강제 삭제</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>삭제 사유</label>
                    <input type="text" name="rm_reason" class="form-control" requried>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">삭제 완료</button>
            </div>
        </div>
    </div>
</form>