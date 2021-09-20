    <h1>Turmas</h1>
<?php


#----------Processamento dos dados recebidos do formulário ------
if(isset($_GET['acao'])){
    if($_GET['acao']=="salvar"){
        if($_POST['enviar-turma']){
            $professor=new Professor();
            $professor->setProfessor($_POST['codigo-professor-turma'], null);
            $turma=new Turma();
            
            $turma->setTurma(
                $_POST['codigo_turma'], 
                $_POST['curso-turma'],
                $_POST['nome-turma'],
                $professor
            );
            
            if($turma->salvar()){
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
           
            unset($turma);

        }
        
    }else if($_GET['acao']=="excluir"){
        if(isset($_GET['codigo'])){
            if(Turma::excluir($_GET['codigo'])){
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
            $turma=Turma::getTurma($_GET['codigo']);
        }
    }
}

if(!isset($turma)){
    $turma=new Turma();
    $turma->setTurma(null,null,null,new Professor());
}

#------Formulário para cadastrar umA nova Turma/*99//////------------------
?>
<div class="container-fluid">
    <h2> Cadastro de Turmas</h2>
    <form name="form-turma" method="POST" action="?pagina=turmas&acao=salvar">
        <input type="hidden" name="codigo_turma" value="<?php echo $turma->getCodigo()?>"/>
        <div class="input-group mb-2 mb-2"> 
            <label class="input-group-text" for="inputGroupCurso">Curso</label>   
            <select class="form-select" name="curso-turma">
                <option value="<?php echo $turma->getCurso() ?>"><?php echo $turma->getCurso() ?></option>
                <option value="Inormática">Informática</option>
                <option value="Eletronica">Eletrônica</option>
                <option value="Eletrotécnica">Eletrotécnica</option>
                <option value="Macânica">Mecânica</option>
            </select>
        </div>
        <div class="input-group mb-2">
            <span class="input-group-text" >Nome da Turma:</span>
            <input type="text" class="form-control" id="nome-turma" name="nome-turma"  value="<?php echo $turma->getNome() ?>" >
        </div>
        <div class="input-group mb-2 mb-2"> 
            <label class="input-group-text" for="inputGroupProfessor">Professor</label>   
            <select class="form-select" name="codigo-professor-turma">
                <option value="<?php echo $turma->getProfessor()->getCodigo()  ?>"><?php echo $turma->getProfessor()->getNome()  ?></option>
                <?php
                    $professor=new Professor();
                    $professores=$professor->listar();
                    if($professores){
                        foreach($professores AS $item){
                            echo "<option value='{$item->getCodigo()}'>{$item->getNome()}</option>";
                        }
                        
                    }
                ?>
            </select>
        </div>
        <input type="submit" class="btn btn-primary" name="enviar-turma" value="Enviar"/>
        
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
            <th scope="col">Turma</th>
            <th scope="col">Curso</th>
            <th scope="col">Professor</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $turmas=Turma::listar();
                foreach($turmas As $turma){
                    echo"<tr>
                    <td>{$turma->getCodigo()}</td>
                    <td>{$turma->getNome()}</td>
                    <td>{$turma->getCurso()}</td>
                    <td>{$turma->getProfessor()->getNome()}</td>
                    <td>
                        <span class='badge rounded-pill bg-primary'>
                            <a href='?pagina=turmas&acao=editar&codigo={$turma->getCodigo()}' style='color:#fff'><i class='bi bi-pencil-square'></i></a>
                        </span>
                        <span class='badge rounded-pill bg-danger'>
                            <a href='?pagina=turmas&acao=excluir&codigo={$turma->getCodigo()}'style='color:#fff'><i class='bi bi-trash'></i></a>
                        </span>
                    </td>
                    </tr>";
                }
            ?>
        </tbody>
    </table>
</div>