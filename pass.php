<?php
include 'admin/database.php';
function getPass($input)
{
    $password_hash = password_hash($input, PASSWORD_DEFAULT);
    echo $input . "<br>";
    return $password_hash;
}

?>

<html>

<head>
    <title>Create password hash</title>
</head>

<body>
    <h3>Create one-way hashed string using php password_hash() function</h3>
    <form action="" method="post">
        <input type="text" name="input" id="input"> <input type="submit" value="Hash" name="submit">
    </form>
    <br><br>
    <?php
    if (isset($_POST['submit'])) {
        $password_hash = getPass($_POST['input']);
    }
    ?>
    <input style="width:500px;" type="text" name="" id="output" value="<?php if (isset($password_hash)) {
                                                        echo $password_hash;
                                                    } else {
                                                        echo '';
                                                    } ?>">
</body>

<script>
    function copy() {
        let text = document.querySelector("#output");
        text.select();
        document.execCommand("copy");
        // alert("Text Copied!");
    }
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelector("#output").onclick = copy;
    });
</script>

</html>