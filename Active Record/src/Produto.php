<?php

declare(strict_types=1);

namespace App;

class Produto
{
    /** @var \PDO */
    private static $connection;

    /** @var array */
    private $data;

    /**
     * @param \PDO $conn
     */
    public static function setConnection(\PDO $connection): void
    {
        self::$connection = $connection;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param int $id
     * @return array
     */
    public static function find(int $id): Produto
    {
        $sql = "SELECT * FROM produto WHERE id = {$id}";
        $result = self::$connection->query($sql);

        return $result->fetchObject(__CLASS__);
    }

    /**
     * @param string $filter
     * @return array
     */
    public static function all(string $filter = null): array
    {
        $sql = "SELECT * FROM produto ";

        if ($filter) {
            $sql .= "WHERE {$filter}";
        }

        $result = self::$connection->query($sql);

        return $result->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * @param $data
     * @param int|null $id
     * @return bool
     */
    public function save(): bool
    {
        if (empty((int) $this->id)) {
            $id = $this->getLastId() + 1;

            $sql = "INSERT INTO produto (id, descricao, estoque, preco_custo, " .
                "preco_venda, codigo_barras, data_cadastro, origem)" .
                "VALUES ('{$id}', " .
                "'{$this->descricao}', " .
                "'{$this->estoque}', " .
                "'{$this->preco_custo}', " .
                "'{$this->preco_venda}', " .
                "'{$this->codigo_barras}', " .
                "'{$this->data_cadastro}', " .
                "'{$this->origem}')";
        } else {
            $sql = "UPDATE produto SET " .
                " descricao = '{$this->descricao}', " .
                " estoque = '{$this->estoque}', " .
                " preco_custo = '{$this->preco_custo}', " .
                " preco_venda = '{$this->preco_venda}', " .
                " codigo_barras = '{$this->codigo_barras}', " .
                " data_cadastro = '{$this->data_cadastro}', " .
                " origem = '{$this->origem}' ".
                "WHERE id = '{$this->id}'";
        }

        return (bool) self::$connection->exec($sql);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(): bool
    {
        $sql = "DELETE FROM produto WHERE id = {$this->id}";

        return (bool) self::$connection->query($sql);
    }

    /**
     * @return int
     */
    public function getLastId(): int
    {
        $sql = "SELECT MAX(id) as max FROM produto";

        $result = self::$connection->query($sql);

        return (int) $result->fetch(\PDO::FETCH_ASSOC)['max'];
    }

    /**
     * @return float
     */
    public function getMargemLucro(): float
    {
        return (($this->preco_venda - $this->preco_custo) / $this->preco_custo) * 100;
    }

    /**
     * @param float $custo
     * @param int $quantidade
     */
    public function registraCompra(float $custo, int $quantidade): void
    {
        $this->custo = $custo;
        $this->estoque += $quantidade;
    }
}
