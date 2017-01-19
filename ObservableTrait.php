<?php
namespace Skel;

/**
 * ObservableTrait is a set of methods that fulfill the \Skel\Interfaces\Observable interface
 *
 * @see \Skel\Interfaces\Observable
 */

trait ObservableTrait {
  protected $_listeners = array();

  public function notifyListeners(string $event, array $data=array()) {
    if (!isset($this->_listeners[$event])) return true;
    array_unshift($data, $this);
    foreach ($this->_listeners[$event] as $l) {
      $listener = $l[0];
      $handler = $l[1];
      $result = call_user_func_array(array($listener, $handler), $data);

      // Optionally halt event propagation
      if ($result === false) return false;
    }
    return true;
  }

  public function registerListener(string $event, $listener, string $handler) {
    if (!isset($this->_listeners[$event])) $this->_listeners[$event] = array();
    foreach ($this->_listeners[$event] as $l) {
      if ($l[0] == $listener && $l[1] == $handler) return $this;
    }
    $this->_listeners[$event][] = array($listener, $handler);
    $this->notifyListeners('RegisterListener', array('app' => $this, 'event' => $event, 'listener' => $listener, 'handler' => $handler));
    return $this;
  }

  public function removeListener(string $event, $listener, string $handler) {
    if (!isset($this->_listeners[$event])) return $this;
    foreach ($this->_listeners[$event] as $k => $l) {
      if ($l[0] == $listener && $l[1] == $handler) {
        unset($this->_listeners[$event][$k]);
        $this->notifyListeners('RemoveListener', array('app' => $this, 'event' => $event, 'listener' => $listener, 'handler' => $handler));
        return $this;
      }
    }
    return $this;
  }
}
