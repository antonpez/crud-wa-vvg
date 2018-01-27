<?php
if(isset($_POST["id"]) && !empty($_POST["id"])){
    require_once 'config.php';
    
    $sql = "DELETE FROM korisnik WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = trim($_POST["id"]);
        
        if(mysqli_stmt_execute($stmt)){
            header("Location: index.php");
            exit();
        } else{
            echo "Nesto nije u redu, molim probajte ponovo kasnije.";
        }
    }
     
    mysqli_stmt_close($stmt);
    
    mysqli_close($link);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else{
    if(empty(trim($_GET["id"]))){
        header("Location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Brisanje zapisa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Brisanje zapisa</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Brisanje zapisa! Jeste li sigurni u trajno brisanje ovog zapisa?</p><br>
                            <p>
                                <input type="submit" value="POTPUNO SIGURAN!!!" class="btn btn-danger">
                                <a href="index.php" class="btn btn-default">NE, povratak na glavnu stranicu</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
