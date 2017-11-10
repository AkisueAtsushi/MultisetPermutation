<?php

use PHPUnit\Framework\TestCase;

require_once('./MultisetPermutationClass.php');

/**
 * MultisetPermutation Classのテストクラス
 *
 * ・テスト基本方針
 * 不正な文字列(文字コード違い、空白文字)がエラーになるのを確認。
 * 少ない文字列で処理を実行し、全パターンが正しく出力されるか目視で確認。
 * 全パターンの数を保持しているので、件数が正しいかをassertEqualsで確認。
 * また、「任意の文字列」をどこまで許容するかについてのドキュメントの代替。
 *
 * 補足: 件数の算出については下記参照
 * @link https://en.wikipedia.org/wiki/Permutation#Permutations_of_multisets
 *
 * @author Atsushi Akisue <a.akisue@gmail.com>
 */
class MultisetPermutationTest extends TestCase
{
  protected $object;

  /**
   * 空白の文字列を渡した場合は例外を返す
   *
   * @expectedException RuntimeException
   */
  public function testInstantiationWithEmptyString() {
    $object = new MultisetPermutation("");
  }

  /**
   * 文字コードがUTF-8かASCIIでなければ例外を返す
   *
   * @expectedException UnexpectedValueException
   */
  public function testInstantiationWithNoUTF8norASCIIcode() {
    $object = new MultisetPermutation(mb_convert_encoding("あした天気になぁれ", "SJIS"));
  }

  /**
   * ASCII文字での全パターン出力、大文字小文字は違う文字列として判定
   */
  public function testUpperLowerMixtureStringMultisetPermutation() {
    $str = "Aabc";
    $object = new MultisetPermutation($str);
    echo PHP_EOL . PHP_EOL;
    echo "All patterns of " . $str . PHP_EOL;
    echo "----------------" . PHP_EOL;
    $object->multiset_permutation();
    echo PHP_EOL;
    $this->assertEquals(24, $object->getTotal());
  }

   /**
    * マルチバイト文字での全パターン出力
    */
  public function testMultibyteStringMultisetPermutation() {
    $str = "みみずく";
    $object = new MultisetPermutation($str);
    echo PHP_EOL . PHP_EOL;
    echo "All patterns of " . $str . PHP_EOL;
    echo "----------------" . PHP_EOL;
    $object->multiset_permutation();
    echo PHP_EOL;
    $this->assertEquals(12, $object->getTotal());
  }

  /**
   * 記号、改行も文字として許容
   */
  public function testSymbolAndNewlinecodeMultisetPermutation() {
    $str = "＆
ああ";
    $object = new MultisetPermutation($str);
    echo PHP_EOL . PHP_EOL;
    echo "All patterns of " . $str . PHP_EOL;
    echo "----------------" . PHP_EOL;
    $object->multiset_permutation();
    echo PHP_EOL;
    $this->assertEquals(12, $object->getTotal());
  }

  /**
   * 全角半角文字、記号が混在していても文字列として許容する
   */
  public function testComplexStringMultisetPermutation() {
    $str = "Aﾀﾞﾞん";
    $object = new MultisetPermutation($str);
    echo PHP_EOL . PHP_EOL;
    echo "All patterns of " . $str . PHP_EOL;
    echo "----------------" . PHP_EOL;
    $object->multiset_permutation();
    echo PHP_EOL;
    $this->assertEquals(60, $object->getTotal());
  }

  /**
   * 整数型が渡された場合も文字列に変換して処理
   */
  public function testIntConvertToStringMultisetPermutation() {
    $str = 1123;
    $object = new MultisetPermutation($str);
    echo PHP_EOL . PHP_EOL;
    echo "All patterns of " . $str . PHP_EOL;
    echo "----------------" . PHP_EOL;
    $object->multiset_permutation();
    echo PHP_EOL;
    $this->assertEquals(12, $object->getTotal());
  }

  /**
   * Float/Double型が渡された場合も文字列に変換して処理
   */
  public function testFloatConvertToStringMultisetPermutation() {
    $str = 1.12;
    $object = new MultisetPermutation($str);
    echo PHP_EOL . PHP_EOL;
    echo "All patterns of " . $str . PHP_EOL;
    echo "----------------" . PHP_EOL;
    $object->multiset_permutation();
    echo PHP_EOL;
    $this->assertEquals(12, $object->getTotal());
  }
}
?>
