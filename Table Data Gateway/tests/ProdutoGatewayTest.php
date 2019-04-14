<?php

declare(strict_types=1);

namespace Tests;

use App\Produto;
use App\ProdutoGateway;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class ProdutoGatewayTest extends TestCase
{
    /** @var \PDO */
    private $pdo;

    /** @var Produto */
    private $produto;

    /** @var \PDOStatement */
    private $pdoStatement;

    /** @var ProdutoGateway */
    private $produtoGateway;

    protected function setUp()
    {
        $this->pdo = $this->prophesize(\PDO::class);
        $this->pdoStatement = $this->prophesize(\PDOStatement::class);
        $this->produto = $this->prophesize(Produto::class);

        $this->pdo->query(Argument::type('string'))->will([$this->pdoStatement, 'reveal']);
        $this->pdo->exec(Argument::type('string'))->will([$this->pdoStatement, 'reveal']);

        $this->produtoGateway = new ProdutoGateway($this->pdo->reveal());
    }

    public function testFindOne()
    {
        $this->pdoStatement->fetchObject(Argument::type('string'))->will([$this->produto, 'reveal']);

        $produto = $this->produtoGateway->find(1);

        $this->assertInstanceOf(Produto::class, $produto);
    }

    public function testFindAll()
    {
        $this->pdoStatement->fetchAll(Argument::type('integer'), Argument::type('string'))->willReturn(['value']);

        $produtos = $this->produtoGateway->all();

        $this->assertIsArray($produtos);
    }

    public function testSaveOnInsert()
    {
        $produto = new Produto();

        $produto->id = '';
        $produto->descricao = "Teste";
        $produto->estoque = 10;
        $produto->preco_custo = 100;
        $produto->preco_venda = 200;
        $produto->codigo_barras = '85830022';
        $produto->data_cadastro = date('Y-m-d');
        $produto->origem = 'N';

        $this->assertTrue($this->produtoGateway->save($produto));
    }

    public function testSaveOnUpdate()
    {
        $produto = new Produto();

        $produto->id = 1;
        $produto->descricao = "Teste";
        $produto->estoque = 10;
        $produto->preco_custo = 100;
        $produto->preco_venda = 200;
        $produto->codigo_barras = '85830022';
        $produto->data_cadastro = date('Y-m-d');
        $produto->origem = 'N';

        $this->assertTrue($this->produtoGateway->save($produto));
    }

    public function testDelete()
    {
        $this->assertTrue($this->produtoGateway->delete(1));
    }

    public function testGetLastId()
    {
        $id = $this->produtoGateway->getLastId();

        $this->assertIsInt($id);
    }
}
