<?php
if (isset($_SESSION['error_list'])) {
    foreach ($_SESSION['error_list']['errorList'] as &$value) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        $value
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                     </div>";
    }
    unset($_SESSION['error_list']);
}
