<?php
function getUsersCount()
{
    require dirname(__DIR__, 1) . '/connect_db.php';
    $sql = $conn->prepare('SELECT COUNT(*) as count from users');
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else return 0;
}

function getUsersResult($limit = 10, $offset = 0)
{
    require dirname(__DIR__, 1) . '/connect_db.php';
    if ($limit == 0) {
        $sql = $conn->prepare("SELECT * FROM users");
    } else {
        $sql = $conn->prepare("SELECT * FROM users limit ? offset ?");
        $sql->bind_param('ii',  $limit, $offset);
    }
    $sql->execute();
    return $sql->get_result();
}
