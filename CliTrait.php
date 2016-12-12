<?php
namespace Skel;

trait CliTrait {
  public function format($str, $format=null) {
    if ($this->noFormatting) return $str;
    $codes = array(
      'bold' => '1m'
    );
    if (!isset($codes[$format])) return $str;
    else return "\033[".$codes[$format]."$str\033[0m";
  }

  public function bold($str) {
    return $this->format($str, 'bold');
  }
}
