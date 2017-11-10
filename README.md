# Multiset Permutation

任意の文字列が入力された時に、その文字の順序を入れ替えることでできる全ての文字列のパターンを列挙するプログラム（と、その単体テストのスクリプト）

## スクリプト一覧

### multiset_permutation.php

コマンドライン引数で任意の文字列を渡し、その文字列の全列挙パターンを標準出力するスクリプト。
下記のMultisetPermutationのクラスを呼び出して実行する。

使用例）

`$ php multiset_permutation.php "MISSISSIPPI"`

(※先頭末尾の二重引用符は文字列対象外)

### MultisetPermutationClass.php

文字列の全ての並びのパターンを標準出力するためのクラス(MultisetPermutation)の記述

### MultisetPermutationTest.php

上記MultisetPermutationクラスの単体テストをするためのテストコード

※テストにはPHPUnitを使用

--------

*作業環境*

PHP 7.0.20

PHPUnit 6.4.4
