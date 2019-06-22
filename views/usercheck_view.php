<table>
    <?php
    if ($data) {
        foreach ($data as $user) {
            echo '<tr><td>' . $user['nickname'] . '</td><td><a href="?page=user&action=login&account_token=' . $user['account_token'] . '">' . $user['account_token'] . '</a></td></tr>';
        }
    }
    ?>
</table>