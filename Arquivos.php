<?php 

class Arquivos {

	public $arquivo;
	public $lista_dados = array();
	public $lista_vertices = array();
    public $lista_arestas = array();
	public $lista_comandos = array();

	public function __construct ($arquivo)
	{
		$this->arquivo = $arquivo;
	}

	public function debug ($nome)
	{
		echo "<pre>";
		print_r($this->$nome);
		echo "<hr>";
		exit;
	}

	public function lerArquivo ()
	{
		if ($this->arquivo)
		{
			while ( ! feof($this->arquivo) )	
			{
				$this->lista_dados[] = fgets($this->arquivo);
			}
		}

		fclose($this->arquivo);
	}

	public function pegaPosicaoNaLista ($elemento)
	{
		foreach ($this->lista_dados as $value) 
		{
			if (trim($value) == $elemento) // funcao TRIM remove os espaços em brancos antes e depois da string
			{
				return key($this->lista_dados) - 1;
			} 
		}

		return false;
	}

	public function separandoDados ()
	{
		$indice_aresta =  $this->pegaPosicaoNaLista('ARESTAS');
		$indice_comando = $this->pegaPosicaoNaLista('COMANDOS');

		// vai chamar 2 vezes a funcao  $this->pegaPosicaoNaLista()
		// a primeira vez vvocê vai chamar passando ARESTAS como parametro  $this->pegaPosicaoNaLista('ARESTAS')
		// a segunda vez vvocê vai chamar passando COMANDOS como parametro  $this->pegaPosicaoNaLista('COMANDOS')

		for($i = 1;  $i < ($indice_aresta - 1); $i++ ) // -1  para já remover o espaço em branco
		{
			$this->lista_vertices[] = $this->lista_dados[$i];
		}

        for($i = $indice_aresta+1;  $i < ($indice_comando - 1); $i++ ) // -1  para já remover o espaço em branco
        {
        	$this->lista_arestas[] = $this->lista_dados[$i];
        }

        for ($i = $indice_comando+1; $i < count($this->lista_dados); $i++) { 
            $this->lista_comandos[] = $this->lista_dados[$i];
        }
    }

    // remove o ; do ultimo elemento da lista, ex: 4;
    // o retorno será 4
    public function removePontoVigula ( $elemento, $separador )
    {
    	$ultimo_elemento = explode( $separador, $elemento ); // tranforma em array separando o numero da ;
    	return array_shift($ultimo_elemento); // retorna o primeiro elemento que é o nosso vertice
    }

    public function pegaVertices ()
    {
    	$lista = explode(" ", $this->lista_vertices[0]);

    	$indice_ultimo_elemento = count($lista) - 1; //pega a posição do ultimo elemento
    	
    	$lista[$indice_ultimo_elemento] = $this->removePontoVigula(end($lista), ';');

    	$this->lista_vertices[0] = $lista;

    }

    public function pegaArestas ()
    {

        $lista = array();

        foreach ($this->lista_arestas as $list)
        {
            $lista[] = explode(' ', $list);
        }

        foreach ($lista as $k => $l)
        {
            $lista[$k][2] = $this->removePontoVigula(end($l), ',');

            if ($k == (count($lista)-1))
            {
                $lista[$k][2] = $this->removePontoVigula(end($l), ';');
            }
        }

        $this->lista_arestas = $lista;
    }

    public function formatarDados()
    {
        $dados = array();
        $dados['vertices'] = $this->lista_vertices[0];
        $dados['arestas'] = $this->lista_arestas;
        $dados['comandos'] = $this->lista_comandos;

        $direcionado = explode(' ', $this->lista_vertices[1]);
        $dados['direcionado'] = $direcionado[0];

        $peso = explode(' ', $this->lista_vertices[2]);
        $dados['peso'] = $peso[0];

        return $dados;
    }


    public function exibe()
    {
        echo "<pre>";
        print_r($this->lista_vertices);
        echo "<hr>";
        print_r($this->lista_arestas);
    }


    public function pegaComandos ()
    {
        $lista = array();

        foreach ($this->lista_comandos as $value) {
            $alg = explode(' ', $value);
            $indice_ultimo_elemento = count($alg) - 1;
            $alg[$indice_ultimo_elemento] = $this->removePontoVigula(end($alg), ';');

            $aux = array();
            $aux['algoritmo'] = strtolower(array_shift($alg));
            $aux['lista'] = $alg;

            array_push($lista,  $aux);
        }

       $this->lista_comandos = $lista;
    }
}
