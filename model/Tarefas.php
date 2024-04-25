<?php // model/Tarefas.php

class Tarefa {
    private $conn;
    private $table_name = 'tarefas';

    public $id_tarefa;
    public $id_usuario;
    public $titulo;
    public $descricao;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar usuário
    public function create() {
        $query = 'INSERT INTO ' . $this->table_name . ' SET titulo = :titulo, descricao = :descricao, id_usuario = :id_usuario';
        $stmt = $this->conn->prepare($query);
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler usuários
    public function getAll() {
        $query = 'SELECT * FROM ' . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obter usuário pelo ID
    public function getTarefaById($id_tarefa) {
        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE id_tarefa = :id_tarefa';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_tarefa', $id_tarefa);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->titulo = $row['titulo'];
            $this->descricao = $row['descricao'];
            $this->id_usuario = $row['id_usuario'];
            return $row;
        }
        return [];
    }


    // Atualizar usuário
    public function update() {
        $query = 'UPDATE ' . $this->table_name . ' SET titulo = :titulo, descricao = :descricao, id_usuario = :id_usuario WHERE id_tarefa = :id_tarefa';
        $stmt = $this->conn->prepare($query);
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $this->id_tarefa = htmlspecialchars(strip_tags($this->id_tarefa));
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':id_tarefa', $this->id_tarefa);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Deletar usuário
    public function remove() {
        $query = 'DELETE FROM ' . $this->table_name . ' WHERE id_tarefa = :id_tarefa';
        $stmt = $this->conn->prepare($query);

        $this->id_tarefa = (int) $this->id_tarefa;
        $stmt->bindParam(':id_tarefa', $this->id_tarefa);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Buscar uma tarefa pelo idUsuario
    public function getByUserId($id_usuario) {
        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE id_usuario = :id_usuario';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id_tarefa = $row['id_tarefa'];
            $this->titulo = $row['titulo'];
            $this->descricao = $row['descricao'];
            $this->id_usuario = $row['id_usuario'];
            return $row;
        }
        return [];
    }
}


