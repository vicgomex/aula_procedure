<div class="col-sm-12 mb-4">

    <div class="card shadow mb-4">
        <div class="table-responsive-sm mt-4">
            <h3 class="ml-3">
                Listar Alunos
                <a class="btn btn-success float-right mb-3 mr-3" href="?p=aluno/salvar">
                    <i class="bi bi-database-add"></i>
                </a>
            </h3>

            <!-- Filtros -->
            <form id="form-filtro" class="form-inline mb-3 ml-3" method="post">
                <input type="text" class="form-control mr-2" name="serie" placeholder="Serie">
                <input type="text" class="form-control mr-2" name="nome" placeholder="Nome">
                <input type="submit" class="btn btn-primary" name="enviar" value="Pesquisar">
                <button type="reset" id="btn-reset" class="btn btn-secondary ml-2">Limpar</button>
            </form>

            <table class="table table-striped table-sm" id="tabela-alunos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Série</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (filter_input(INPUT_POST, 'enviar')) {

                        $serie = filter_input(INPUT_POST, 'serie');
                        $nome = filter_input(INPUT_POST, 'nome');

                        $filtros = [];
                        if (empty($serie) && empty($nome)) {
                            echo "<script>alert('Preencha ao menos um campo para pesquisar');</script>";
                            exit;
                        } else if (!empty($serie)) {
                            $filtros[0] = 'serie';
                            $filtros[1] = $serie;
                        } else if (!empty($nome)) {
                            $filtros[0] = 'nome';
                            $filtros[1] = $nome;
                        }

                        include_once '../models/Aluno.php';
                        $aluno = new Aluno();
                        $dados = $aluno->pesquisar(filtros: $filtros);
                        foreach ($dados as $mostrar) { ?>
                            <tr>
                                <td><?= $mostrar['aluno_id'] ?></td>
                                <td><?= $mostrar['aluno_serie'] ?></td>
                                <td><?= $mostrar['aluno_nome'] ?></td>
                                <td>
                                    <a href="?p=aluno/excluir&id=<?= $mostrar['aluno_id'] ?>" class="btn btn-danger btn-sm" title="Excluir">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                    <a href="?p=aluno/salvar&id=<?= $mostrar['aluno_id'] ?>" class="btn btn-secondary btn-sm" title="Editar">
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