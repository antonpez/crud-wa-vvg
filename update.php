<?php
require_once 'config.php';
 
$ime = $prezime = $adresa = $spol = "";
$ime_err = $prezime_err = $adresa_err = $spol_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];

    $input_ime = trim($_POST["ime"]);
    if(empty($input_ime)){
        $ime_err = "Unesite ime.";
    } elseif(!filter_var(trim($_POST["ime"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $ime_err = 'Molim, unesite ispravno ime.';
    } else{
        $ime = $input_ime;
    }

    $input_prezime = trim($_POST["prezime"]);
    if(empty($input_prezime)){
        $prezime_err = 'Unesite prezime.';
    } elseif(!filter_var(trim($_POST["prezime"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $prezime_err = 'Molim, unesite ispravno prezime.';
    } else{
        $prezime = $input_prezime;
    }

    $input_adresa = trim($_POST["adresa"]);
    if(empty($input_adresa)){
        $adresa_err = "Unesite adresu.";
    } elseif(!filter_var(trim($_POST["adresa"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9'-.\s ]+$/")))){
        $adresa_err = 'Molim, unesite ispravnu adresu.';
    } else{
        $adresa = $input_adresa;
    }

    $input_spol = trim($_POST["spol"]);
    if(empty($input_adresa)){
        $spol_err = "Unesite spol.";
    } elseif(!filter_var(trim($_POST["spol"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[mz'-.\s ]+$/")))){
        $spol_err = 'Molim, unesite ispravan spol (m/z).';
    } else{
        $spol = $input_spol;
    }

    if(empty($ime_err) && empty($prezime_err) && empty($adresa_err) && empty($spol_err)) {
        $sql = "UPDATE korisnik SET ime=?, prezime=?, adresa=?, spol=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssi", $param_ime, $param_prezime, $param_adresa, $param_spol, $param_id);
            
            $param_ime = $ime;
            $param_prezime = $prezime;
            $param_adresa = $adresa;
	    $param_spol = $spol;
	    $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            } else{
                echo "Nesto nije u redu, molim probajte ponovo kasnije.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM korisnik WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $ime = $row["ime"];
                    $prezime = $row["prezime"];
                    $adresa = $row["adresa"];
		    $spol = $row["spol"];
                } else{
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Nesto nije u redu, molim probajte ponovo kasnije.";
            }
        }
        
        mysqli_stmt_close($stmt);
        
        mysqli_close($link);
    }  else{
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Izmjena zapisa</title>
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
                        <h2>Izmjena zapisa</h2>
                    </div>
                    <p>Molim, izmjenite zapis te potvrdite kako bi promjena bila spremljena.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($ime_err)) ? 'has-error' : ''; ?>">
                            <label>Ime</label>
                            <input type="text" name="ime" class="form-control" value="<?php echo $ime; ?>">
                            <span class="help-block"><?php echo $ime_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($prezime_err)) ? 'has-error' : ''; ?>">
                            <label>Prezime</label>
                            <input type="text" name="prezime" class="form-control" value="<?php echo $prezime; ?>">
                            <span class="help-block"><?php echo $prezime_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($adresa_err)) ? 'has-error' : ''; ?>">
                            <label>Adresa</label>
                            <input type="text" name="adresa" class="form-control" value="<?php echo $adresa; ?>">
                            <span class="help-block"><?php echo $adresa_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($spol_err)) ? 'has-error' : ''; ?>">
                            <label>Spol</label>
                            <input type="text" name="spol" class="form-control" value="<?php echo $spol; ?>">
                            <span class="help-block"><?php echo $spol_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Potvrdi">
                        <a href="index.php" class="btn btn-default">Ponisti i povratak na glavnu stranicu</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
