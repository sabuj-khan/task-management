<?php 
require_once("config.php");
if(!$connection){
    throw new Exception("Can not connet to database");
}

$query = mysqli_query($connection, "SELECT * from tasks WHERE complete=0");

$comple_query = mysqli_query($connection, "SELECT * from tasks WHERE complete=1");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .btn-secondary{
        background-color: gray;
        border: 1px solid gray;
        color: #fff;
        padding: 3px 13px;
        border-radius: 2px;
    }
    .table thead tr th {
        color: gray;
    }
    .project {
        width: 60%;
    }
</style>
<body>
    

<div class="container mt-5">
        <div class="row">
            <div class="project m-auto">
                <h2>Tasks Management Project</h2>
                <p>A simple Task management project using PHP and MySQL.</p>
                
                <hr>     
                          
            </div>           
        </div>   
            
        <div class="row mb-5">
            <div class="project m-auto">
             <h5>All Tasks</h5>

             <?php if(mysqli_num_rows($comple_query) == 0 ) : ?>
                <h6>No Complete Tasks Found</h6>
            <?php else: ?> 
                <h6>Complete Tasks</h6>
                <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Tasks</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($data = mysqli_fetch_assoc($comple_query)) : 
                    $timestamp = strtotime($data['date']);
                    $our_date = date("jS M, Y", $timestamp);
                    ?>
                    <tr>
                        <td><input type="checkbox" class="label-inline" value="<?php echo $data['id']; ?>"></td>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['task']; ?></td>
                        <td><?php echo $our_date; ?></td>
                        <td> <a href='#' class="delete" data-taskid="<?php echo $data['id']; ?>">Delete</a> | <a href='#' class="incomplete" data-taskid="<?php echo $data['id']; ?>">Mark As Incomplete</a> </td>
                    </tr>
                <?php endwhile; ?>

                </tbody>
                </table>               

                <?php endif; ?>

                <p class="m-5"></p>



             <?php if(mysqli_num_rows($query) == 0 ): ?>
                <h6>No Tasks Found</h6>
            <?php else: ?>
             <form action="tasks.php" method="POST" id="bulkform">
             <h6>Upcoming Tasks</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Tasks</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($data = mysqli_fetch_assoc($query)) : 
                            $timestamp = strtotime($data['date']);
                            $our_date = date("jS M, Y", $timestamp);
                            ?>
                        <tr>
                            <td><input name="tasksids[]" type="checkbox" class="label-inline" value="<?php echo $data['id']; ?>"></td>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['task']; ?></td>
                            <td><?php echo $our_date; ?></td>
                            <td> <a href='#' class="delete" data-taskid="<?php echo $data['id']; ?>">Delete</a> | <a href='#' class="complete" data-taskid="<?php echo $data['id']; ?>">Complete</a> </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <div class="newbutton">
                    <select id="action" name="action" style="padding:3px">
                        <option value="0">With selected</option>
                        <option value="bulkdelete">Delete</option>
                        <option value="bulkcomplete">Mark complete</option>
                    </select>
                    <input class="btn-secondary" id="bulkdelete" type="submit" value="Submit" name="submit">
                </div>
             </form>
             <?php endif; ?>
                          
            </div>           
        </div> 

            <div class="row">
            <div class="project m-auto">
                <h5>Add New Tasks</h5>
                <form action="tasks.php" method="POST">
                    <?php
                        $added = isset($_GET['add']) ? $_GET['add'] : '';
                        if($added){
                            echo "<h6>The task has been added successfully</h6>";
                        }
                    ?>
                    <label for="task">Task</label> <br/>
                    <input class="w-100 mb-2 p-1" type="text" name="task" id="task" placeholder="Task Details"> <br />
                    <label for="date">Date</label> <br/>
                    <input class="w-100 mb-2 p-1" type="text" name="date" id="date" placeholder="Task Date"> <br />                   
                    <button type="submit" class="btn btn-secondary mt-2" name="save">Add Task</button>
                    <input type="hidden" name="action" value="add">
                </form>


            </div>           
        </div>

        <form action="tasks.php" method="POST" id="formcomplete">
            <input type="hidden" name="action" id="haction" value="complete">
            <input type="hidden" name="ctaskid" id="ctaskid">
        </form>
     
        <form action="tasks.php" method="POST" id="formdelete">
            <input type="hidden" name="action" id="daction" value="delete">
            <input type="hidden" name="dtaskid" id="dtaskid">
        </form>

        <form action="tasks.php" method="POST" id="incomplete">
            <input type="hidden" name="action" id="incomplete" value="incomplete">
            <input type="hidden" name="incomid" id="incomid">
        </form>

        
<script src="//code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>