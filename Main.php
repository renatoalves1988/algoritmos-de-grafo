

<?php

error_reporting(0);
ini_set("display_errors", 0 ); 

if (!empty($_FILES))
{
	include_once('Arquivos.php');
	include_once('Grafo.php');

	if ($_FILES['arquivo']['error'] == 0 && $_FILES['arquivo']['type'] == 'text/plain')
	{
		// ARQUIVOS
		$arquivo = @fopen($_FILES['arquivo']['tmp_name'], 'r'); // @ é para evitar que seja exibido erro
		// CLASSE ARQUIVO

		$arq = new Arquivos($arquivo);
		$arq->lerArquivo();
		$arq->separandoDados();
		$arq->pegaVertices();
		$arq->pegaArestas();
		$arq->pegaComandos();
		$dados = $arq->formatarDados();
		// CLASSE GRAFO
		$grafo = new Grafo($dados);
		$grafo->criaListaAdjacencia();

		// LISTAS DE RESPOSTAS
		$distancia = array();
		$profundidade = array();
		$largura = array();
		$menorcaminho = array();

		// PERCORRER OS COMANDOS E PARA CADA COMANDO EXECUTAR O ALGORITMO
		foreach ($dados['comandos'] as $comando) 
		{
			switch ($comando['algoritmo']) {
				case 'distancia':
					$distancia[] = array($comando['lista'], $grafo->distancia($comando['lista']));
					break;

				case 'profundidade':
					$profundidade[] = array($comando['lista'], $grafo->dfs($comando['lista'][0], $comando['lista'][1]));
					break;

				case 'largura':
					$largura[] = array($comando['lista'], $grafo->bfs($comando['lista'][0], $comando['lista'][1]));
					break;

				case 'menorcaminho':
					$menorcaminho[] = array($comando['lista'], $grafo->menor_caminho($comando['lista'][0], $comando['lista'][1]));
					break;
			}
		}

	}
	else
	{
		$error = "Arquivo inválido ou corrompido";
	}
	
}

include_once('index.php');

