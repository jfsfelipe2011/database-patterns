<?php

declare(strict_types=1);

namespace App;

class ProdutoGateway
{
    /** @var \PDO */
    private $connection;

    /**
     * ProdutoGateway constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param int $id
     * @return array
     */
    public function find(int $id): Produto
    {
        $sql = "SELECT * FROM produto WHERE id = {$id}";
        $result = $this->connection->query($sql);

        return $result->fetchObject(Produto::class);
    }

    /**
     * @param string $filter
     * @return array
     */
    public function all(string $filter = null): array
    {
        $sql = "SELECT * FROM produto ";

        if ($filter) {
            $sql .= "WHERE {$filter}";
        }

        $result = $this->connection->query($sql);

        return $result->fetchAll(\PDO::FETCH_CLASS, Produto::class);
    }

    /**
     * @param $data
     * @param int|null $id
     * @return bool
     */
    public function save(Produto $data): bool
    {
        if (empty((int) $data->id)) {
            $id = $this->getLastId() + 1;

            $sql = "INSERT INTO produto (id, descricao, estoque, preco_custo, " .
                   "preco_venda, codigo_barras, data_cadastro, origem)" .
                   "VALUES ('{$id}', " .
                   "'{$data->descricao}', " .
                   "'{$data->estoque}', " .
                   "'{$data->preco_custo}', " .
                   "'{$data->preco_venda}', " .
                   "'{$data->codigo_barras}', " .
                   "'{$data->data_cadastro}', " .
                   "'{$data->origem}')";
        } else {
            $sql = "UPDATE produto SET " .
                   " descricao = '{$data->descricao}', " .
                   " estoque = '{$data->estoque}', " .
                   " preco_custo = '{$data->preco_custo}', " .
                   " preco_venda = '{$data->preco_venda}', " .
                   " codigo_barras = '{$data->codigo_barras}', " .
                   " data_cadastro = '{$data->data_cadastro}', " .
                   " origem = '{$data->origem}' ".
                   "WHERE id = '{$data->id}'";
        }

        return (bool) $this->connection->exec($sql);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM produto WHERE id = {$id}";

        return (bool) $this->connection->query($sql);
    }

    /**
     * @return int
     */
    public function getLastId(): int
    {
        $sql = "SELECT MAX(id) as max FROM produto";

        $result = $this->connection->query($sql);

        return (int) $result->fetch(\PDO::FETCH_ASSOC)['max'];
    }
}
