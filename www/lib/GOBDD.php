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

		/**
		* @brief Prépare la requête $rq, lie les paramètres $params aux marqueurs, exécute et renvoie le résultat.
		* @param rq - requête à effectuer. Les champs de paramètre doivent être remplis avec des marqueurs.
		* Exemple : `SELECT * FROM users WHERE username = :user`
		* @param params - valeurs à lier aux marqueurs de paramètre dans la requête. Un nombre indéfini de paramètres peut être fourni; ils seront liés aux marqueurs dans l'ordre.
		* @return - si la requête est SELECT et que le résultat contient plus d'une ligne, tous les résultats seront renvoyés dans un tableau à deux dimensions ([numéro ligne (int)][colonne (string)] => valeur) ; si le résultat ne contient qu'une seule ligne, elle sera renvoyée dans un tableau associatif ([colonne (string) => valeur]) ; si le résultat est vide, la méthode retournera bool(false).
		* Si la requête n'est pas SELECT, la méthode retournera le nombre de lignes affectées ou bool(false) dans le cas échéant.
		*/
		private function goQuery(string $rq, ...$params) {
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

		/**
		* @brief Cherche le formulaire le plus récent pour un utilisateur
		* @param user - nom d'utilisateur
		* @return rslt - tableau associatif contenant toutes les informations, avec ces paires : <ul><li>id: identifiant unique du formulaire</li><li>username: nom d'utilisateur</li><li>q1: question 1</li><li>q2: question 2</li><li>e1valid: 1 si validé par enseignant 1, sinon 0</li><li>e1valid: 1 si validé par enseignant 1, sinon 0</li><li>proValid: 1 si validé par proviseur adjoint, sinon 0</li></ul>
		*/
		function formQuery(string $user) {
			return $this->goQuery("SELECT * from form WHERE username = LOWER(:user) ORDER BY date DESC LIMIT 1",$user);
		}

		function formHistoryQuery(string $user) {
			return $this->goQuery("SELECT * FROM form WHERE username = LOWER(:user)",$user);
		}

		/**
		* @brief Vérifie la validité d'une paire d'identifiants. Cherche si il existe un compte avec le même nom d'utilisateur et mot de passe
		* @param user - nom d'utilisateur
		* @param pswd - mot de passe
		* @rslt - 1 si il y a un (seul) compte correspondant; 0 si il n'y en a pas (ou si il y en a plus d'un; théoriquement impossible)
		*/
		function checkCredentials($user,$pswd) {
			$rslt = $this->goQuery("SELECT * FROM users WHERE username = LOWER(:user) AND password=PASSWORD(:pswd)",$user,$pswd);
			return ($rslt["username"] ? 1 : 0);
		}

		/**
		* @brief Cherche un étudiant et retourne les informations sur lui
		* @param user - Nom d'utilisateur de l'étudiant à chercher
		* @return rslt - tableau associatif contenant toutes les informations, avec ces paires : <ul><li>username: nom d'utilisateur</li><li>ine: identifiant INE crypté</li><li>spec1: spécialité 1</li><li>spec2: spécialité 2</li><li>ens1: nom d'utilisateur de l'enseignant 1</li><li>ens2: nom d'utilisateur de l'enseignant 2</li><li>etabville: etablissement et ville; peut-être inutile</li></ul>
		*/
		function studentQuery($user) {
			return $this->goQuery("SELECT * FROM students WHERE username = LOWER(:user)",$user);
		}

		/**
		* @brief Cherche les formulaires les plus récents de tous les enseignants
		*/
		function relatedForms($user) {
			// TODO: switch status
			return $this->goQuery("SELECT f.*, u.firstname, u.lastname, MAX(f.date) FROM form f, students s, users u WHERE s.ens1 = :self OR s.ens2 = :self GROUP BY f.username",$user,$user);
		}

		/**
		* @brief Ajoute un nouvel utilisateur avec les valeurs données.
		* @param user - nom d'utilisateur (insensible à la casse)
		* @param pswd - mot de passe (sera crypté)
		* @param firstname - prénom
		* @param lastname - nom de famille
		* @param status - rang de l'utilisateur (0: étudiant, 1: enseignant, 2: proviseur adjoint, 3: secrétaire)
		* @return - 1 si succès, 0 si erreur
		*/
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

		/**
		* @brief Modifie les données dans le formulaire actif d'un utilisateur (étudiant). Le formulaire actif est le formulaire le plus récent dans la base de données
		* @param user - nom de l'utilisateur dans la base de données
		* @param q1 - première question
		* @param q2 - deuxième question
		* @return - rowCount de stmt; 1 si succès, 0 si erreur, autre chose si grosse erreur
		*/
		function updateForm($user,$q1,$q2) {
			return $this->goQuery("INSERT INTO form (`username`, `q1`, `q2`) VALUES (LOWER(:user), :q1, :q2)",$user,$q1,$q2);
		}

		/**
		* @brief Change le mot de passe d'un utilisateur
		* @param user - nom d'utilisateur
		* @param pswd - nouveau mot de passe. Ne doit pas être hashé car cette méthode s'en chargera
		* @return - rowCount de stmt; 1 si succès, 0 si erreur, autre chose si grosse erreur
		*/
		function changePassword($user,$pswd) {
			return $this->goQuery("UPDATE users SET password=PASSWORD(:pswd) WHERE username = LOWER(:user)",$user,$pswd);
		}

		function formByINE($ine) {
			return $this->goQuery("SELECT f.* FROM form f, students s WHERE s.ine = :ine AND f.username = s.username ORDER BY f.date DESC LIMIT 1",$ine);
		}

		function validate($user,$stdt) {
			// TODO: vérifier statut avant de valider
		}
	}
?>
