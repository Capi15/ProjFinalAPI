<?php
// precisa do config.php
require_once "config.php";
 
// Define e inicia as variáveis com um valor vazio("")
$username = $passord = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processa os dados do formulário quando este é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Verifica se é possivel usar esse username
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor digite um nome de Utilizador!.";
    } else{
        // Prepara-se para fazer um SELECT para verificar se o utilizador já existe
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Liga as variáveis à declaração preparada no parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Define os parametros
            $param_username = trim($_POST["username"]);
            
            // tenta executar a frase preparada
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "Este nome de utilizador já exite, tente outro!";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Alguma coisa correu mal, por favor tente outra vez";
            }
        }
         
        // fecha a declaração
        unset($stmt);
    }
    
    // Validação da password
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor digite uma palavra-passe.";     
    } elseif(strlen(trim($_POST["password"])) < 4){
        $password_err = "A palavra-passe deve ter pelo menos 4 carateres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validação da comfirmação da password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor comfirme a palavra-passe.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "A palavra-passe que digitou não corresponde!";
        }
    }
    
    //Verifica o envio de erros antes de inserir na base de dados
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepara para inserir a declaração
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
         
        if($stmt = $pdo->prepare($sql)){
            // Liga as variáveis declaradas como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Define os parametros
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Cria uma palavra-passe hash
            
            // Tenta executar a declaração
            if($stmt->execute()){
                // Redireciona para a página de login
                header("location: login.php");
            } else{
                echo "Algo correu mal! Por favor tente outra vez.";
            }
        }
         
        // Fecha a declaração
        unset($stmt);
    }
    
    // Termina a ligação
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Regista-te</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="styles.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper regis">
        <h2>Regista-te!</h2>
        <p>Por favor preencha este formolário para criar uma conta.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Nome de Utilizador</label>
                <input type="text" name="username" class="form-control Irad" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Palavra-passe</label>
                <input type="password" name="password" class="form-control Irad" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Comfirmação da palavra-passe</label>
                <input type="password" name="confirm_password" class="form-control Irad" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary ButtonStyles" value="Enviar">
                <input type="reset" class="btn btn-default ButtonStyles" value="Limpar dados">
            </div>
            <p>Já possui uma conta? <a href="login.php">Inicie aqui a sua sessão</a>.</p>
        </form>
    </div>  
</body>
</html>