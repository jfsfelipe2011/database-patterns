<?php

declare(strict_types=1);

namespace Tests;

use App\Produto;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class ProdutoTest extends TestCase
{
    /** @var \PDO */
    private $pdo;

    /** @var Produto */
    private $produto;

    /** @var \PDOStatement */
    private $pdoStatement;

    protected function setUp()
    {
        $this->pdo = $this->prophesize(\PDO::class);
        $this->pdoStatement = $this->prophesize(\PDOStatement::class);
        $this->produto = new Produto();

        $this->pdo->query(Argument::type('string'))->will([$this->pdoStatement, 'reveal']);
        $this->pdo->exec(Argument::type('string'))->will([$this->pdoStatement, 'reveal']);

        $this->produto->setConnection($this->pdo->reveal());
    }

    public function testFindOne()
    {
        $this->pdoStatement->fetchObject(Argument::type('string'))->willReturn($this->produto);

        $produto = $this->produto->find(1);

        $this->assertInstanceOf(Produto::class, $produto);
    }

    public function testFindAll()
    {
        $this->pdoStatement->fetchAll(Argument::type('integer'), Argument::type('string'))->willReturn(['value']);

        $produtos = $this->produto->all();

        $this->assertIsArray($produtos);
    }

    public function testSaveOnInsert()
    {
        $this->produto->id = '';
        $this->produto->descricao = "Teste";
        $this->produto->estoque = 10;
        $this->produto->preco_custo = 100;
        $this->produto->preco_venda = 200;
        $this->produto->codigo_barras = '85830022';
        $this->produto->data_cadastro = date('Y-m-d');
        $this->produto->origem = 'N';

        $this->assertTrue($this->produto->save());
    }

    public function testSaveOnUpdate()
    {
        $this->pdoStatement->fetchObject(Argument::type('string'))->willReturn($this->produto);

        $produto = $this->produto->find(1);
        $produto->id = 1;
        $produto->descricao = "Teste";
        $produto->estoque = 10;
        $produto->preco_custo = 100;
        $produto->preco_venda = 200;
        $produto->codigo_barras = '85830022';
        $produto->data_cadastro = date('Y-m-d');
        $produto->origem = 'N';

        $this->assertTrue($produto->save());
    }

    public function testDelete()
    {
        $this->assertTrue($this->produto->delete());
    }
}
