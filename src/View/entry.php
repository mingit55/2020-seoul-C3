<!-- 비주얼 -->
<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="배경 이미지" title="배경 이미지">
    </div>
    <div class="visual__content container">
        <div class="text-center">
            <div class="fx-2 text-gray">한지공예대전</div>
            <div class="fx-7 text-white mt-1">출품신청</div>
        </div>
    </div>
</div>
<!-- /비주얼 -->

<div class="container py-5">
    <div class="workspace">
        <canvas width="1150" height="800"></canvas>
        <div class="tool">
            <div class="tool__item" data-role="select" title="선택"><i class="fa fa-mouse-pointer"></i></div>
            <div class="tool__item" data-role="spin" title="회전"><i class="fa fa-repeat"></i></div>
            <div class="tool__item" data-role="cut" title="자르기"><i class="fa fa-cut"></i></div>
            <div class="tool__item" data-role="glue" title="붙이기"><i class="fa fa-object-ungroup"></i></div>
            <div class="tool__item" data-target="#list-modal" data-toggle="modal" title="추가"><i class="fa fa-folder"></i></div>
            <div class="tool__item remove-artwork" title="삭제"><i class="fa fa-trash"></i></div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-5">
            <form id="entry" method="post" action="/insert/artworks">
                <input type="hidden" id="image" name="image">
                <div class="form-group">
                    <label>제목</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>내용</label>
                    <input type="text" name="content" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>해시 태그</label>
                    <div id="entry-tags" data-name="hash_tags"></div>
                </div>
                <div class="form-group text-right">
                    <button class="btn-filled">출품하기</button>
                </div>
            </form>
        </div>
        <div class="col-lg-7">
            <div class="helper">
                <input type="radio" name="tabs" id="focus-select" hidden checked>
                <input type="radio" name="tabs" id="focus-spin" hidden>
                <input type="radio" name="tabs" id="focus-cut" hidden>
                <input type="radio" name="tabs" id="focus-glue" hidden>
                <div class="helper-search">
                    <input type="text">
                    <button class="icon btn-search"><i class="fa fa-search"></i></button>
                    <button class="icon btn-prev"><i class="fa fa-angle-left"></i></button>
                    <button class="icon btn-next"><i class="fa fa-angle-right"></i></button>
                    <p class="search-comment"></p>
                </div>
                <div class="helper-header">
                    <label for="focus-select" class="tab tab--head select">선택</label>
                    <label for="focus-spin" class="tab tab--head spin">회전</label>
                    <label for="focus-cut" class="tab tab--head cut">자르기</label>
                    <label for="focus-glue" class="tab tab--head glue">붙이기</label>
                </div>
                <div class="helper-body">
                    <div class="tab tab--body select" data-target="select">선택 도구는 가장 기본적인 도구로써, 작업 영역 내의 한지를 선택할 수 있게 합니다. 
                        마우스 클릭으로 한지를 활성화하여 이동시킬 수 있으며, 선택된 한지는 삭제 버튼으로 삭제시킬 수 있습니다.</div>
                    <div class="tab tab--body spin" data-target="spin">회전 도구는 작업 영역 내의 한지를 회전할 수 있는 도구입니다. 
                        마우스 더블 클릭으로 회전하고자 하는 한지를 선택하면, 좌우로 마우스를 끌어당겨 회전시킬 수 있습니다. 
                        회전한 뒤에는 우 클릭의 콘텍스트 메뉴로 '확인'을 눌러 한지의 회전 상태를 작업 영역에 반영할 수 있습니다.</div>
                    <div class="tab tab--body cut" data-target="cut">자르기 도구는 작업 영역 내의 한지를 자를 수 있는 도구입니다. 
                        마우스 더블 클릭으로 자르고자 하는 한지를 선택하면 마우스를 움직임으로써 자르고자 하는 궤적을 그릴 수 있습니다. 
                        궤적을 그린 뒤에는 우 클릭의 콘텍스트 메뉴로 '자르기'를 눌러 그려진 궤적에 따라 한지를 자를 수 있습니다.</div>
                    <div class="tab tab--body glue" data-target="glue">붙이기 도구는 작업 영역 내의 한지들을 붙일 수 있는 도구입니다.
                        마우스 더블 클릭으로 붙이고자 하는 한지를 선택하면 처음 선택한 한지와 근접한 한지들을 선택할 수 있습니다. 
                        붙일 한지를 모두 선택한 뒤에는 우 클릭의 콘텍스트 메뉴로 '붙이기'를 눌러 선택한 한지를 붙일 수 있습니다.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="list-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-5">추가하기</div>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/entry/Tool.js"></script>
<script src="/js/entry/Select.js"></script>
<script src="/js/entry/Spin.js"></script>
<script src="/js/entry/Cut.js"></script>
<script src="/js/entry/Glue.js"></script>
<script src="/js/entry/Source.js"></script>
<script src="/js/entry/Artwork.js"></script>
<script src="/js/entry/Workspace.js"></script>
<script src="/js/entry.js"></script>