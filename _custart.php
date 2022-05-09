<?php
/**
 * 開発向け情報
 * 
 * dev引数を利用することでローカルのCuSTartを利用します。
 * php _cuStart.php dev
 * 
 * テストを実行する場合は別ディレクトリを作成しそこで実行すると削除を行ないやすいです。
 * mkdir test
 * cd test
 * php ../_cuStart.php dev
 * 
 */

// DS設定
if (!defined("DS")) {
	define("DS", DIRECTORY_SEPARATOR);
}

// timezone設定
ini_set("date.timezone", "Asia/Tokyo");


if (in_array("dev", $argv)) {
	// 開発用
	$deployDir = getcwd();
	$libDir    = realpath(dirname($argv[0])) . DS . "_inc";
	$classFile = $libDir . DS . "CuStart.php";
	
} else {
	// CuStart取得
	$tmpDir = sys_get_temp_dir() . DS . 'custart';
	exec("rm -rf {$tmpDir}");
	$repo = "git@github.com:ecatchup/CuStart.git";
	exec ("git clone {$repo} {$tmpDir}");

	$deployDir = dirname(__FILE__);
	$libDir    = $tmpDir . DS . "_inc";
	$classFile = $libDir . DS . "CuStart.php";
}

if (!file_exists($classFile)) {
	echo '実行ファイルが見つかりません。CuStartファイルをチェックしてください。';
	exit;
}


// class autoload
function bootAutoload($className) {
    require_once $GLOBALS["libDir"] . DS . $className . ".php";
}
spl_autoload_register('bootAutoLoad');

CuStart::setDeployDir($deployDir);
CuStart::setLibDir($libDir);
CuStart::exec();
