<?php
// Inicia a sessão
session_start();
 
// Verifica se o utilizador tem a sessão iniciada, se não envia-o para a página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Projeto Final API</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS -->
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="styles.css" />
    </head>
    <body> 
        <nav class="navbar NavPer">
        </div>

            <form 
                    id ="btnir" class="form-inline mx-auto justify-content-center" action="">
                <input
                    id="estiloNavbar"
                    class="form-control mr-sm-2"
                    type="search"
                    value=""
                    placeholder="Digite algo"
                    aria-label="Search"
                />
                <button
                    class="btn btn-outline-light my-2 my-sm-0 ButtonStyles"
                    type="submit"
                >
                    Pesquisar
                </button>
            </form>

            <a href="logout.php"
                    >
                    <button class="btn btn-outline-light my-2 my-sm-0 ButtonStyles"
                    type="submit">
                    Logout
                </button>
                   
                </a>
        </nav>
    <section id ="sec">
        <div id="firstcontainer"class= "ContainerSize">
        </div>
        </div>
        </section>
        <footer class="mt-auto d-block alert-secondary py-2 bottom" style="text-align: center; position: relative; bottom: 0;">
            <div class="container-fluid">
                <p class="nfooter">&copy;Bruno Ribeiro nº21514</p> 
                 <p class="nfooter">ECGM Tecnologias Web</p>
            </div>
        </footer>
        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"
        ></script>
        <script src="script.js"></script>
    </body>
</html>
