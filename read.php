<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once 'config.php';
    
    $sql = "SELECT * FROM korisnik WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = trim($_GET["id"]);
        
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                $ime = $row["ime"];
                $prezime = $row["prezime"];
                $adresa = $row["adresa"];
                $spol = $row["spol"];
            } else{
                header("Location: error.php");
                exit();
            }
            
        } else{
            echo "Nesto nije u redu, probajte ponovo kasnije.";
        }
    }
     
    mysqli_stmt_close($stmt);
    
    mysqli_close($link);
} else{
    header("Location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Pregled zapisa</title>
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
                        <h1>Pregled zapisa</h1>
                    </div>
                    <div class="form-group">
                        <label>Ime</label>
                        <p class="form-control-static"><?php echo $row["ime"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Prezime</label>
                        <p class="form-control-static"><?php echo $row["prezime"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Adresa</label>
                        <p class="form-control-static"><?php echo $row["adresa"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Spol</label>
                        <p class="form-control-static"><?php echo $row["spol"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Natrga na pocetnu stranicu</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
