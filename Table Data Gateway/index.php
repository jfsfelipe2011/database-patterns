<?php

declare(strict_types=1);

use App\Produto;

require_once __DIR__ . '/vendor/autoload.php';

echo "======================Table Data Gateway======================";
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

$produto1 = new Produto();
$produto1->setConnection($conn);

$produto1->descricao = "Teste";
$produto1->estoque = 10;
$produto1->preco_custo = 100;
$produto1->preco_venda = 200;
$produto1->codigo_barras = '85830022';
$produto1->data_cadastro = date('Y-m-d');
$produto1->origem = 'N';

if ($produto1->save()) {
    echo "Produto 1 salvo com suceso!!";
    echo "<br><br><br>";
}

$produto2 = new Produto();

$produto2->descricao = "Teste";
$produto2->estoque = 10;
$produto2->preco_custo = 100;
$produto2->preco_venda = 200;
$produto2->codigo_barras = '85830022';
$produto2->data_cadastro = date('Y-m-d');
$produto2->origem = 'N';

if ($produto2->save()) {
    echo "Produto 2 salvo com suceso!!";
    echo "<br><br><br>";
}

$produto2 = Produto::find(2);
$produto2->descricao = "Teste 2";

if ($produto2->save()) {
    echo "Produto 2 atualizado com sucesso!!";
    echo "<br><br><br>";
}

$produtos = Produto::all();

foreach ($produtos as $produto) {
    if ($produto->delete()) {
        echo "Produto deletado com sucesso!!";
        echo "<br><br><br>";
    }
}
