<!-- 비주얼 -->
<div class="visual visual--sub">
    <div class="background background--black">
        <img src="/images/visual/sub.jpg" alt="배경 이미지" title="배경 이미지">
    </div>
    <div class="visual__content container">
        <div class="text-center">
            <div class="fx-2 text-gray">회원 관리</div>
            <div class="fx-7 text-white mt-1">로그인</div>
        </div>
    </div>
</div>
<!-- /비주얼 -->

<div class="container py-5">
    <hr>
    <div class="title">로그인</div>
    <form id="sign-in" class="mt-4" method="post" action="/sign-in">
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
        <div class="form-group text-right">
            <button class="btn-filled">로그인</button>
        </div>
    </form>
</div>