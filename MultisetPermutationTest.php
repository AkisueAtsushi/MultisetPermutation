<?php

use PHPUnit\Framework\TestCase;

require_once('./MultisetPermutationClass.php');

/**
 * MultisetPermutation Classのテストクラス
 *
 * 補足: 件数の算出については下記参照
 * @link https://en.wikipedia.org/wiki/Permutation#Permutations_of_multisets
 *
 * @author Atsushi Akisue <a.akisue@gmail.com>
 */
class MultisetPermutationTest extends TestCase {

  //MultisetPermutation のインスタンス格納
  protected $object;

  //インスタンス確認用
  protected $class = "MultisetPermutation";

  /**
   * 許容する文字についてのリファレンスと、
   * 文字列にキャストできないデータを渡した場合は例外を返す
   *
   * @expectedException InvalidArgumentException
   */
  public function testCreateMultisetPermutation() {
    $str = "Aabc";     //ASCII文字での全パターン出力、大文字小文字は違う文字列として判定
    $this->object = MultisetPermutation::createMultisetPermutation($str);
    $this->assertInstanceOf($this->class, $this->object);

    $str = "みみずく";  //マルチバイト文字での全パターン出力
    $this->object = MultisetPermutation::createMultisetPermutation($str);
    $this->assertInstanceOf($this->class, $this->object);

    $str = "＆
ああ";                  //記号、改行も文字として許容
    $this->object = MultisetPermutation::createMultisetPermutation($str);
    $this->assertInstanceOf($this->class, $this->object);

    $str = "Aﾀﾞﾞん";   //全角半角文字、記号が混在していても文字列として許容する
    $this->object = MultisetPermutation::createMultisetPermutation($str);
    $this->assertInstanceOf($this->class, $this->object);

    $str = 1123;       //整数型が渡された場合も文字列に変換して処理
    $this->object = MultisetPermutation::createMultisetPermutation($str);
    $this->assertInstanceOf($this->class, $this->object);

    $str = 1.12;      //Float/Double型が渡された場合も文字列に変換して処理
    $this->object = MultisetPermutation::createMultisetPermutation($str);
    $this->assertInstanceOf($this->class, $this->object);

    //配列は文字列にできないためエラー
    $this->object = MultisetPermutation::createMultisetPermutation(array(3, 4, 5));
  }

  /**
   * 並び替えの出力が正しいか、全パターンと件数で確認
   */
  public function testMultisetPermutation() {
    $str = "aabc";

    $actual = array();
    $expected = array("aabc", "aacb", "abac", "abca", "acab", "acba", "baac", "baca", "bcaa", "caab", "caba", "cbaa");

    $this->object = MultisetPermutation::createMultisetPermutation($str);

    foreach($this->object->start_multiset_permutation() as $pattern) {
      array_push($actual, $pattern);
    } //全パターン検出

    $this->assertEquals($expected, $actual);
    $this->assertEquals(12, $this->object->getTotal());
  }

  /**
   * 複数回呼び出しても結果の件数が変わらないことを確認
   */
  public function testMultipleCallForMultisetPermutation() {
    $str = "aabc";
    $this->object = MultisetPermutation::createMultisetPermutation($str);

    //1回目
    foreach($this->object->start_multiset_permutation() as $pattern) {} //全パターン検出
    $this->assertEquals(12, $this->object->getTotal());

    //2回目
    foreach($this->object->start_multiset_permutation() as $pattern) {} //全パターン検出
    $this->assertEquals(12, $this->object->getTotal());

    //3回目
    foreach($this->object->start_multiset_permutation() as $pattern) {} //全パターン検出
    $this->assertEquals(12, $this->object->getTotal());
  }

} //MultisetPermutationTest End

?>
