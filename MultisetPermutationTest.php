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

  protected function setUp() {
    $this->object = MultisetPermutation::createMultisetPermutation();
  }

  /**
   * 許容する文字についてのリファレンスと、
   * 文字列にキャストできないデータを渡した場合は例外を返す
   *
   * @expectedException InvalidArgumentException
   */
  public function testsetString() {
    $str = "Aabc";     //ASCII文字での全パターン出力、大文字小文字は違う文字列として判定
    $this->assertTrue($this->object->setString($str));

    $str = "みみずく";  //マルチバイト文字での全パターン出力
    $this->assertTrue($this->object->setString($str));

    $str = "＆
ああ";                  //記号、改行も文字として許容
    $this->assertTrue($this->object->setString($str));

    $str = "Aﾀﾞﾞん";   //全角半角文字、記号が混在していても文字列として許容する
    $this->assertTrue($this->object->setString($str));

    $str = 1123;       //整数型が渡された場合も文字列に変換して処理
    $this->assertTrue($this->object->setString($str));

    $str = 1.12;      //Float/Double型が渡された場合も文字列に変換して処理
    $this->assertTrue($this->object->setString($str));

    //配列は文字列にできないためエラー
    $str = array(3,4,5);
    $this->object->setString($str);
  }

  /**
   * 並び替えの出力が正しいか、複数回繰り返して同じ結果になるか、全パターンの比較と件数で確認
   */
  public function testgetAllMultisetPermutationPattern() {
    $str = "aabc";
    $expected = array("aabc", "aacb", "abac", "abca", "acab", "acba", "baac", "baca", "bcaa", "caab", "caba", "cbaa");

    $this->object->setString($str);

    for($i=0;$i<3;$i++) { //3回繰り返して結果が変わらないことを確認(3は任意の数字)
      $actual = array();

      foreach($this->object->getAllMultisetPermutationPattern() as $pattern) {
        array_push($actual, $pattern);
      } //全パターン検出

      $this->assertEquals($expected, $actual);
      $this->assertEquals(12, $this->object->getTotal());
    }
  }
} //MultisetPermutationTest End

?>
