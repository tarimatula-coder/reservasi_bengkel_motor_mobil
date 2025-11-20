<?php
session_start();
session_unset();
session_destroy();
echo " 
        <script>    
             alert('berhasil logout');
             window.location.href='../../pages/auth/login.php';
        </script>
     ";
