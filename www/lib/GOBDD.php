<?php
	class GOBDD {
		private $bdd;
		private $debug = 0;

		/**
		* @param host - domaine du SGBD
		* @param db - nom de la base de données
		* @param user - nom d'utilisateur; à stocker dans un fichier séparé et sécurisé
		* @param pswd - mot de passe; à stocker dans un fichier séparé et sécurisé
		* @param debug - 1 pour activer les fonctions de debug
		*/
		function __construct(string $host, string $db, string $user, string $pswd, $debug = 0) {
			$this->debug = $debug;
			try {
				$this->bdd = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8',$user,$pswd);
				if ($this->bdd && $this->debug) echo "Connexion réussie<br>";
			} catch (Exception $e) {
				die('Erreur: ' . $e->getMessage());
				if ($e) echo $e;
			}
		}


		protected function goQuery(string $rq, ...$params) {
			try {
				//trouve ts les mots commencant par ':'
				$regex = "/:\w+/i";

				$stmt = $this->bdd->prepare($rq);
				if(!$stmt) {
					throw new Exception("Erreur requête",1);
				}

				preg_match_all($regex,$rq,$matches);
				//var_dump($matches);
				for($i=0; $i<count($matches[0]); $i++) {
					//echo $matches[0][$i];
					if(!$stmt->bindParam($matches[0][$i], $params[$i])) {
						if($this->debug) {
							var_dump($stmt->errorInfo());
							echo "<br>";
							var_dump($stmt);
							echo "<br>";
						}
						throw new Exception("Erreur bindParam",2);
					}
				}

				if(!$stmt->execute() && $this->debug){
					var_dump($stmt->errorInfo());
					echo "<br>";
				}

				if(strtoupper(explode(' ',trim($rq))[0]) == "SELECT") {
					echo "rq: SELECT<br>";
					if($stmt->rowCount() > 2){
						echo "rowCount() > 2<br>";
						//var_dump($stmt->errorInfo());
						//var_dump($stmt);
						return $stmt->fetchAll(PDO::FETCH_DEFAULT);
					} else {
						echo "rowCount() <= 2<br>";
						//var_dump($stmt->errorInfo());
						//var_dump($stmt);
						return $stmt->fetch(PDO::FETCH_ASSOC);
					}
				} else {
					echo "rq: !SELECT<br>";
					return $stmt->rowCount();
				}
			} catch(Exception $e) {
				if($this->debug) {
					var_dump($this->bdd);
					echo "<br>";
					var_dump($stmt);
					echo "<br>";
				}
				echo "Exception dans le fichier ".$e->getFile()." ligne ".$e->getLine()." : ".$e->getMessage()."<br>";
				if($e->getCode() == 1) {
					var_dump($this->bdd->errorInfo());
					echo "<br>";
				} else {
					var_dump($stmt->errorInfo());
					echo "<br>";
				}
			}
		}

		function userQuery(string $user) {
			return $this->goQuery("SELECT * FROM users WHERE username=LOWER(:user)",$user);
		}

		function allUsers(){
			return $this->goQuery("SELECT * FROM users");
		}

		function formQuery(string $user) {
			return $this->goQuery("SELECT * from form WHERE username = LOWER(:user) ORDER BY date DESC LIMIT 1",$user);
		}

		function formHistoryQuery(string $user) {
			return $this->goQuery("SELECT * FROM form WHERE username = LOWER(:user)",$user);
		}

		function checkCredentials($user,$pswd) {
			$rslt = $this->goQuery("SELECT * FROM users WHERE username = LOWER(:user) AND password=PASSWORD(:pswd)",$user,$pswd);
			return ($rslt["username"] ? 1 : 0);
		}

		function studentQuery($user) {
			return $this->goQuery("SELECT * FROM students WHERE username = LOWER(:user)",$user);
		}

		function relatedForms($user) {
			// TODO: écrire la requête
			return $this->goQuery("SELECT f.*, u.firstname, u.lastname FROM form f, students s, users u WHERE s.ens1 = :self OR s.ens2 = :self",$user,$user);
		}

		function createUser($user,$pswd,$firstname,$lastname,$status,$email) {
			return $this->goQuery("INSERT INTO users (username,password,firstname,lastname,status,email) VALUES (LOWER(:user) , PASSWORD(:pswd) , :firstname , :lastname , :status , :email)",$user,$pswd,$firstname,$lastname,$status,$email);

		}

		// à voir en considérant les changements dans la base de données à cause des questions à double spé
		/*function createStudent($user,) {
			//createUser doit être effectuée avant
			if(!$this->userQuery($user)) {
				return 0;
			}
			return $this->goQuery("INSERT INTO students (username)");
		}*/

		function updateForm($user,$q1,$q2) {
			return $this->goQuery("INSERT INTO form (`username`, `q1`, `q2`) VALUES (LOWER(:user), :q1, :q2)",$user,$q1,$q2);
		}

		function changePassword($user,$pswd) {
			return $this->goQuery("UPDATE users SET password=PASSWORD(:pswd) WHERE username = LOWER(:user)",$user,$pswd);
		}

		function scannedForm($ine) {
			return $this->goQuery("SELECT f.* FROM form f, students s WHERE s.ine = :ine AND f.username = s.username ORDER BY f.date DESC LIMIT 1",$ine);
		}
	}
?>
