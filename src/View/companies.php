<!-- 비주얼 -->
<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="배경 이미지" title="배경 이미지">
    </div>
    <div class="visual__content container">
        <div class="text-center">
            <div class="fx-2 text-gray">한지상품판매관</div>
            <div class="fx-7 text-white mt-1">한지업체</div>
        </div>
    </div>
</div>
<!-- /비주얼 -->

<div class="container py-5">
    <hr>
    <div class="title">우수 업체</div>
    <div class="pt-3 mt-3 border-top">
        <div class="row">
            <?php foreach($rankers as $ranker):?>
            <div class="col-lg-3">
                <div class="bg-white border">
                    <img src="/uploads/<?=$ranker->image?>" alt="이미지" class="fit-contain p-3 hx-200">
                    <div class="p-3">
                        <div>
                            <span class="fx-2"><?= enc($ranker->user_name) ?></span>
                            <span class="badge badge-primary"><?= $ranker->totalPoint ?>p</span>
                            <span class="badge badge-danger">우수 업체</span>
                        </div>
                        <div class="mt-2 text-muted fx-n2">
                            <?= $ranker->user_email ?>
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
    <div class="title">모든 업체</div>
    <div class="pt-3 mt-3 border-top">
        <div class="row">
            <?php foreach($companies->data as $company):?>
            <div class="col-lg-3">
                <div class="bg-white border">
                    <img src="/uploads/<?=$company->image?>" alt="이미지" class="fit-contain p-3 hx-200">
                    <div class="p-3">
                        <div>
                            <span class="fx-2"><?= enc($company->user_name) ?></span>
                            <span class="badge badge-primary"><?= $company->totalPoint ?>p</span>
                        </div>
                        <div class="mt-2 text-muted fx-n2">
                            <?= $company->user_email ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="mt-5 d-flex justify-content-center align-items-center">
        <a href="/companies?page=<?=$companies->prevPage?>" class="icon bg-yellow text-white mx-1" <?=$companies->prev ? "" : "disabled"?>>
            <i class="fa fa-angle-left mt-2"></i>
        </a>
        <?php for($i = $companies->start; $i <= $companies->end; $i++):?>
            <a href="/companies?page=<?=$i?>" class="icon bg-yellow text-white mx-1"><?=$i?></a>
        <?php endfor;?>
        <a href="/companies?page=<?=$companies->nextPage?>" class="icon bg-yellow text-white mx-1" <?=$companies->next ? "" : "disabled"?>>
            <i class="fa fa-angle-right mt-2"></i>
        </a>
    </div>
</div>