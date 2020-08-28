<!-- 비주얼 -->
<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="배경 이미지" title="배경 이미지">
    </div>
    <div class="visual__content container">
        <div class="text-center">
            <div class="fx-2 text-gray">축제공지사항</div>
            <div class="fx-7 text-white mt-1">알려드립니다</div>
        </div>
    </div>
</div>
<!-- /비주얼 -->

<div class="container py-5">
    <div class="d-between">
        <div>
            <div class="py-1">
                <span class="fx-n1 text-muted">제목</span>
                <span class="fx-4 ml-3"><?=enc($notice->title)?></span>
            </div>
            <div class="py-1">
                <span class="fx-n1 text-muted">작성일자</span>  
                <span class="fx-1 ml-3"><?=$notice->created_at?></span>
            </div>
        </div>
        <div>
            <button data-toggle="modal" data-target="#edit-modal" class="btn-filled">수정하기</button>
            <a href="/delete/notices/<?=$notice->id?>" class="btn-bordered">삭제하기</a>
        </div>
    </div>
    <div class="py-2">
        <p><?= enc($notice->content) ?></p>
    </div>
    <div class="py-4">
        <div class="row">
            <?php foreach($notice->files as $file):?>
                <?php if(array_search(fileinfo($file)->extname, [".jpg", ".png", ".gif"]) !== false):?>
                    <div class="col-lg-6">
                        <img src="<?= fileinfo($file)->file_path ?>" alt="이미지" class="w-100 fit-contain my-3">
                    </div>
                <?php endif;?>
            <?php endforeach;?>
        </div>          
    </div>
    <hr>
    <div class="title">첨부파일</div>
    <div class="py-2">
        <?php foreach($notice->files as $file):?>
            <div class="py-3">
                <div>
                    <?= fileinfo($file)->name ?>
                    <span class="badge badge-primary ml-2"><?= fileinfo($file)->size ?></span>
                </div>
                <a href="/download/<?=$file?>" class="btn btn-danger mt-2">다운로드</a>
            </div>
        <?php endforeach;?>
    </div>
</div>

<form action="/update/notices/<?=$notice->id?>" method="post" enctype="multipart/form-data" id="edit-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">공지 수정</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>제목</label>
                    <input type="text" name="title" class="form-control" value="<?=$notice->title?>" required>
                </div>
                <div class="form-group">
                    <label>내용</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" required><?=$notice->content?></textarea>
                </div>
                <div class="form-group">
                    <label>첨부 파일</label>
                    <div class="custom-file">
                        <label for="upload" class="custom-file-label"><?= count($notice->files) > 0 ? count($notice->files) . "개의 파일" : "파일을 업로드하세요" ?></label>
                        <input type="file" name="files[]" id="upload" class="custom-file-input" multiple>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">수정 완료</button>
            </div>
        </div>
    </div>
</form>