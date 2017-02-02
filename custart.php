i<?php
/**
 * # このプログラムでできること一覧
 *
 * ## baserCMSのファイル配置
 * - baserCMS安定版・dev版の選択
 * - baserCMSのzipダウンロード
 * - 解凍
 * - 設置
 * - ドキュメントルート変更
 *
 * ## baserCMSの初期準備
 * - Test削除
 * - 内部初期テーマ削除 （theme配下に設置後 コアのものを削除）
 * - インストール後にできるデフォルトテーマの削除
 * - プロジェクト用テーマフォルダの作成
 *
 * ## プラグインのダウンロード
 * - 設定リスト一覧より選択して配置
 *
 * ## gitignore作成
 * - .gitignoreファイルの作成
 *
 * ## 検討中
 * PENDING ブランクテーマ準備（スニペット、初期データ）
 *		→ Usefulでやってることの類も混ぜると良さそう
 * PENDING メールプラグイン初期設定
 * PENDING このファイル自体を削除する
 * PENDING database.php の中身を雛形形式にする
 *
 *
 * [TIPS]
 * コマンドライン実行時に渡した引数は、$argv配列に格納されている
 * foreach ($argv as $param) {
 *		echo $param,"\n";
 * }
 */
// DS設定
if (!defined("DS")) {
	define("DS", DIRECTORY_SEPARATOR);
}

// timezone設定
ini_set("date.timezone", "Asia/Tokyo");

// CuStart取得
$tmpDir = sys_get_temp_dir() . DS . 'custart';
$repo = "git@lab.e-catchup.jp:catchup/custart.git";
exec ("git clone {$repo} $tmpDir");
		
$bootFile  = __FILE__;
$libDir    = $tmpDir . DS . "_inc";
$classFile = $libDir . DS . "CuStart.php";

if (!file_exists($classFile)) {
	echo '実行ファイルが見つかりません。CuStartファイルをチェックしてください。';
	exit;
}

// class autoload
function __autoload($className) {
    require_once $GLOBALS["libDir"] . DS . $className . ".php";
}

CuStart::setBootFile($bootFile);
CuStart::setLibDir($libDir);
CuStart::exec();
