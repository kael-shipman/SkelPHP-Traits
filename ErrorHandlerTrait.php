<?php
namespace Skel;

trait ErrorHandlerTrait {
  protected $errors = array();

  public function getErrors(string $field=null) {
    if ($field) return $this->errors[$field] ?: array();
    else {
      $errors = array();
      foreach($this->errors as $field => $e) $errors = array_merge($errors, $e);
      return $errors;
    }
  }
  public function numErrors(string $field=null) {
    if ($field) {
      if (!array_key_exists($field, $this->errors)) return 0;
      else return count($this->errors[$field]);
    } else {
      $num = 0;
      foreach($this->errors as $field => $errors) $num += count($errors);
    }
    return $num;
  }
  protected function clearError(string $key, string $which=null) {
    if (!array_key_exists($key, $this->errors)) return $this;
    if ($which && !array_key_exists($which, $this->errors[$key])) return $this;
    if ($which) {
      unset($this->errors[$key][$which]);
      if (count($this->errors[$key]) == 0) unset($this->errors[$key]);
    } else unset($this->errors[$key]);
    return $this;
  }
  protected function setError(string $key, string $val, string $which=null) {
    if (!array_key_exists($key, $this->errors)) $this->errors[$key] = array();
    if ($which) $this->errors[$key][$which] = $val;
    else $this->errors[$key][] = $val;
    return $this;
  }
}
