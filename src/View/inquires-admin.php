<!-- 비주얼 -->
<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="배경 이미지" title="배경 이미지">
    </div>
    <div class="visual__content container">
        <div class="text-center">
            <div class="fx-2 text-gray">축제공지사항</div>
            <div class="fx-7 text-white mt-1">1:1문의</div>
        </div>
    </div>
</div>
<!-- /비주얼 -->

<div class="container py-5">
    <div class="d-between">
        <div>
            <hr>
            <div class="title">1:1문의</div>
        </div>
    </div>
    <div class="mt-4">
        <div class="t-head">
            <div class="cell-10">상태</div>
            <div class="cell-60">제목</div>
            <div class="cell-20">문의일자</div>
            <div class="cell-10">-</div>
        </div>
        <?php foreach($inquires as $inquire):?>
            <div class="t-row" data-toggle="modal" data-target="#view-modal" data-id="<?=$inquire->id?>">
                <div class="cell-10"><?= $inquire->answered ? "완료" : "진행 중" ?></div>
                <div class="cell-60"><?= enc($inquire->title) ?></div>
                <div class="cell-20"><?= $inquire->created_at ?></div>
                <div class="cell-10">
                    <?php if(!$inquire->answered):?>
                        <button class="btn-filled" data-target="#answer-modal" data-toggle="modal" data-id="<?=$inquire->id?>">답변하기</button>
                    <?php endif;?>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<div id="view-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">문의 내역</div>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>
<script>
    $("[data-target='#view-modal']").on("click", e => {
        let id = e.currentTarget.dataset.id;
        $.getJSON("/api/inquires/" + id, res => {
            $("#view-modal .modal-body").html(`<div class="pb-3">
                                                    <div class="fx-3">${res.title}</div>
                                                    <div class="fx-n2 text-muted">
                                                        <span>${res.user_name}</span>
                                                        <span class="ml-2">${res.created_at}</span>
                                                    </div>
                                                    <div class="mt-2">
                                                        ${res.content}
                                                    </div>
                                                </div>
                                                <div class="pt-3 border-top">
                                                    <div class="fx-3">${res.answered_at ? res.answered_at : ""}</div>
                                                    <div class="fx-n2 text-muted">${res.comment ? res.comment : "문의에 대한 답변이 오지 않았습니다."}</div>
                                                </div>`);
        });
    });
</script>

<form id="answer-modal" class="modal fade" method="post" action="/insert/answers">
    <input type="hidden" id="iid" name="iid">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">답변하기</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>답변 내용</label>
                    <textarea name="comment" id="comment" cols="30" rows="10" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">작성 완료</button>
            </div>
        </div>
    </div>
</form>

<script>
    $("[data-target='#answer-modal']").on("click", e => {
        e.stopPropagation();
        $("#answer-modal").modal("show");
        $("#iid").val(e.currentTarget.dataset.id);
    });
</script>