
<?php

// Read JSON data
$json = file_get_contents("users.json");
$users = json_decode($json);

// Show user editor form
function showUserPage($user) {

    $name = htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($user->type, ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8');

    $classes = htmlspecialchars(
        implode(", ", $user->classes),
        ENT_QUOTES,
        'UTF-8'
    );

    echo <<<HTML

    <nav>
        <a href="users.php">← Back to User List</a>
    </nav>

    <h2>Edit User</h2>

    <form method="post">

        <div>
            <label for="name">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{$name}"
            >
        </div>

        <div>
            <label for="type">Type</label>
            <input
                type="text"
                id="type"
                name="type"
                value="{$type}"
            >
        </div>

        <div>
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{$email}"
            >
        </div>

        <div>
            <label for="classes">Classes</label>
            <textarea
                id="classes"
                name="classes"
                rows="3"
            >{$classes}</textarea>
        </div>

        <button type="submit">Save Changes</button>

    </form>

HTML;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Module 8 - User Editor</title>
    <link rel="stylesheet" href="Ustyle.css">
</head>

<body>

    <h1>User Admin</h1>

    <?php if (
        isset($_GET["id"]) &&
        ctype_digit((string) $_GET["id"]) &&
        isset($users[(int) $_GET["id"]])
    ) { ?>

        <?php
            $id = (int) $_GET["id"];
            showUserPage($users[$id]);
        ?>

    <?php } else { ?>

        <h2>User List</h2>

        <ul>
            <?php for ($i = 0; $i < count($users); $i++) { ?>

                <li>
                    <a href="users.php?id=<?=$i?>">
                        <?=htmlspecialchars($users[$i]->name, ENT_QUOTES, 'UTF-8')?>
                    </a>
                </li>

            <?php } ?>
        </ul>

    <?php } ?>

</body>
</html>
