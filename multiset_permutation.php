<?php
/**
 * コマンドライン引数に任意の文字列を渡し、その文字列の全列挙パターンを標準出力するスクリプト
 *
 * 文字コードはUTF-8またはASCII
 * 文字列に空白や改行を含む場合はダブルクオーテーションで囲む
 * 文字列としてのダブルクオーテーションは直前にバックスラッシュを付与することでエスケープする
 */

require_once('./MultisetPermutationClass.php');

if( ! isset($argv[1])) { //argv[1] はコマンドラインで与えられた任意の文字列
  echo "please input some word.";
  exit;
}

try { //文字列の全パターンを出力するクラスMultisetPermutationをインスタンス化
  $multiset_permutation = new MultisetPermutation($argv[1]);
} catch (Exception $e) {
  echo $e->getMessage();
  exit;
}

//info出力
echo PHP_EOL;
echo "~~~~~~~~~~~~~~~~~~~~" . PHP_EOL;
echo "Multiset Permutation" . PHP_EOL;
echo "Original String : " . $multiset_permutation->getOriginal_str() . PHP_EOL;
echo PHP_EOL;
echo "All Patterns" . PHP_EOL;
echo "----------------" . PHP_EOL;

$start = microtime(true); //処理時間計測開始
$multiset_permutation->multiset_permutation(); //全パターン検出
$end = microtime(true); //処理時間計測終了

echo "----------------" . PHP_EOL;
echo "Total : " . $multiset_permutation->getTotal() . PHP_EOL;
echo "~~~~~~~~~~~~~~~~~~~~" . PHP_EOL . PHP_EOL;

//計測時間出力
echo "Procedure Time : " . (($end - $start) * 1000) . "(ms)" . PHP_EOL . PHP_EOL;

//メモリ使用量計測
$peakmem = number_format(memory_get_peak_usage());
echo "Peak Memory: " . $peakmem . PHP_EOL . PHP_EOL;
?>
