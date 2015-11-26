<?php  

class Grafo {

	public $lista_de_adjacencia = array();
	private $dados = array();

	public function __construct($dados) {
		$this->dados = $dados;
	}

    public function criaListaAdjacencia() {
        
        foreach ($this->dados['arestas'] as $value) {

        	if (! array_key_exists($value[0], $this->lista_de_adjacencia) ) // verifica se o vertice atual do loop, está presente na lista de adjacencia
    		{
    			$this->lista_de_adjacencia[$value[0]] = array(); // se nao estiver, adiono ele e falo que ele também será um array
    		}
    		

        	if ($this->dados['peso'] == 'true') { //verifico se o grafo terá peso

        		array_push( $this->lista_de_adjacencia[$value[0]], array( $value[1], intval($value[2]) ) ); // adiciono como ao vertice atual do loop, o vizinho e seu peso

        		if ($this->dados['direcionado'] == 'false') { // verifico so o grafo será um digrafo
        			$this->lista_de_adjacencia[$value[1]] = array();
        			array_push( $this->lista_de_adjacencia[$value[1]], array($value[0], intval($value[2]) ) ); // se nao for, adiciono o vertice atual do loop a lista de vizinho, por exemplo: veja abaixo:

        			/* vertice atual: 0 
					   lista de vizinhos: 0(vertice atual) = [1(vertice vizinho), 10 (peso da aresta)]
					   se nao for direcionado adiono também, o vertice atual como vizinho
					   lista de vizinhos: 1(vertice vizinho) = [0(vertice atual), 10 (peso da aresta)]
        			*/

	        	}
        	}
        	else
        	{
        		if (! array_key_exists($value[1], $this->lista_de_adjacencia) ) // verifica se o vertice atual do loop, está presente na lista de adjacencia
	    		{
	    			$this->lista_de_adjacencia[$value[1]] = array(); // se nao estiver, adiono ele e falo que ele também será um array
	    		}

        		array_push( $this->lista_de_adjacencia[$value[0]], array($value[1], 1 ) ); // se nao tiver peso, adiciono o peso 1 para a aresta

        		if ($this->dados['direcionado'] == 'false') {
        			$this->lista_de_adjacencia[$value[1]] = array();
        			array_push( $this->lista_de_adjacencia[$value[1]], array($value[0], 1 ) ); // se nao for direcionado faço o mesmo procedimento acima, porémm com peso 1
	        	}
        	}
    	}
    }

    public function distancia ($caminho) {

    	$vertice_atual = array_shift($caminho); // vertice atual é igual o primeiro elemento do vetor caminho
    	$distancia = 0;

    	while (!empty($caminho)){ // enquanto o vetor caminho não estiver vazio

    		foreach ($this->lista_de_adjacencia[$vertice_atual] as $value) { // percorro a lista de vizinhos do vertice atual
    			
    			if ($caminho[0] == $value[0]) { 
    				$distancia += $value[1];
    				$vertice_atual = array_shift($caminho);
    				break;
    			}
    		}
    	}

    	return $distancia;
    }
	
	public function bfs ($origem, $destino)	{ //busca em largura

		$vertice_atual = $origem;
		$fila = array();
		$visitados = array();
		$respostas = array(array($vertice_atual));

		while ($vertice_atual != $destino)
		{

			if (array_key_exists($vertice_atual, $this->lista_de_adjacencia))
			{
				if (!in_array($vertice_atual, $visitados))
				{
					foreach ($this->lista_de_adjacencia[$vertice_atual] as $value) 
					{
						

						if (!in_array($value[0], $visitados))
						{
							array_push($visitados, $vertice_atual);
							array_push($fila, $value[0]);
						}
					}
				}
			}
			else
			{
				array_push($visitados, $vertice_atual);
			}

			array_push($respostas, array($fila));

			if (!empty($fila))
			{
				$vertice_atual = array_shift($fila);
			}
			else
			{
				break;
			}
		}

		return $respostas;
	}

	public function dfs ($origem, $destino) { // busca em profundidade

		$vertice_atual = $origem;
		$fila = array();
		$visitados = array();
		$respostas = array(array($vertice_atual));

		while ($vertice_atual != $destino)
		{
			if (array_key_exists($vertice_atual, $this->lista_de_adjacencia))
			{
				if (!in_array($vertice_atual, $visitados))
				{
					$pos = 0;

					foreach ($this->lista_de_adjacencia[$vertice_atual] as $value) 
					{
						if (!in_array($value[0], $visitados))
						{
							array_push($visitados, $vertice_atual);
							array_splice($fila, $pos, 0, $value[0]);
							$pos++;
						}
					}
				}
			}
			else
			{
				array_push($visitados, $vertice_atual);
			}

			array_push($respostas, array($fila));

			if (!empty($fila))
			{
				$vertice_atual = array_shift($fila);
			}
			else
			{
				break;
			}
		}

		return $respostas;
	}
	
	public function menor_caminho ($origem, $destino) // dijkstra - menor caminho
	{
		$vertice_atual = array();
		$distancia = array();
		$visitados = array();
		$vertice_anterior = array();
		$prioridade = array();
		$respostas = array();

		foreach ($this->lista_de_adjacencia as $k => $i) {
			foreach ($this->lista_de_adjacencia[$k] as $value) {
				$distancia[$value[0]] = PHP_INT_MAX;
			}
		}

		$distancia[$origem] = 0;

		array_push($prioridade, array($origem, $distancia[$origem]));

		while (! empty($prioridade) )
		{
			$vertice_atual = array_shift($prioridade);

			if (array_key_exists($vertice_atual[0], $this->lista_de_adjacencia))
			{
				if (!in_array($vertice_atual[0], $visitados))
				{
					array_push($visitados, $vertice_atual[0]);

					foreach ($this->lista_de_adjacencia[$vertice_atual[0]] as $i) {

						if ( $distancia[$i[0]] > ($distancia[$vertice_atual[0]] + $i[1]) ) {

							$distancia[$i[0]] = ($distancia[$vertice_atual[0]] + $i[1]);
							array_push( $prioridade, array($i[0], $distancia[$i[0]]) );
							$vertice_anterior[$i[0]] = $vertice_atual[0];
						}
				
					}
				}
			}
			else
			{
				continue;
			}
		}
		
		$caminho = array($destino);
		$vertice_auxiliar = $destino;

		while(True) {

			if ( array_key_exists($vertice_auxiliar, $vertice_anterior) ) {
				array_push($caminho, $vertice_anterior[$vertice_auxiliar]);
				$vertice_auxiliar = $vertice_anterior[$vertice_auxiliar];
			}
			else
			{
				break;
			}
		}

		krsort($caminho); // ordena inversamente o caminho
		$respostas['caminho'] = $caminho;
		$respostas['distancia'] = $distancia[$destino];		

		return $respostas;
	}

}

