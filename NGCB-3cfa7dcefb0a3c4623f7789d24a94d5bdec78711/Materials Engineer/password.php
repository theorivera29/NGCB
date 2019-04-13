<?php
    echo "materials = ".password_hash("materials", PASSWORD_DEFAULT)."<br />";
    echo "admin = ".password_hash("admin", PASSWORD_DEFAULT)."<br />";
    echo "view = ".password_hash("view", PASSWORD_DEFAULT);
?>