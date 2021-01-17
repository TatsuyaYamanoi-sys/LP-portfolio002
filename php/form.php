<?php 

    session_start();
// クリックジャッキング対策
    header('X-FRAME-OPTIONS: DENY');
// スーパーグローバル変数 phpは9種類
// 連想配列で返る
if(!empty($_POST)){
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
}

/* $pageFlagでsubmitを監視、押されたbtnによってそれぞれの画面に遷移 */
// 入力、確認、完了 input.php, confirm.php, thanks.php
$pageFlag = 0;
if(!empty($_POST['btn_confirm'])){
    $pageFlag = 1;
}
if(!empty($_POST['btn_submit'])){
    $pageFlag = 2;
}

function h($str){
    htmlspecialchars($str, ENT_QUOTES,'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/modules/reset.css">
    <link rel="stylesheet" href="../style/include/form.css">
    <title>お問い合わせ</title>
</head>
<body>

    <header class="page-header">
        <div class="page-header__inner">
            <div class="page-header__logo">
                <a class="logo" href="../index.html">
                    <img src="../img/logo/y's-teck_logo_wh2.svg" alt="logo-header">
                </a>
            </div>
            <!-- <nav class="page-header__nav">
                <ul class="page-header__nav-ul">
                    <li><a href="#about">ABOUT</a></li>
                    <li><a href="#feature">FEATURE</a></li>
                    <li><a href="#profile">PROFILE</a></li>
                    <li><a class="btn-icon_mail" href="#contact">CONTACT</a></li>
                </ul>
            </nav>
            <button class="page-header__mobile-menu-btn">
                <span></span>
                <span></span>
                <span></span>
            </button> -->
        </div>
    </header>    <!-- 後で共通コンポーネント化 -->
    <?php if($pageFlag === 0 ) : ?>
        <?php 
            if(!isset($_SESSION['csrfToken'])) {
                $csrfToken = bin2hex(random_bytes(32));
                $_SESSION['csrfToken'] = $csrfToken;
            }
            $token = $_SESSION['csrfToken'];
        ?>
        <form method="POST" action="form.php">
            <div class="grid">
                <label class="grid_left" for="your_name">氏名</label>
                <input type="text" name="your_name" value=
                "<?php if(!empty($_POST['your_name'])){echo h($_POST['your_name']); } ?>">
                <br>
                <label class="grid_left" for="gender">性別</label>
                <label class="grid_right"><input type="radio" name="gender" class="grid_right" value="1"
                <?php if(!empty($_POST['gender']) && $_POST['gender'] === "1"){echo "checked";}?>>男性</label>
                <label class="grid_right"><input type="radio" name="gender" class="grid_right" value="2"
                <?php if(!empty($_POST['gender']) && $_POST['gender'] === "2"){echo "checked";}?>>女性</label>
                <br>
                <label class="grid_left" for="email">メールアドレス</label>
                <input type="email" name="email" value=
                "<?php if(!empty($_POST['email'])){echo $_POST['email'];} ?>">
                <br>
                <label class="grid_left" for="age">年齢</label>
                <select name="age">
                    <option value="">選択してください</option>
                    <option value="1"
                    <?php if(!empty($_POST['age']) && $_POST['age'] === "1"){echo "selected";}?>>~19歳</option>
                    <option value="2"
                    <?php if(!empty($_POST['age']) && $_POST['age'] === "2"){echo "selected";}?>>20歳~29歳</option>
                    <option value="3"
                    <?php if(!empty($_POST['age']) && $_POST['age'] === "3"){echo "selected";}?>>30歳~39歳</option>
                    <option value="4"
                    <?php if(!empty($_POST['age']) && $_POST['age'] === "4"){echo "selected";}?>>40歳~49歳</option>
                    <option value="5"
                    <?php if(!empty($_POST['age']) && $_POST['age'] === "5"){echo "selected";}?>>50歳~59歳</option>
                    <option value="6"
                    <?php if(!empty($_POST['age']) && $_POST['age'] === "6"){echo "selected";}?>>60歳~</option>
                    <option value="7"
                    <?php if(!empty($_POST['age']) && $_POST['age'] === "7"){echo "selected";}?>>70歳~</option>
                </select>
                <br>
                <label class="grid_left" for="contact_type[]">お問い合わせ種別</label>
                <label class="grid_right"><input type="checkbox" name="contact_type[]" value="ご依頼"
                <?php if(!empty($_POST['contact_type']) && preg_match("/ご依頼/", $_POST['contact_type'])){echo "checked";}?>>ご依頼</label>
                <label class="grid_right"><input type="checkbox" name="contact_type[]" value="求人"
                <?php if(!empty($_POST['contact_type']) && preg_match("/求人/", $_POST['contact_type'])){echo "checked";}?>>求人</label>
                <label class="grid_right"><input type="checkbox" name="contact_type[]" value="その他 "
                <?php if(!empty($_POST['contact_type']) && preg_match("/その他/", $_POST['contact_type'])){echo "checked";}?>>その他</label>
                <br>
                <label class="grid_left" for="contact">お問い合わせ内容</label>
                <textarea class="contact" name="contact" cols="30" rows="10"><?php if(!empty($_POST['contact'])){echo $_POST['contact'];}?></textarea>
                <br>
            </div>
            <div class="submit-area">
                <input type="submit" name="btn_confirm" value="入力内容確認">
            </div>
            <br><!-- トップページでcsrfTokenをunset？ -->
            <a href="../index.html" class="link_top">トップページに戻る</a>
            <input type="hidden" name="csrf" value="<?php echo $token; ?>">
        </form>
    <?php endif; ?>

    <?php if($pageFlag === 1 && $_POST['csrf'] === $_SESSION['csrfToken']) : ?>
   
        <!-- csrfでtokenが一致しなかった時等の処理を行いたい場合以下のように分けて分岐処理。 -->
        <?php /*if($pageFlag === 1 ) : */?>
        <?php /*if($_POST['csrf'] === $_SESSION['csrfToken']) : */?>
        <?php /*elseif() : */?>
        <?php /*else : */?>
        <?php /*endif; */?>

        <form method="POST" action="form.php">
            <div class="grid">
                <p class="grid_left">氏名</p>
                <?php echo h($_POST["your_name"]); ?>
                <br>
                <p class="grid_left">性別</p>
                <?php 
                    if(!empty($_POST['gender']) && $_POST['gender'] === '1'){echo "男性";}
                    if(!empty($_POST['gender']) && $_POST['gender'] === '2'){echo "女性";}
                ?>
                <br>
                <p class="grid_left">メールアドレス</p>
                <?php echo $_POST['email']; ?>
                <br>
                <p class="grid_left">年齢</p>
                <?php  
                    if($_POST['age'] === "1"){echo "~19歳";}
                    if($_POST['age'] === "2"){echo "20歳~29歳";}
                    if($_POST['age'] === "3"){echo "30歳~39歳";}
                    if($_POST['age'] === "4"){echo "40歳~49歳";}
                    if($_POST['age'] === "5"){echo "50歳~59歳";}
                    if($_POST['age'] === "6"){echo "60歳~";}
                    if($_POST['age'] === "7"){echo "70歳~";}
                ?>
                <br>
                <p class="grid_left">お問い合わせ種別</p>
                <?php if(!empty($_POST['contact_type'])){
                    $ctValues = ""; 
                    foreach($_POST['contact_type'] as $ctValue){ 
                    $ctValues .= $ctValue." ";
                    }
                    if(!empty($ctValues)){ 
                    echo $ctValues; 
                }}?>
                <br>
                <p class="grid_left">お問い合わせ内容</p>
                <?php if(!empty($_POST['contact'])){echo $_POST['contact'];}?>
                <br>
            </div>
            <div class="submit-area">
                <input type="submit" name="btn_back" value="戻る">
                <input type="submit" name="btn_submit" value="送信する">
            </div>
            <input type="hidden" name="your_name" value="<?php echo $_POST['your_name']; ?>">
            <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
            <input type="hidden" name="gender" value="<?php echo $_POST['gender']; ?>">
            <input type="hidden" name="age" value="<?php echo $_POST['age']; ?>">
            <input type="hidden" name="contact_type" value="<?php echo $ctValues; ?>">
            <input type="hidden" name="contact" value="<?php echo $_POST['contact']; ?>">
            <input type="hidden" name="csrf" value="<?php echo $_POST['csrf']; ?>">

        </form>
    <?php endif; ?>

    <?php if($pageFlag === 2 && $_POST['csrf'] === $_SESSION['csrfToken']) : ?>
        <p class="send-msg">送信が完了しました。</p>
        <?php unset($_SESSION['csrfToken']); ?>
        <a href="../index.html" class="link_top">トップページに戻る</a>
    <?php endif; ?>
    
    <footer>

    </footer>
</body>
</html>