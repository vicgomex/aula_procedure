<?php
//capturar id da url
$id = filter_input(INPUT_GET, 'id');

include_once '../models/Curso.php';
$curso = new Curso();

if (isset($id)) {
    $dados = $curso->consultar($id);
    foreach ($dados as $mostrar) {
        $professor = $mostrar['curso_professor'];
        $nome = $mostrar['curso_professor'];
    }
}
?>
<div class="card shadow col-md-8 col-sm-12">
    <h3 class="ml-3 mt-3 text-primary">
        <?= isset($id) ? "Editar " : "Cadastrar " ?> curso
    </h3>
    <form method="post" name="formsalvar" id="formSalvar" class="m-3" enctype="multipart/form-data">
        <?= isset($id) ? "ID " . $id : "" ?>

        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">
                Professor
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="txtprofessor" name="txtprofessor" placeholder="Professor"
                    value="<?= isset($id) ? $professor : "" ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputText" class="col-sm-2 col-form-label">
                Nome
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="txtsigla" name="txtnome" placeholder="Nome"
                    value="<?= isset($id) ? $nome : "" ?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <input type="submit"
                    class="btn <?= isset($id) ? "btn-success" : "btn-primary" ?>"
                    name="<?= isset($id) ? "btneditar" : "btnsalvar" ?>"
                    value="<?= isset($id) ? "Editar" : "Salvar" ?>">
            </div>
            <a href="?p=curso/consultar" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>

<?php
if (filter_input(INPUT_POST, 'btnsalvar')) {
    $professor = filter_input(INPUT_POST, 'txtprofessor');
    $nome = filter_input(INPUT_POST, 'txtnome');

    include_once '../models/Curso.php';
    $curso = new Curso();

    $curso->setId(NULL);
    $curso->setProfessor($professor);
    $curso->setNome($nome);

    if ($curso->crud(0)) {
        ?>
        <div class="alert alert-primary mt-3" role="alert">
            Cadastro efetuado com sucesso
        </div>
        <meta http-equiv="refresh" content="0.2;URL=?p=curso/consultar">
        <?php
    }
}

if (filter_input(INPUT_POST, 'btneditar')) {
    $professor = filter_input(INPUT_POST, 'txtprofessor');
    $nome = filter_input(INPUT_POST, 'txtnome');

    $curso->setId($id);
    $curso->setProfessor($professor);
    $curso->setNome($nome);

    if ($curso->crud(1)) {
        ?>
        <div class="alert alert-success mt-3" role="alert">
            Editado efetuado com sucesso
        </div>
        <meta http-equiv="refresh" content="0.2;URL=?p=curso/consultar">
        <?php
    }
}
