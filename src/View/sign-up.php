<!-- 비주얼 -->
<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="배경 이미지" title="배경 이미지">
    </div>
    <div class="visual__content container">
        <div class="text-center">
            <div class="fx-2 text-gray">회원 관리</div>
            <div class="fx-7 text-white mt-1">회원가입</div>
        </div>
    </div>
</div>
<!-- /비주얼 -->

<div class="container py-5">
    <hr>
    <div class="title">회원가입</div>
    <form id="sign-up" class="mt-4" action="/sign-up" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>이메일</label>
            <input type="text" class="form-control" id="user_email" name="user_email">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label>비밀번호</label>
            <input type="password" class="form-control" id="password" name="password">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label>비밀번호 확인</label>
            <input type="password" class="form-control" id="passconf" name="passconf">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label>이름</label>
            <input type="text" class="form-control" id="user_name" name="user_name">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label>프로필 사진</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label>회원 유형</label>
            <select id="type" class="form-control" name="type">
                <option value="normal">일반 회원</option>
                <option value="company">기업 회원</option>
            </select>
        </div>
        <div class="form-group text-right">
            <button class="btn-filled">회원가입</button>
        </div>
    </form>
</div>

<script src="/js/sign-up.js"></script>