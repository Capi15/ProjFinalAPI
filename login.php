<?php
// Iniciar sessão
session_start();
 
// Verifica se o utilizador tem sessão iniciada, e se sim redireciona-o para a página inicial
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Inclui o ficheiro config.php
require_once "config.php";
 
// Define variáveis e inicia-as com o valor vazio("")
$username = $password = "";
$username_err = $password_err = "";
 
// Processa os dados do formulário que é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Verifica se o username está vazio
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor digite o seu nome de utilizador.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Verifica se a password está vazia
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor digite a sua palavra-passe.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Valida as credenciais
    if(empty($username_err) && empty($password_err)){
        // Prepara uma declaração SELECT
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parâmeters
            // Liga as variáveis que foram declaradas como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Define os parametros
            $param_username = trim($_POST["username"]);
            
            // Tenta executar a declaração criada
            if($stmt->execute()){
                // Verifica se o username existe, se sim verifica a password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            // Se a password for a correta inicia a sessão
                            session_start();
                            
                            // Armazena os dados da sessão nas variaveis
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redireciona o utilizador para a página inicial
                            header("location: index.php");
                        } else{
                            // Mostra uma mensagem de erro caso a password seja a incorreta 
                            $password_err = "A palavra-passe que introduziu está incorreta.";
                        }
                    }
                } else{
                    // Mostra uma mensagem de erro se o username não existir
                    $username_err = "Não foi encontrada nebhuma conta com esse nome.";
                }
            } else{
                echo "Oops! Algo correu mal! Por favor tente novamente.";
            }
        }
        
        // Fecha a declaração
        unset($stmt);
    }
    
    // Fecha a ligação
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sessão</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="styles.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper regis">
        <h2>Iniciar Sessão</h2>
        <p>Por favor introduza as suas credenciais para iniciar sessão.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Nome de utilizador</label>
                <input type="text" name="username" class="form-control Irad" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Palavra-passe</label>
                <input type="password" name="password" class="form-control Irad">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary ButtonStyles" value="Iniciar sessão">
            </div>
            <p>Não possui uma conta? <a href="register.php">Registe-se agora</a>.</p>
        </form>
    </div>
</body>
</html>