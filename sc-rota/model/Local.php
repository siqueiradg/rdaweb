<?php
class Local{
	
	public $ID;
	public $NOME;
	public $DESCRICAO;
    public $CATEGORIA;
    public $RUA;
	public $NUM_END;
	public $BAIRRO;
	public $CEP;
	public $CIDADE;
	public $UF;
	
	function __construct($id = NULL){
		
		if( !empty($id) ){
			$dbh = new Conexao();
			$sql = 'SELECT * FROM local WHERE id = :id';
			$rs = $dbh->prepare( $sql ); 
			$rs->bindParam(':id', $id); 
			$rs->execute();
			
			$locais = $rs->fetch(PDO::FETCH_OBJ); 
			
			$this->ID = $locais->ID;
			$this->NOME = $locais->NOME;
            $this->DESCRICAO = $locais->DESCRICAO; 
			$this->CATEGORIA = $locais->CATEGORIA;
			$this->RUA = $locais->RUA; 
			$this->NUM_END = $locais->NUM_END; 
			$this->BAIRRO = $locais->BAIRRO; 
			$this->CEP = $locais->CEP; 
			$this->CIDADE = $locais->CIDADE; 
			$this->UF = $locais->UF; 
        }
	}
	function save(){
		if(!$this->ID){ 
			$dbh = new Conexao(); 
			$sql = 'INSERT INTO local (NOME, DESCRICAO, CATEGORIA, RUA, NUM_END, BAIRRO, CEP, CIDADE, UF) VALUES( :nome, :descricao, :categoria, :rua, :num_end, :bairro, :cep, :cidade, :uf )';
			$sth = $dbh->prepare( $sql ); 
			$sth->bindParam(':nome', $this->NOME);
			$sth->bindParam(':descricao', $this->DESCRICAO);
			$sth->bindParam(':categoria', $this->CATEGORIA);
			$sth->bindParam(':rua', $this->RUA);
			$sth->bindParam(':num_end', $this->NUM_END);
			$sth->bindParam(':bairro', $this->BAIRRO);
			$sth->bindParam(':cep', $this->CEP);
			$sth->bindParam(':cidade', $this->CIDADE);
			$sth->bindParam(':uf', $this->UF);
        	return $sth->execute(); 
		}
	}


	function editar($id){
		$dbh = new Conexao(); 
		$sql = 'UPDATE local SET NOME = :nome, DESCRICAO = :descricao, CATEGORIA = :categoria, RUA = :rua, NUM_END = :num_end, BAIRRO = :bairro, CEP = :cep, CIDADE = :cidade, UF = :uf WHERE id ='.$id;
		$sth = $dbh->prepare( $sql ); 
		$sth->bindParam(':nome', $this->NOME);
		$sth->bindParam(':descricao', $this->DESCRICAO);
		$sth->bindParam(':categoria', $this->CATEGORIA);
		$sth->bindParam(':rua', $this->RUA);
		$sth->bindParam(':num_end', $this->NUM_END);
		$sth->bindParam(':bairro', $this->BAIRRO);
		$sth->bindParam(':cep', $this->CEP);
		$sth->bindParam(':cidade', $this->CIDADE);
		$sth->bindParam(':uf', $this->UF);
        return $sth->execute(); 
	}


	function vinc($id){
		$dbh = new Conexao(); 
		$sql = 'UPDATE local SET VINCULAR = 1 WHERE local.id = '.$id;
		$sth = $dbh->prepare( $sql ); 
        return $sth->execute(); 
	}

	function ver($id){
		$dbh = new Conexao(); 
		$sql = "SELECT * FROM local WHERE local.id = ".$id;
		$rs = $dbh->query( $sql );
		$locais = $rs->fetchAll( PDO::FETCH_CLASS, 'Local' );
		return $locais;
	}

	function apagar($id){
		$dbh = new Conexao(); 
		$sql = "DELETE FROM local_tag WHERE local_tag.id_local = ".$id;
		$sql2 = "DELETE FROM local WHERE local.id = ".$id;
		$sth = $dbh->prepare( $sql );
		$sth2 =  $dbh->prepare( $sql2 );
		$sth->execute(); 

        return $sth2->execute(); 
	}
	
	static function all(){
		$dbh = new Conexao(); 
		$sql = "SELECT * FROM local ORDER BY nome";
		$rs = $dbh->query( $sql );
		$locais = $rs->fetchAll( PDO::FETCH_CLASS, 'Local' );
		return $locais;
	}

	static function allCidade($cidade){
		$dbh = new Conexao(); 
		$sql = "SELECT * FROM local WHERE local.cidade = '".$cidade."' ORDER BY nome";
		$rs = $dbh->query( $sql );
		$locais = $rs->fetchAll( PDO::FETCH_CLASS, 'Local' );
		return $locais;
	}

	static function allVincular(){
		$dbh = new Conexao(); 
		$sql = "SELECT * FROM local WHERE vincular = 0";
		$rs = $dbh->query( $sql );
		$locais = $rs->fetchAll( PDO::FETCH_CLASS, 'Local' );
		return $locais;
	}
        

} 




