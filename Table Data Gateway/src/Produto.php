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
    public function setConnection(\PDO $connection): void
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
    public static function find(int $id): self
    {
        $gateway = new ProdutoGateway(self::$connection);
        return $gateway->find($id);
    }

    /**
     * @param string $filter
     * @return array
     */
    public static function all($filter = ''): array
    {
        $gateway = new ProdutoGateway(self::$connection);
        return $gateway->all($filter);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(): bool
    {
        $gateway = new ProdutoGateway(self::$connection);
        return $gateway->delete((int) $this->id);
    }

    /**
     * @param int|null $id
     * @return bool
     */
    public function save(): bool
    {
        $gateway = new ProdutoGateway(self::$connection);
        return $gateway->save($this);
    }
}
