<?php
setcookie("probe","1", time()+3600, "/"); header("X-Debug: ok"); echo "ok
";
