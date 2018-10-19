<?php
if(isset($_GET["days"])) {
  if (!$_GET['days'] == "1234590317382") {
  http_response_code(403);
  exit();
  }
} else {
  http_response_code(403);
  exit();
}
