<?php 
require_once("config.php");

if(!$connection){
    throw new Exception("Can not connet to database");
}else{

$action = isset($_POST['action']) ? $_POST['action'] : '';

if(!$action){
    header("location: index.php");
    die();
}else{
    if('add' == $action){
        $task = $_POST['task'];
        $date = $_POST['date'];

        if($task && $date){
            $query = mysqli_query($connection, "INSERT INTO tasks (task, date) VALUES ('$task', '$date')");
            if($query){
                header("location: index.php?add=true");
            }
        }
    }elseif('complete' == $action){
        $taskid = $_POST['ctaskid'];
        if(isset($taskid)){
            mysqli_query($connection, "UPDATE tasks SET complete=1 WHERE id='$taskid' LIMIT 1");
            
        }
        header("location: index.php");

    }elseif('delete' == $action){
        $dtaskid = $_POST['dtaskid'];
        if(isset($dtaskid)){
            mysqli_query($connection, "DELETE FROM tasks WHERE id='$dtaskid' LIMIT 1");
            
        }
        header("location: index.php");
        
    }elseif('incomplete' == $action){
        $itaskid = $_POST['incomid'];
        if(isset($itaskid)){
            mysqli_query($connection, "UPDATE tasks SET complete=0 WHERE id='$itaskid' LIMIT 1");
            
        }
        header("location: index.php");
        
    }elseif('bulkcomplete' == $action){
        $itaskids = $_POST['tasksids'];
        //print_r($itaskids);
        $_taskids = join(',', $itaskids);
        //echo $_taskids;
        //die();
        

        if(isset($itaskids)){
            mysqli_query($connection, "UPDATE tasks SET complete=1 WHERE id in ($_taskids)");
            //echo $query;
            
        }
        header("location: index.php");
        
    }elseif('bulkdelete' == $action){
        $itaskidss = $_POST['tasksids'];
        $_taskidss = join(',', $itaskidss);
        if(isset($itaskidss)){
            mysqli_query($connection, "DELETE FROM tasks WHERE id in ($_taskidss)");
            
        }
        header("location: index.php");
        
    }
}
}