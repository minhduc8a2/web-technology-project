<?php
function getShoesCountByCategory($category)
{
    require dirname(__DIR__, 1) . '/connect_db.php';
    $sql = $conn->prepare('SELECT COUNT(*) as count from shoes where category=?');
    $sql->bind_param('s', $category);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else return 0;
}

function getShoesCount()
{
    require dirname(__DIR__, 1) . '/connect_db.php';
    $sql = $conn->prepare('SELECT COUNT(*) as count from shoes');
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else return 0;
}

function getShoesResultByCategory($categoryName, $limit, $offset)
{
    require dirname(__DIR__, 1) . '/connect_db.php';
    $sql = $conn->prepare("SELECT id,name, price, imageurl FROM shoes where category = ? limit ? offset ?");
    $sql->bind_param('sii', $categoryName, $limit, $offset);
    $sql->execute();
    return $sql->get_result();
}

function getShoesResult($limit = 10, $offset = 0)
{
    require dirname(__DIR__, 1) . '/connect_db.php';
    if ($limit == 0) {
        $sql = $conn->prepare("SELECT * FROM shoes");
    } else {
        $sql = $conn->prepare("SELECT * FROM shoes limit ? offset ?");
        $sql->bind_param('ii',  $limit, $offset);
    }
    $sql->execute();
    return $sql->get_result();
}
