<?php
function getBillsCount()
{
    require dirname(__DIR__, 1) . '/connect_db.php';
    $sql = $conn->prepare('SELECT COUNT(*) as count from bills');
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else return 0;
}

function getBillsResult($limit = 10, $offset = 0)
{
    require dirname(__DIR__, 1) . '/connect_db.php';
    if ($limit == 0) {
        $sql = $conn->prepare("SELECT * FROM bills");
    } else {
        $sql = $conn->prepare("SELECT * FROM bills limit ? offset ?");
        $sql->bind_param('ii',  $limit, $offset);
    }
    $sql->execute();
    return $sql->get_result();
}
