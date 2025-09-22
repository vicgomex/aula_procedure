<div class="col-sm-12 mb-4">

    <div class="card shadow mb-4">
        <div class="table-responsive-sm mt-4">
            <h3 class="ml-3">
                Listar Cursos
                <a class="btn btn-success float-right mb-3 mr-3" href="?p=curso/salvar">
                    <i class="bi bi-database-add"></i>
                </a>
            </h3>

            <!-- Filtros -->
            <form id="form-filtro" class="form-inline mb-3 ml-3" method="post">
                <input type="text" class="form-control mr-2" name="professor" placeholder="Professor">
                <input type="text" class="form-control mr-2" name="nome" placeholder="Nome">
                <input type="submit" class="btn btn-primary" name="enviar" value="Pesquisar">
                <button type="reset" id="btn-reset" class="btn btn-secondary ml-2">Limpar</button>
            </form>

            <table class="table table-striped table-sm" id="tabela-cursos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Professor</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (filter_input(INPUT_POST, 'enviar')) {

                        $professor = filter_input(INPUT_POST, 'professor');
                        $nome = filter_input(INPUT_POST, 'nome');

                        $filtros = [];
                        if (empty($professor) && empty($nome)) {
                            echo "<script>alert('Preencha ao menos um campo para pesquisar');</script>";
                            exit;
                        } else if (!empty($professor)) {
                            $filtros[0] = 'professor';
                            $filtros[1] = $professor;
                        } else if (!empty($nome)) {
                            $filtros[0] = 'nome';
                            $filtros[1] = $nome;
                        }

                        include_once '../models/Curso.php';
                        $curso = new Curso();
                        $dados = $curso->pesquisar(filtros: $filtros);
                        foreach ($dados as $mostrar) { ?>
                            <tr>
                                <td><?= $mostrar['curso_id'] ?></td>
                                <td><?= $mostrar['curso_professor'] ?></td>
                                <td><?= $mostrar['curso_nome'] ?></td>
                                <td>
                                    <a href="?p=curso/excluir&id=<?= $mostrar['curso_id'] ?>" class="btn btn-danger btn-sm" title="Excluir">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                    <a href="?p=curso/salvar&id=<?= $mostrar['curso_id'] ?>" class="btn btn-secondary btn-sm" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>