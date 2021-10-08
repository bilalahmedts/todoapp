<?php
function DbConnection() /** This function is basically used to call the connection */
{
    global $con;
    return $con;
}
function AddTask($taskName)
{
    $conn = DbConnection();
    $addTask = "INSERT into tasks (taskName) VALUES ('$taskName')";
    if (mysqli_query($conn, $addTask)) {
        return true;
    } else {
        return false;
    }
}                                                                                                                                                                                    

function ViewTask($where = null)
{
    $conn = DbConnection();
    if ($where != null) {
        $viewTask = "SELECT * FROM tasks WHERE taskId = '$where'";
    } else {
        $viewTask = "SELECT * FROM tasks";
    }
    $result = mysqli_query($conn, $viewTask);
    return $result;
}

function DeleteTask($taskId)
{
    $conn = DbConnection();
    $deleteTask = "DELETE FROM tasks WHERE taskId = '$taskId'";
    $result = mysqli_query($conn, $deleteTask);
    return $result;
}

function EditTask($taskId, $taskName)
{
    $conn = DbConnection();
    $editTask = "UPDATE tasks SET taskName = '$taskName' WHERE taskId = '$taskId'";
    $result = mysqli_query($conn, $editTask);
    return $result;
}