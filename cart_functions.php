
<?php

function getCartItems($str) {
  $curr = "";
  $list = [];
  for ($i = 2; $i < strlen($str); ++$i) {
    if ( $str[$i] == '[' ) continue;
    if ( $str[$i] == ']' ) {
      array_push($list, $curr);
      $curr = "";
      continue;
    }
    $curr .= "$str[$i]";
  }
  return $list;
}

function getCartItemsCount($str) {
  $list = getCartItems($str);
  return count($list);
}

function onCart($str, $id) {
  $list = getCartItems($str);
  for ($i = 0; $i < count($list); ++$i) {
    if (intval($list[$i]) == $id)  
      return true;
  }
  return false;
}

function removeFromCart($str, $id) {
  $new_list = [];
  $list = getCartItems($str);
  for ($i = 0; $i < count($list); ++$i) {
    if ($list[$i] == $id) continue;
    array_push($new_list, $list[$i]);
  }
  $res = "[]";
  for ($i = 0; $i < count($new_list); ++$i) {
    $item = $new_list[$i];
    $res = $res . "[$item]";
  }
  return $res;
}


?>