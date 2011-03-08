<?php
if( isset( $_REQUEST['name'] ) && isset( $_REQUEST['bill'] ) ) {
  echo($_REQUEST['name'] . ' ');
  echo($_REQUEST['bill']);
}
?>
