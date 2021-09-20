    <h1>Professores</h1>
<?php


#----------Processamento dos dados recebidos do formulário ------
if(isset($_GET['acao'])){
    if($_GET['acao']=="salvar"){
        if($_POST['enviar-professor']){

            $professor=new Professor();
            
            $professor->setProfessor(
                $_POST['codigo_professor'], 
                $_POST['nome-professor']
            );
            
            if($professor->salvar()){
                echo "<div id='msg' class='alert alert-success'>Registro salvo com sucesso!</div>";
            }else{
                echo "<div id='msg' class='alert alert-danger'>Falha ao salvar o registro!</div>";
            }
           
            echo "<script> 
                setTimeout(
                    function(){
                        document.querySelector('#msg').style='display:none';
                    }
                    ,
                    3000
                );
            </script>";
           
            unset($professor);

        }
        
    }else if($_GET['acao']=="excluir"){
        if(isset($_GET['codigo'])){
            if(Professor::excluir($_GET['codigo'])){
                echo "<div id='msg' class='alert alert-success'>Registro excluido com sucesso!</div>";
            }else{
                echo "<div id='msg' class='alert alert-danger'>Falha ao excluir o registro!</div>";
            }
            echo "<script> 
                setTimeout(
                    function(){
                        document.querySelector('#msg').style='display:none';
                    }
                    ,
                    3000
                );
            </script>";
        }
        
    }else if($_GET['acao']=="editar"){
        if(isset($_GET['codigo'])){
            $professor=Professor::getProfessor($_GET['codigo']);
        }
    }
}

if(!isset($professor)){
    $professor=new Professor();
    $professor->setProfessor(null,null);
}

#------Formulário para cadastrar umA nova Turma/*99//////------------------
?>
<div class="container-fluid">
    <h2> Cadastro de Professores</h2>
    <form name="form-professor" method="POST" action="?pagina=professores&acao=salvar">
        <input type="hidden" name="codigo_professor" value="<?php echo $professor->getCodigo()?>"/>

        <div class="input-group mb-2">
            <span class="input-group-text" >Nome do Professor:</span>
            <input type="text" class="form-control" id="nome-professor" name="nome-professor"  value="<?php echo $professor->getNome() ?>" >
        </div>
        
        <input type="submit" class="btn btn-primary" name="enviar-professor" value="Enviar"/>
        
    </form>
    <hr/>
</div>

<?php


#---------Listar os usuários -----------------------
?>
<div class="container-fluid">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $professores=Professor::listar();
                foreach($professores As $professor){
                    echo"<tr>
                    <td>{$professor->getCodigo()}</td>
                    <td>{$professor->getNome()}</td>
                    <td>
                        <span class='badge rounded-pill bg-primary'>
                            <a href='?pagina=professores&acao=editar&codigo={$professor->getCodigo()}' style='color:#fff'><i class='bi bi-pencil-square'></i></a>
                        </span>
                        <span class='badge rounded-pill bg-danger'>
                            <a href='?pagina=professores&acao=excluir&codigo={$professor->getCodigo()}'style='color:#fff'><i class='bi bi-trash'></i></a>
                        </span>
                    </td>
                    </tr>";
                }
            ?>
        </tbody>
    </table>
</div>