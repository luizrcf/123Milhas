<?php

require 'Slim/Slim.php';

function addPizza($nomePizza, $tamanho, $textoIgredientes) {
    $link = mysql_connect('123milhas', '123milhas', '123milhas');
    $db_selected = mysql_select_db('pizzaria', $link);
    $query = 'Insert into Pizza(nome, tamanho, igredientes) VALUES("'.$nomePizza.'", "'.$tamanho.'", "'.$textoIgredientes.'") ';
    mysql_query($query, $db_selected);
    
    $retorno['mensagem'] = 'Pizza Adicionada';
    $retorno['idPizza'] = count($this->vetCardapio[]);

    $json_encode = json_encode($retorno);
    echo $json_encode;
}

function removePizza($idPizza) {
    $pizza = getPizza($idPizza);
    if(is_array($pizza) && count($pizza)){
        $link = mysql_connect('123milhas', '123milhas', '123milhas');
        $db_selected = mysql_select_db('pizzaria', $link);
        $query = 'DELETE FROM Pizza WHERE id = "'.$idPizza.'" ';
        mysql_query($query, $db_selected);

        $retorno['erro'] = 0;
        $retorno['mensagem'] = 'Pizza Removida';
    } else{
        $retorno['erro'] = 1;
        $retorno['mensagem'] = 'Pizza n�o encontrada';
    }
    
    $json_encode = json_encode($retorno);
    echo $json_encode;
}

function getPizza($idPizza){
    $link = mysql_connect('123milhas', '123milhas', '123milhas');
    $db_selected = mysql_select_db('pizzaria', $link);
    $query = 'SELECT * FROM Pizza WHERE id = "'.$idPizza.'" ';
    $result = mysql_query($query, $db_selected);
    $pizza = mysql_fetch_assoc($result);
    
    return $pizza;
}

function alteraPizza($idPizza, $nomePizza, $tamanho, $textoIgredientes) {
    $pizza = getPizza($idPizza);

    if(is_array($pizza) && count($pizza)){
        $link = mysql_connect('123milhas', '123milhas', '123milhas');
        $db_selected = mysql_select_db('pizzaria', $link);
        $query = 'UPDATE Pizza SET nome = "'.$nomePizza.'", tamanho = "'.$tamanho.'", igredientes = "'.$textoIgredientes.'" WHERE id = "'.$idPizza.'" ';
        mysql_query($query, $db_selected);

        $retorno['mensagem'] = 'Pizza Alterada';
        $retorno['erro'] = 0;
    } else {
        $retorno['erro'] = 1;
        $retorno['mensagem'] = 'N�o existe a pizza a ser alterada';
    }

    $json_encode = json_encode($retorno);
    echo $json_encode;
}

function adicionaPedido($idPizza, $idCliente) {
    $link = mysql_connect('123milhas', '123milhas', '123milhas');
    $db_selected = mysql_select_db('pizzaria', $link);
    $query = 'INSERT INTO Pedido (idCliente, idPizza) VALUES("'.$idCliente.'", "'.$idPizza.'") ';
    $result = mysql_query($query, $db_selected);
    
    $retorno['mensagem'] = 'Pedido Adicionado';

    $json_encode = json_encode($retorno);
    echo $json_encode;
}

function getCliente($telefone){
    $link = mysql_connect('123milhas', '123milhas', '123milhas');
    $db_selected = mysql_select_db('pizzaria', $link);
    $query = 'SELECT * FROM Cliente WHERE telefone = "'.$telefone.'" ';
    $result = mysql_query($query, $db_selected);
    $cliente = mysql_fetch_assoc($result);
    
    if(is_array($cliente) && count($cliente)){
        $retorno['erro'] = 0;
        $retorno['mensagem'] = 'Cliente encontrado';
        $retorno['dadosCliente'] = $cliente;
    } else{
        $retorno['erro'] = 1;
        $retorno['mensagem'] = 'Cliente n�o encontrado';
    }
    
    $json_encode = json_encode($retorno);
    echo $json_encode;
}

function addCliente($nomeCliente, $telefone, $endereco) {
    $link = mysql_connect('123milhas', '123milhas', '123milhas');
    $db_selected = mysql_select_db('pizzaria', $link);
    $query = 'Insert into Cliente(nome, telefone, endereco) VALUES("'.$nomeCliente.'", "'.$telefone.'", "'.$endereco.'") ';
    mysql_query($query, $db_selected);
    
    $retorno['mensagem'] = 'Cliente Adicionado';
    $retorno['idCliente'] = mysql_insert_id($link);

    $json_encode = json_encode($retorno);
    echo $json_encode;

}

function removeCliente($idCliente) {
    $cliente = getCliente($idCliente);
    if(is_array($cliente) && count($cliente)){
        $link = mysql_connect('123milhas', '123milhas', '123milhas');
        $db_selected = mysql_select_db('pizzaria', $link);
        $query = 'DELETE FROM Cliente WHERE id = "'.$idCliente.'" ';
        mysql_query($query, $db_selected);

        $retorno['erro'] = 0;
        $retorno['mensagem'] = 'Cliente Removido';
    } else{
        $retorno['erro'] = 1;
        $retorno['mensagem'] = 'Cliente n�o encontrado';
    }
    
    $json_encode = json_encode($retorno);
    echo $json_encode;
}

function alteraCliente($idCliente, $nome, $telefone, $endereco) {
    $pizza = getCliente($idCliente);

    if(is_array($pizza) && count($pizza)){
        $link = mysql_connect('123milhas', '123milhas', '123milhas');
        $db_selected = mysql_select_db('pizzaria', $link);
        $query = 'UPDATE Cliente SET nome = "'.$nome.'", telefone = "'.$telefone.'", endereco = "'.$endereco.'" WHERE id = "'.$idCliente.'" ';
        mysql_query($query, $db_selected);

        $retorno['mensagem'] = 'Pizza Alterada';
        $retorno['erro'] = 0;
    } else {
        $retorno['erro'] = 1;
        $retorno['mensagem'] = 'N�o existe a pizza a ser alterada';
    }

    $json_encode = json_encode($retorno);
    echo $json_encode;
}

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();


/**
 * 	### ALTERAR AKI ###
 * 	
 * 	Mapeamento das funções
 * 	faça o mapeamento da função que você quer disponibilizar.
 *
 * 	$app->get(	'MAPEAMENTO' , 'FUNÇÃO QUE DESEJA EXECUTAR' );
 * 	
 * 	EX:
 * 		$app->get('/listarFarmacias/:name', 'listarFarmacias');
 *
 * 		http://localhost/rest/mgApp/listarFarmacias/nome
 *
 * 	Links: 
 * 		http://localhost/rest/mgApp/listarMedicamentosPorCidade/BH
 * 		http://localhost/rest/mgApp/listarCidadePorMedicamentos/dorflex
 */
$app->get('/addPizza/:nomePizza/:$tamanho/:textoIgredientes) ', 'addPizza');
$app->get('/removePizza/:idPizza) ', 'removePizza');
$app->get('/alteraPizza/:idPizza/:nomePizza/:tamanho/:textoIgredientes) ', 'alteraPizza');
$app->get('/adicionaPedido/:idPizza/:idCliente) ', 'adicionaPedido');
$app->get('/getCliente/:telefone) ', 'getCliente');
$app->get('/addCliente/:nomeCliente/:telefone/:endereco) ', 'addCliente');
$app->get('/removeCliente/:idCliente) ', 'removeCliente');
$app->get('/alteraCliente/:idCliente/:nome/:telefone/:endereco) ', 'alteraCliente');


/**
 * 	Essa função executa os webservices
 */
$app->run();
?>