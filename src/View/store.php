<!-- 비주얼 -->
<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="배경 이미지" title="배경 이미지">
    </div>
    <div class="visual__content container">
        <div class="text-center">
            <div class="fx-2 text-gray">한지상품판매관</div>
            <div class="fx-7 text-white mt-1">온라인스토어</div>
        </div>
    </div>
</div>
<!-- /비주얼 -->

<!-- 검색 -->
<div class="container py-5">
    <div class="p-3 border d-flex justify-content-center align-items-center bg-light">
        <div id="search-area" data-name="search_tags" class="w-100">
            
        </div>
        <button class="icon ml-3 text-red">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>
<!-- /검색 -->

<!-- 상품 영역 -->
<div class="container py-5">
    <div class="d-between">
        <div>
            <hr>
            <div class="title">상품 리스트</div>
        </div>
        <?php if(company()):?>
            <button class="btn-filled" data-target="#entry-modal" data-toggle="modal">상품 등록</button>
        <?php endif;?>
    </div>
    <div id="store" class="row mt-4">
        
    </div>
</div>
<!-- /상품 영역 -->

<!-- 장바구니 영역 -->
<div class="container py-5 border-top">
    <hr>
    <div class="title">장바구니</div>
    <div class="t-head mt-4">
        <div class="cell-50">상품 정보</div>
        <div class="cell-20">수량</div>
        <div class="cell-20">합계 포인트</div>
        <div class="cell-10">-</div>
    </div>
    <div id="cart">

    </div>
    
    <div class="mt-4 d-between">
        <div>
            <span class="fx-n1">총 합계 포인트</span>
            <span id="total-point" class="ml-3 fx-3">0</span>
            <span class="fx-n1">p</span>
        </div>
        <form method="post" action="/insert/inventory">
            <input type="hidden" id="cartList" name="cartList">
            <input type="hidden" id="totalPoint" name="totalPoint">
            <input type="hidden" id="totalCount" name="totalCount">
            <button id="btn-buy" class="btn-filled">구매 완료</button>
        </form>
    </div>
</div>
<!-- /장바구니 영역 -->

<form id="entry-modal" class="modal fade" action="/insert/papers" method="post" enctype="multipart/form-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">상품 등록</div>
            </div>
            <div class="modal-body">    
                <div class="form-group">
                    <label>이미지</label>
                    <input type="hidden" id="base64">
                    <input type="file" id="upload" name="image" class="form-control" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label>이름</label>
                    <input type="text" name="paper_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>업체명</label>
                    <input type="text" name="company_name" class="form-control" value="<?=user()->user_name?>" readonly required>
                </div>
                <div class="form-group">
                    <label>가로 사이즈</label>
                    <input type="number" name="width_size" class="form-control" min="100" max="1000" required>
                </div>
                <div class="form-group">
                    <label>세로 사이즈</label>
                    <input type="number" name="height_size" class="form-control" min="100" max="1000" required>
                </div>
                <div class="form-group">
                    <label>포인트</label>
                    <input type="number" name="point" class="form-control" min="10" max="1000" step="10" required>
                </div>
                <div class="form-group">
                    <label>해시태그</label>
                    <div id="entry-tags" data-name="hash_tags"></div>
                </div>
            </div>    
            <div class="modal-footer">
                <button class="btn-filled">추가 완료</button>
            </div> 
        </div>
    </div>
</form>

<script src="/js/store.js"></script>
