<?php
    $error = ErrorHandler::getError();
    if(!empty($error)) {
        var_dump($error);
    }

    if(isset($_SESSION['success'])) {
        var_dump($_SESSION['success']);
        unset($_SESSION['success']);
    }
?>
<h1>
    register
</h1>

<form action="<?= URL ?>/auth/signup" method="post">
    <input type="text" name="name" id="">
    <button type="submit">Submit</button>
</form>