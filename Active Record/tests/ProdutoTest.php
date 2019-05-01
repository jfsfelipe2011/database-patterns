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

    /** @var \PDOStatement */
    private $pdoStatement;

    /** @var Produto */
    private $produto;

    protected function setUp()
    {
        $this->pdo = $this->prophesize(\PDO::class);
        $this->pdoStatement = $this->prophesize(\PDOStatement::class);
        $this->produto = $this->prophesize(Produto::class);

        $this->pdo->query(Argument::type('string'))->will([$this->pdoStatement, 'reveal']);
        $this->pdo->exec(Argument::type('string'))->will([$this->pdoStatement, 'reveal']);
    }

    public function testFindOne()
    {
        $this->pdoStatement->fetchObject(Argument::type('string'))
            ->will([$this->produto, 'reveal']);

        Produto::setConnection($this->pdo->reveal());
        $produto = Produto::find(1);

        $this->assertInstanceOf(Produto::class, $produto);
    }

    public function testFindAll()
    {
        $this->pdoStatement->fetchAll(Argument::type('integer'), Argument::type('string'))
            ->willReturn(['value']);

        Produto::setConnection($this->pdo->reveal());
        $produtos = Produto::all();

        $this->assertIsArray($produtos);
    }

    public function testSaveOnInsert()
    {
        Produto::setConnection($this->pdo->reveal());
        $produto = new Produto();

        $produto->id = '';
        $produto->descricao = "Teste";
        $produto->estoque = 10;
        $produto->preco_custo = 100;
        $produto->preco_venda = 200;
        $produto->codigo_barras = '85830022';
        $produto->data_cadastro = date('Y-m-d');
        $produto->origem = 'N';

        $this->assertTrue($produto->save());
    }

    public function testSaveOnUpdate()
    {
        Produto::setConnection($this->pdo->reveal());
        $produto = new Produto();

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
        $this->pdoStatement->fetchObject(Argument::type('string'))
            ->will([$this->produto, 'reveal']);

        $this->produto->delete()->willReturn(true);

        Produto::setConnection($this->pdo->reveal());
        $produto = Produto::find(1);

        $this->assertTrue($produto->delete());
    }

    public function testGetLastId()
    {
        Produto::setConnection($this->pdo->reveal());
        $produto = new Produto();
        $id = $produto->getLastId();

        $this->assertIsInt($id);
    }

    public function testGetMargemLucro()
    {
        Produto::setConnection($this->pdo->reveal());
        $produto = new Produto();

        $produto->id = 1;
        $produto->descricao = "Teste";
        $produto->estoque = 10;
        $produto->preco_custo = 100;
        $produto->preco_venda = 200;
        $produto->codigo_barras = '85830022';
        $produto->data_cadastro = date('Y-m-d');
        $produto->origem = 'N';

        $this->assertIsFloat($produto->getMargemLucro());
        $this->assertEquals(100, $produto->getMargemLucro());
    }

    public function testRegistraCompra()
    {
        Produto::setConnection($this->pdo->reveal());
        $produto = new Produto();

        $produto->id = 1;
        $produto->descricao = "Teste";
        $produto->estoque = 10;
        $produto->preco_custo = 100;
        $produto->preco_venda = 200;
        $produto->codigo_barras = '85830022';
        $produto->data_cadastro = date('Y-m-d');
        $produto->origem = 'N';

        $this->assertEquals(10, $produto->estoque);

        $produto->registraCompra(100, 2);

        $this->assertEquals(100, $produto->custo);
        $this->assertEquals(12, $produto->estoque);
    }
}
