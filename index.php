<?php

require "config.php";

$rota= $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "lojati" : "teste");

function teste(){
    echo "API respondendo com sucesso!";
}

function createClientes($con){
    $nome_cliente = $_POST["nome_cliente"];
    $email_cliente = $_POST["email_cliente"];
    $telefone_cliente = $_POST["telefone_cliente"];
    $endereco_cliente = $_POST["endereco_cliente"];
    try {
        $stmt = $con->prepare("INSERT INTO clientes (nome, email, telefone, endereco) VALUES (?, ?, ?, ?)");
        $stmt ->execute([$nome_cliente, $email_cliente, $telefone_cliente, $endereco_cliente]);
        header("Location: ../front/index.html");
    }catch (PDOException $e){
        echo json_encode(["mensagem" => $e]);
        header("Location: ../front/erro.html");
    }
}

function readClientes($con){
    $stmt = $con->query("SELECT * FROM Clientes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    createClientes($con);
}elseif ($rota === "clientes"){
    readClientes($con);
}else {
    teste();
}

?>