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
				for($i=0; $i<count($matches[0]); $i++) {
					if(!$stmt->bindParam($matches[0][$i], $params[$i])) {
						if($this->debug) {
							var_dump($stmt->errorInfo()); echo "<br>";
							var_dump($stmt); echo "<br>";
						}
						throw new Exception("Erreur bindParam",2);
					}
				}

				if(!$stmt->execute() && $this->debug){
					var_dump($stmt->errorInfo());
					echo "<br>";
				}

				if(strtoupper(explode(' ',trim($rq))[0]) == "SELECT") {
					$ret=$stmt->fetchAll();
					return $ret;
				} else {
					if ($this->debug) {
						if($stmt){
							echo "<div class ='debug'><em>Pas SELECT : </em>";
							 print_r($stmt);
						}
					}
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
		function checkCredentials(string $user,string $pswd) {
			$rslt = $this->goQuery("SELECT * FROM users WHERE username = LOWER(:user) AND password=PASSWORD(:pswd)",$user,$pswd);
			return ($rslt[0]["username"] ? 1 : 0);
		}

		/**
		* @brief Cherche un étudiant et retourne les informations sur lui
		* @param user - Nom d'utilisateur de l'étudiant à chercher
		* @return rslt - tableau associatif contenant toutes les informations, avec ces paires : <ul><li>username: nom d'utilisateur</li><li>ine: identifiant INE crypté</li><li>spec1: spécialité 1</li><li>spec2: spécialité 2</li><li>ens1: nom d'utilisateur de l'enseignant 1</li><li>ens2: nom d'utilisateur de l'enseignant 2</li><li>etabville: etablissement et ville; peut-être inutile</li></ul>
		*/
		function studentQuery(string $user) {
			return $this->goQuery("SELECT * FROM students WHERE username = LOWER(:user)",$user);
		}

		/**
		* @brief Renvoi la liste des spécialités 
		* @param Aucun
		* @return rslt - tableau associatif contenant toutes les informations, avec ces paires : id, nom de spécialité
		*/
		function specQuery() {
			return $this->goQuery("SELECT * FROM specs");
		}

		/**
		* @brief Cherche les formulaires les plus récents de tous les enseignants
		*/
		function relatedForms(string $user) {
			// TODO: switch status
			return $this->goQuery("SELECT f.*, u.firstname, u.lastname, MAX(f.date) FROM form f, students s, users u WHERE s.ens1 = :self OR s.ens2 = :self GROUP BY f.username",$user,$user);
		}

		/**
		* @brief Cherche les formulaires les plus récents 
		*/
		function allLastForms() {
			// TODO: switch status
			//return $this->goQuery("SELECT F.* FROM form F WHERE date=(SELECT MAX(date) FROM form WHERE username=F.username);");
			return $this->goQuery("SELECT u.username, u.lastname, u.firstname, s.ens1, s.ens2, s.spec1, s.spec2, m.* FROM users u, students s, (SELECT * FROM form f WHERE date=(SELECT MAX(date) FROM form WHERE username=f.username)) m WHERE s.username=u.username AND m.username=u.username;");

		}

		/**
		* @brief Renvoi la liste des classes à l'aide de la table students
		*/
		function classesQuery() {
			// TODO: switch status
			return $this->goQuery("SELECT Classe FROM students GROUP BY Classe");
		}

		/**
		* @brief Renvoi la liste des étudiants de la classe : $classe
		* @param classe - classe de l'étudiant (exemple 'T01')
		*/
		function studentsByClasseQuery($classe) {
			// TODO: switch status
			return $this->goQuery("SELECT u.username, u.lastname, u.firstname, u.password, s.ine, s.Classe FROM users u, students s WHERE u.username=s.username AND s.Classe=:classe",$classe);
		}

		/**
		* @brief Renvoi la liste des profs de spé à l'aide de la table users et du statut
		*/
		function listProfsQuery() {
			// TODO: switch status
			return $this->goQuery("SELECT firstname, lastname, username FROM users WHERE users.status=1;");
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
		function createUser(string $user,string $pswd,string $firstname,string $lastname,int $status,string $email) {
			return $this->goQuery("INSERT INTO users (username,password,firstname,lastname,status,email) VALUES (LOWER(:user) , PASSWORD(:pswd) , :firstname , :lastname , :status , :email)",$user,$pswd,$firstname,$lastname,$status,$email);

		}

		/**
		* @brief Efface l'utilisateur passé en paramètre de la table users et students s'il existe dans cette table
		* @param user - nom d'utilisateur (insensible à la casse)
		* @return - 1 si succès, 0 si erreur
		*/
		function deleteUser(string $user) {
			$this->goQuery("DELETE FROM students WHERE username=:user",$user);
			$this->goQuery("DELETE FROM students WHERE username=:user",$user);
			return $this->goQuery("DELETE FROM users WHERE username=:user",$user);
		}
		/**
		* @brief Modifie les champs email et status de l'utilisateur passé en paramètre de la table users
		* @param user - nom d'utilisateur (insensible à la casse)
		* @param email - email de l'utilisateur
		* @param status - Statut de l'utilisateur
		* @return - 1 si succès, 0 si erreur
		*/
		function updateUser(string $user,string $email, int $status) {
			//debugPrintVariable(user);
			return $this->goQuery("UPDATE users SET email=:email, status=:status WHERE username=:user",$email, $status, $user);
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
		function updateForm($user,$ens1, $ens2, $q1, $q2, $spec1, $spec1b, $spec2, $spec2b) {

			//Crée un ine aléatoire pour les tests (sera peupler à terme par la fonction import())
			function random_ine($length = 8)
			{
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&?";
				$password = substr(str_shuffle($chars), 0, $length);
				return $password;
			}
				
			if ($this->studentQuery($user))
			{

				if ($this->goQuery("UPDATE students SET `ens1`=:ens1, `ens2`=:ens2, `spec1`=:spec1, `spec2`=:spec2 WHERE `username`=:user",$ens1,$ens2,$spec1,$spec2,$user)){
					return $this->goQuery("INSERT INTO form (`username`, `q1`, `q2`,`spec1b`,`spec2b`) VALUES (LOWER(:user), :q1, :q2, :spec1b, :spec2b)",$user,$q1,$q2,$spec1b,$spec2b);
				}
				else return 0;				
			}
			else {
				$ine=random_ine(8);
				if ($this->goQuery("INSERT INTO students (`username`,`spec1`,`spec2`,`ine`) VALUES (LOWER(:user), :spec1, :spec2, :ine)",$user,$spec1,$spec2, $ine)){
					return $this->goQuery("INSERT INTO form (`username`, `q1`, `q2`,`spec1b`,`spec2b`) VALUES (LOWER(:user), :q1, :q2, :spec1b, :spec2b)",$user,$q1,$q2,$spec1b,$spec2b);
				}
				else return 0;
			}
		}



		/**
		* @brief Change le mot de passe d'un utilisateur
		* @param user - nom d'utilisateur
		* @param pswd - nouveau mot de passe. Ne doit pas être hashé car cette méthode s'en chargera
		* @return - rowCount de stmt; 1 si succès, 0 si erreur, autre chose si grosse erreur
		*/
		function changePassword($user,$pswd) {
			
			return $this->goQuery("UPDATE users SET password=PASSWORD(:pswd) WHERE username = LOWER(:user)",$pswd,$user);
		}

		function formByINE($ine) {
			return $this->goQuery("SELECT f.* FROM form f, students s WHERE s.ine = :ine AND f.username = s.username ORDER BY f.date DESC LIMIT 1",$ine);
		}

		function validate($user,$stdt) {
			// TODO: vérifier statut avant de valider
		}
	}
?>
