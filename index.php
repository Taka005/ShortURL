<?php
if($_GET['p']){
    $url = json_decode(file_get_contents("./data/url.json"),true);

	if(isset($url[$_GET['p']])){
		header("Location: ".$url[$_GET['p']]);
	}else{
		print "URLが見つかりません";
	}
	exit;
}

if($_GET["text"]){
    $res = "<h3 class='text-center text-secondary '>".htmlspecialchars($_GET["text"])."</h3>";
}

if($_POST['url']){
    $random = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZY0123456789'),0,8);
    $url = json_decode(file_get_contents("./data/url.json"),true);
    
    if(strpos($_POST['url'],'tlti.tk')){
        $text = "このサイトのURLは使用できません";
    }else if(!preg_match('/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i',$_POST['url'])){
        $text = "URLを入力してください";
    }else{
        $url[$random] = $_POST['url'];
        file_put_contents("./data/url.json",json_encode($url,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR));
        $text = "https://tlti.tk/".$random;
    }
    header("Location: https://tlti.tk/?text=".$text);
}

?>
<html lang="ja">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

	<title>TLTI-短縮URL</title>

    <head prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/ fb# prefix属性: https://ogp.me/ns/ prefix属性#">
    <meta property="og:url" content="https://tlti.tk/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="トップページ" />
    <meta property="og:description" content="無料で短縮URLを作成することができます" />
    <meta property="og:site_name" content="TLTI-短縮URL" />
    <meta property="og:image" content="./images/takasumibot.png" />
    
    <link rel="apple-touch-icon" type="image/png" sizes="180x180" href="./images/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="180x180" href="./images/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="./images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="1024x1024" href="./images/takasumibot.png">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="無料で短縮URLを作成することができます">
    <meta name="keywords" content="短縮URL,Taka005,">

	<style type="text/css">
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
        }
        .container {
            width: auto;
            max-width: 680px;
            padding: 0 15px;
        }
        .container .text-muted {
            margin: 20px 0;
        }
	</style>
</head>
<body class="bg-light">
    <main>
        <div class="container w-75">
            <h1 class="text-center text-dark my-5">短縮URL</h1>
            <?= $res ?>
            <form action="" method="post" class="mb-4 position-absolute top-50 start-50 translate-middle">
                <input name="url" class="form-control form-control-lg" placeholder="短縮するURL" autocomplete="off" required>
            </form>
        </div>
    </main>
    <footer class="footer">
        <div class="container text-center">
          <p class="text-muted">©︎2022 Taka</p>
        </div>
    </footer>
  </body>
</html>