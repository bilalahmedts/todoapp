<?php
include 'includes/connect.php';
include 'includes/functions.php';

$editState = false;
$getTaskById = "";
$tasKIdById = "";
$taskNameById = "";
/** below is the code for adding the tasks inside the database */
if (isset($_POST['addTask'])) {

    if (empty($_POST['taskName'])) {/** checking that whether the field of task is empty or not */

        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Tasks Field is empty!</strong> Fill the field.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
             </div>";
    } else {
        /** from here the add task starts
         */
        $taskName = $_POST['taskName'];

        if (AddTask($taskName)) {/** @param  $taskName is passed here that contains the post value of taskName from the form */

            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                       <strong>Tasks Added Successfully!</strong> .
                       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                       <span aria-hidden='true'>&times;</span>
                       </button>
                 </div>";
        } else {

            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                       <strong>Task not added!</strong> There must be some issue.
                       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                       <span aria-hidden='true'>&times;</span>
                       </button>
                </div>";
        }
    }
}
/**
 * Below is the code for viewing/ reading the Task Name from the database
 */

$viewTask = ViewTask(null);

/**
 * Below is the code for Deleting the Task Name from the database
 */

if (isset($_POST["deleteTask"])) {

    $taskId = $_POST["taskId"];
    $deleteTask = DeleteTask($taskId);
    if ($deleteTask) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Tasks Deleted Successfully!</strong> .
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            header( "refresh:1; url=index.php" );
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                       <strong>Task not added!</strong> There must be some issue.
                       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                       <span aria-hidden='true'>&times;</span>
                       </button>
                </div>";
    }

}

/**
 * Below is the code for Editing the Task Name from the database
 */
/** This block runs when we press edit button against a record */
/* if (isset($_POST["editTask"])) {
    $taskId = $_POST["taskId"];
    $editState = true;
    $getTaskById = ViewTask($taskId);
    $result = mysqli_fetch_assoc($getTaskById);
    $taskIdById = $result["taskId"];
    $taskNameById = $result["taskName"];
} */
/** This block runs when edit is pressed then we have edit form in which we change the value and on pressing update the value is edited and updated in the database */
if (isset($_POST["updateTask"])) {
    if (empty($_POST['taskName'])) {

        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Tasks Field is empty!</strong> Fill the field.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
             </div>";
    } else {
        $taskId = $_POST["taskId"];
        $taskName = $_POST["taskName"];
        $updateTask = EditTask($taskId, $taskName);
        if ($updateTask) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Tasks Edited Successfully!</strong> .
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            header( "refresh:1; url=index.php" );
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                       <strong>Task not Edited!</strong> There must be some issue.
                       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                       <span aria-hidden='true'>&times;</span>
                       </button>
                </div>";
        }
    }

}


 
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php';?>

<body id="page-top">
    <div class="container">
        <h1 class="h3 mt-3 mb-1 text-gray-800">To Do Task App</h1>
        <div class="card shadow mt-4">
            <div class="card-header py-3">
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addTask">Add Task</button>
<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTask">Add Tasks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <div class="card ">
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label>Enter Task</label>
                                <input type="text" class="form-control" name="taskName">
                            </div>
                            <button type="submit" class="btn btn-primary" name="addTask">Add Task</button>
                        </form>
                    </div>
                </div>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
                <h6 class="m-0 font-weight-bold text-primary">List of Tasks</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tasks</th>
                                <th class="text-center">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($row = mysqli_fetch_array($viewTask)) {?>
                            <tr>
                                <td class="text-center"><?php echo $i; ?></td>
                                <td class="text-center"><?php echo $row["taskName"]; ?></td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <form method="POST">
                                                <input type="hidden" name="taskId"
                                                    value="<?php echo $row["taskId"]; ?>">
                                                <button class="btn btn-primary" type="submit"
                                                    name="deleteTask">Delete</button>
                                            </form>
                                        </div>
                                        <div class="col-md-3">
                                            <form method="POST">
                                                <input type="hidden" name="taskId"
                                                    value="<?php echo $row["taskId"]; ?>">
                                                <button class="btn btn-primary editTaskButton" type="button"
                                                    name="editTask" data-toggle="modal" data-target="#editTask">Edit</button>
                                            </form>
                                            <div class="modal fade" id="editTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editTask">Edit Tasks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <div class="card ">
                    <div class="card-body">
                        <form method="post" action="">
                            <input type="hidden" name="taskId" id="taskId" >
                            <div class="form-group">
                                <label>Enter Task</label>
                                <input type="text" class="form-control" id="taskName" name="taskName">
                            </div>
                            <button type="submit" class="btn btn-primary" name="updateTask">Update Task</button>
                        </form>
                    </div>
                </div>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++;}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<!--         <div class="row">
            <div class="col-md-6 mt-2">

                <div class="card ">
                    <div class="card-body">
                        <form method="post" action="">
                            <input type="hidden" name="taskId" value="<?php echo $taskIdById; ?>">
                            <div class="form-group">
                                <label>Enter Task</label>
                                <input type="text" class="form-control" name="taskName"
                                    value="<?php echo $taskNameById; ?>">
                            </div>
                            <?php if ($editState): ?>
                            <button type="submit" class="btn btn-primary" name="updateTask">Update Task</button>
                            <?php else: ?>
                            <button type="submit" class="btn btn-primary" name="addTask">Add Task</button>
                            <?php endif?>
                        </form>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <?php include 'includes/script.php';?>
</body>

</html>