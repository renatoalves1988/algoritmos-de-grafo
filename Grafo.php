<?php  

class Grafo {

	private $lista_de_adjacencia = array();
	private $dados = array();

	public function __construct($dados) {
		$this->dados = $dados;
	}

    public function criaListaAdjacencia() {
        
        foreach ($this->dados['arestas'] as $value) {

        	if (! array_key_exists($value[0], $this->lista_de_adjacencia) )
    		{
    			$this->lista_de_adjacencia[$value[0]] = array();
    		}
    		

        	if ($this->dados['peso'] == 'true') {

        		array_push( $this->lista_de_adjacencia[$value[0]], array( $value[1], intval($value[2]) ) );

        		if ($this->dados['direcionado'] == 'false') {

        			array_push( $this->lista_de_adjacencia[$value[1]], array($value[0], intval($value[2]) ) );
	        	}
        	}
        	else
        	{
        		array_push( $this->lista_de_adjacencia[$value[0]], array($value[1], 1 ) );

        		if ($this->dados['direcionado'] == 'false') {
        			array_push( $this->lista_de_adjacencia[$value[1]], array($value[0], 1 ) );
	        	}
        	}
    	}
    }

    public function distancia ($caminho) {

    	$vertice_atual = array_shift($caminho);
    	$distancia = 0;

    	while (!empty($caminho)){

    		foreach ($this->lista_de_adjacencia[$vertice_atual] as $value) {
    			
    			if ($caminho[0] == $value[0]) {
    				$distancia += $value[1];
    				$vertice_atual = array_shift($caminho);
    				break;
    			}
    		}
    	}

    	return $distancia;
    }
	
	public function bfs ($origem, $destino)	{

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

	public function dfs ($origem, $destino) {

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
	
	public function menor_caminho ($origem, $destino)
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
