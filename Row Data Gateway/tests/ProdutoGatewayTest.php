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

    /** @var \PDOStatement */
    private $pdoStatement;

    /** @var ProdutoGateway */
    private $produtoGateway;

    protected function setUp()
    {
        $this->pdo = $this->prophesize(\PDO::class);
        $this->pdoStatement = $this->prophesize(\PDOStatement::class);
        $this->produtoGateway = $this->prophesize(ProdutoGateway::class);

        $this->pdo->query(Argument::type('string'))->will([$this->pdoStatement, 'reveal']);
        $this->pdo->exec(Argument::type('string'))->will([$this->pdoStatement, 'reveal']);
    }

    public function testFindOne()
    {
        $this->pdoStatement->fetchObject(Argument::type('string'))
            ->will([$this->produtoGateway, 'reveal']);

        ProdutoGateway::setConnection($this->pdo->reveal());
        $produto = ProdutoGateway::find(1);

        $this->assertInstanceOf(ProdutoGateway::class, $produto);
    }

    public function testFindAll()
    {
        $this->pdoStatement->fetchAll(Argument::type('integer'), Argument::type('string'))
            ->willReturn(['value']);

        ProdutoGateway::setConnection($this->pdo->reveal());
        $produtos = ProdutoGateway::all();

        $this->assertIsArray($produtos);
    }

    public function testSaveOnInsert()
    {
        ProdutoGateway::setConnection($this->pdo->reveal());
        $produtoGateway = new ProdutoGateway();

        $produtoGateway->id = '';
        $produtoGateway->descricao = "Teste";
        $produtoGateway->estoque = 10;
        $produtoGateway->preco_custo = 100;
        $produtoGateway->preco_venda = 200;
        $produtoGateway->codigo_barras = '85830022';
        $produtoGateway->data_cadastro = date('Y-m-d');
        $produtoGateway->origem = 'N';

        $this->assertTrue($produtoGateway->save());
    }

    public function testSaveOnUpdate()
    {
        ProdutoGateway::setConnection($this->pdo->reveal());
        $produtoGateway = new ProdutoGateway();

        $produtoGateway->id = 1;
        $produtoGateway->descricao = "Teste";
        $produtoGateway->estoque = 10;
        $produtoGateway->preco_custo = 100;
        $produtoGateway->preco_venda = 200;
        $produtoGateway->codigo_barras = '85830022';
        $produtoGateway->data_cadastro = date('Y-m-d');
        $produtoGateway->origem = 'N';

        $this->assertTrue($produtoGateway->save());
    }

    public function testDelete()
    {
        $this->pdoStatement->fetchObject(Argument::type('string'))
            ->will([$this->produtoGateway, 'reveal']);

        $this->produtoGateway->delete()->willReturn(true);

        ProdutoGateway::setConnection($this->pdo->reveal());
        $produto = ProdutoGateway::find(1);

        $this->assertTrue($produto->delete());
    }

    public function testGetLastId()
    {
        ProdutoGateway::setConnection($this->pdo->reveal());
        $produto = new ProdutoGateway();
        $id = $produto->getLastId();

        $this->assertIsInt($id);
    }
}
