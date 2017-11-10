<?php

/**
 * 文字列の全ての並びのパターンを標準出力するためのクラス
 *
 * インスタンス化時に文字列を与えて、'multiset_permutation'を呼ぶ。
 *
 * @author Atsushi Akisue <a.akisue@gmail.com>
 */
class MultisetPermutation {

  //元の文字列保持
  private $original_str;

  //与えられた任意の文字列の各文字をキーに、その出現回数を値にして保持する
  private $char_multiset;

  //与えられた文字列の並び全パターン数
  private $total;

  //再帰関数(multiset_permutation)実行中に文字列の並びを保持する
  private $string;

  /**
   * MultisetPermutation コンストラクタ
   *
   * @param String $str 任意の文字列
   * @throws RuntimeException 引数がない、もしくは空白のとき
   * @throws UnexpectedValueException 文字コードがUTF-8/ASCIIではない場合
   */
  function __construct($str) {
    if(empty($str)) { //空白文字
      throw new \RuntimeException('Error! MultisetPermutation.Class requires some strings when instantiation.');
    }
    if(mb_detect_encoding($str) !== 'UTF-8' && mb_detect_encoding($str) !== 'ASCII') { //UTF-8とASCII以外の文字列の場合
      throw new \UnexpectedValueException('Error! MultisetPermutation.Class requires UTF-8/ASCII strings as argument when instantiation.');
    }

    //オリジナル保持
    $this->original_str = $str;

    //文字列を配列に
    $str_char_array = preg_split("//u", $this->original_str, -1, PREG_SPLIT_NO_EMPTY);

    //各文字をキーに、その出現回数を値にする
    $this->char_multiset = array_count_values($str_char_array);
  }

  /**
   * 任意の文字列の全ての並び替えパターンを標準出力する再帰関数
   *
   * 引数、戻り値なし
   */
  public function multiset_permutation() {

    //各要素の値の合計が0 ならば 全ての文字を使ったのでパターンマッチ
    if((int)array_sum($this->char_multiset) == 0) {
      $this->total++;
      echo $this->string . PHP_EOL;
    }
    else {  //パターンマッチしなければ再帰

      //高速化のため、既に使用できない$char_multisetの要素(=値が0)を取り除く
      //array_filter はcallbackの引数がない場合、FALSE判定の値を持つ要素(この場合intの0)がフィルタリング
      $exist_char_multiset = array_filter($this->char_multiset);

      foreach(array_keys($exist_char_multiset) as $char) {  //文字の各キーを値にした配列でforeach
        $this->char_multiset[$char]--;
        $this->string .= $char;

        $this->multiset_permutation();

        $this->char_multiset[$char]++;
        $this->string = mb_substr($this->string, 0, -1, "UTF-8");
      }
    }
  }

  /**
   * 元文字列のgetter
   *
   * @return private string $original_str
   */
  public function getOriginal_str() {
    return $this->original_str;
  }

  /**
   * 全パターン数のgetter
   *
   * @return private int $total
   */
  public function getTotal() {
    return $this->total;
  }
} //MultisetPermutation Class End
