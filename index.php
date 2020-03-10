<?php
session_start();
$alertas = [];
if(isset($_SESSION['messages']))
{
    $alertas = $_SESSION['messages'];
    unset($_SESSION['messages']); // para não exibir ao dar F5
}

$old = [];
if(isset($_SESSION['old']))
{
    $old = $_SESSION['old'];
    unset($_SESSION['old']); // para limpart ao dar F5
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>TESTE PROGRAMADOR PHP</title>
        <meta name="description" content="TESTE PROGRAMADOR PHP">
        <meta name="author" content="Arthur Lehdermann">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="py-5 text-center">
                <a href="https://www.acaodireta.com.br/trabalhe-conosco" target="_blank">
                    <img src="assets/images/acao-direta.png" width="228" height="52" border="0"/>
                </a>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php
foreach ($alertas as $tipo => $mensagem)
{
?>
                    <div class="alert alert-<?=$tipo?> autoclose alert-dismissible fade show" role="alert">
                        <?=$mensagem?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
<?php
}
?>
                </div>
            </div>
            <form action="contato.php" method="post" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="nome">Nome: </label>
                            <input type="text" id="nome" name="nome" class="form-control" aria-describedby="nome" placeholder="Seu nome" value="<?php echo isset($old['nome']) ? $old['nome'] : ''; ?>" required <?php echo (empty($old) ? 'autofocus' : ''); ?>/>
                            <div class="invalid-feedback">
                                Você precisa informar seu nome.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="email">E-mail: </label>
                            <input type="email" id="email" name="email" class="form-control" aria-describedby="email" placeholder="Seu e-mail" value="<?php echo isset($old['email']) ? $old['email'] : ''; ?>" required/>
                            <div class="invalid-feedback">
                                Você precisa informar seu endereço de e-mail.
                            </div>
                            <small id="emailHelp" class="form-text text-muted text-right">Nunca compartilharemos seu e-mail com mais ninguém.</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="telefone">Telefone: </label>
                            <input type="text" id="telefone" name="telefone" class="form-control" placeholder="(__) _____-____" data-slots="_" value="<?php echo isset($old['telefone']) ? $old['telefone'] : ''; ?>" required/>
                            <div class="invalid-feedback">
                                Você precisa informar seu telefone.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <hr class="mb-4">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Enviar</button>
                    </div>
                </div>
            </form>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy;2020 <b>Arthur Lehdermann</b></p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="https://www.linkedin.com/in/arthurlehdermann" target="_blank">LinkedIn</a></li>
                <li class="list-inline-item"><a href="https://www.facebook.com/ArthurLehdermann" target="_blank">Facebook</a></li>
                <li class="list-inline-item"><a href="https://wa.me/5551982070138" target="_blank">Whatsapp</a></li>
            </ul>
        </footer>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="assets/js/scripts.js"></script>
    </body>
</html>