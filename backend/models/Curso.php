<?php

include_once 'Conn.php';

class Curso
{
    private $id;
    private $professor;
    private $nome;
    private $con;
    private $table = "tb_curso";

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getProfessor()
    {
        return $this->professor;
    }

    public function setProfessor($professor)
    {
        $this->professor = $professor;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function crud($opcao)
    {
        try {
            $this->con = new Conn();
            $sql = "CALL crud_curso(?, ?, ?, ?)";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $this->id);
            $executar->bindValue(2, mb_strtoupper($this->professor));
            $executar->bindValue(3, mb_strtoupper($this->nome));
            $executar->bindValue(4, $opcao);
            return $executar->execute() == 1 ? true : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function consultar($var_id)
    {
        try {
            $this->con = new Conn();
            $sql = "CALL listar_curso(?)";
            $executar = $this->con->prepare($sql);
            $executar->bindValue(1, $var_id);
            return $executar->execute() == 1 ? $executar->fetchAll() : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function pesquisar($filtros)
    {
        $where = "";
        $params = "";
        $this->con = new Conn();

        if (!empty($filtros[0] == 'professor')) {
            $where = "curso_professor LIKE ?";
            $params = "%" . $filtros[1] . "%";
        }
        if (!empty($filtros[0] == 'sigla')) {
            $where = "curso_nome LIKE ?";
            $params = mb_strtoupper($filtros[1]) . "%";
        }
        $sql = "SELECT * FROM {$this->table} WHERE $where ORDER BY curso_professor ASC";

        $executar = $this->con->prepare($sql);
        $executar->bindValue(1, $params);

        return $executar->execute() == 1 ? $executar->fetchAll() : false;
    }

    /**
     * Retorna o total de registros da tabela
     */
    public function totalRegistros()
    {
        try {
            $this->con = new Conn();
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $executar = $this->con->prepare($sql);
            $executar->execute();
            $row = $executar->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * Paginação de registros
     * @param int $pagina -> página atual
     * @param int $limite -> quantos registros por página
     */
    public function paginar($pagina = 1, $limite = 10)
    {
        try {
            $this->con = new Conn();

            // Calcula o offset
            $offset = ($pagina - 1) * $limite;

            $sql = "SELECT * FROM {$this->table} 
                    ORDER BY curso_professor ASC 
                    LIMIT :limite OFFSET :offset";

            $executar = $this->con->prepare($sql);
            $executar->bindValue(":limite", (int) $limite, PDO::PARAM_INT);
            $executar->bindValue(":offset", (int) $offset, PDO::PARAM_INT);

            return $executar->execute() == 1 ? $executar->fetchAll(PDO::FETCH_ASSOC) : false;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }
}
