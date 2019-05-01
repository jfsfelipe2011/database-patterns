<?php

declare(strict_types=1);

use App\Produto;

require_once __DIR__ . '/vendor/autoload.php';

echo "======================Active Record======================";
echo "<br><br><br>";


try {
    $conn = new \PDO(
        'mysql:host=database-patterns;dbname=patterns;charset=utf8',
        'patterns',
        'patterns'
    );

    $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

Produto::setConnection($conn);

$produtos = Produto::all();

var_dump($produtos);
echo "<br><br><br>";

foreach ($produtos as $produto) {
    $produto->delete();
    echo "Produto {$produto->id} deletado com sucesso!!";
    echo "<br><br><br>";
}

$produto1 = new Produto();

$produto1->descricao = "Produto Teste 1";
$produto1->estoque = 10;
$produto1->preco_custo = 100;
$produto1->preco_venda = 200;
$produto1->codigo_barras = '77252562';
$produto1->data_cadastro = date('Y-m-d');
$produto1->origem = 'N';

if ($produto1->save()) {
    echo "Produto 1 salvo com suceso!!";
    echo "<br><br><br>";
}

$produto2 = new Produto();

$produto2->descricao = "Produto Teste 2";
$produto2->estoque = 2;
$produto2->preco_custo = 50;
$produto2->preco_venda = 120;
$produto2->codigo_barras = '85830022';
$produto2->data_cadastro = date('Y-m-d');
$produto2->origem = 'N';

if ($produto2->save()) {
    echo "Produto 2 salvo com suceso!!";
    echo "<br><br><br>";
}

$produto3 = Produto::find(1);

var_dump($produto3);
echo "<br><br><br>";

echo "Descrição {$produto3->descricao} - Margem de Lucro {$produto3->getMargemLucro()}";
echo "<br><br><br>";

$produto3->registraCompra(50, 4);
$produto3->save();

var_dump($produto3);
echo "<br><br><br>";
