<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<body>
    <pre>
        <?php
        $User = new User();
        $result = $User->get_one_user($_GET['id']);
        //without sanitizing
        var_dump($result);

        //with sanitizing
        echo htmlspecialchars($result[0]['password']);
        ?>
    </pre>
</body>

</html>