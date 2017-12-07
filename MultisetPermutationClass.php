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
   *　MultisetPermutationインスタンス生成のfactory method
   *
   * @param String $str 任意の文字列
   * @throws InvalidArgumentException 引数を文字列にキャストできない場合は例外処理
   */
  public static function createMultisetPermutation($str) {
    $str = filter_var($str);

    if ($str === false) {
      throw new \InvalidArgumentException('Error! MultisetPermutation.Class requires any strings as argument when instantiation.');
    }

    return new self($str);
  }

  /**
   * MultisetPermutation コンストラクタ
   *
   * @param String $str 任意の文字列
   */
  private function __construct($str) {

    //オリジナル保持
    $this->original_str = $str;

    //文字列を配列に
    $str_char_array = preg_split("//u", $this->original_str, -1, PREG_SPLIT_NO_EMPTY);

    //各文字をキーに、その出現回数を値にする
    $this->char_multiset = array_count_values($str_char_array);
  }

  /**
   * 任意の文字列の全ての並び替えパターンを出力する再帰関数を外部から呼び出す関数
   * 複数回呼び出された場合に件数をリセットする必要がある
   *
   * @yield 並び替えた文字列パターンを返す
   */
  public function start_multiset_permutation() {
    $this->total = 0;

    foreach($this->multiset_permutation() as $pattern)
      yield $pattern;
  }

  /**
   * 任意の文字列の全ての並び替えパターンを出力する再帰関数(private)
   *
   * @yield 並び替えた文字列パターンを返す
   */
  private function multiset_permutation() {

    //各要素の値の合計が0 ならば 全ての文字を使ったのでパターンマッチ
    if((int)array_sum($this->char_multiset) == 0) {
      $this->total++;
      yield $this->string;
    }
    else {  //パターンマッチしなければ再帰

      //高速化のため、既に使用できない$char_multisetの要素(=値が0)を取り除く
      //array_filter はcallbackの引数がない場合、FALSE判定の値を持つ要素(この場合intの0)がフィルタリング
      $exist_char_multiset = array_filter($this->char_multiset);

      foreach(array_keys($exist_char_multiset) as $char) {  //文字の各キーを値にした配列でforeach
        $this->char_multiset[$char]--;
        $this->string .= $char;

        foreach($this->multiset_permutation() as $pattern)
          yield $pattern;

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
