<?php
/**
* @file GOBDD.php
* @brief Fonctions liées à la base de données
*/
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
				if ($this->bdd && $this->debug) echo "Connexion à la base de données '$db' réussie<br>";
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
					if($stmt->rowCount() >= 2){
						if($this->debug) {
							//echo "$rq<br>rq: SELECT<br>rowCount() >= 2<br>";
							var_dump($stmt->errorInfo());
							var_dump($stmt);
							echo "<br><br>";
						}
						return $stmt->fetchAll(PDO::FETCH_BOTH);
					} else {
						if($this->debug) {
							// TODO : DANGEREUX pour les requêtes où le nombre de résultats n'est pas sûr, comme relatedForms !! à voir si il faut l'enlever
							//echo "$rq<br>rq: SELECT<br>rowCount() < 2<br>";
							var_dump($stmt->errorInfo());
							var_dump($stmt);
							echo "<br><br>";
						}
						return $stmt->fetch(PDO::FETCH_ASSOC);
					}
				} else {
					if($this->debug) echo "$rq<br>rq: !SELECT<br>";
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

		//Crée une chaîne aléatoire pour les tests
		function random($length = 8) {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&?";
			$str = substr(str_shuffle($chars), 0, $length);
			return $str;
		}

		// var_dump formaté
		// Par M.MIOSSEC
		// TODO : utiliser debug.php à la place et éviter la duplication
		function debugPrintVariable($nomvariable) {
			global $$nomvariable;
			if (isset($$nomvariable)){
				if(is_array($$nomvariable)){
					echo "<div class = 'debug'><em>Valeur du tableau $".$nomvariable.": </em>";
					if ($$nomvariable) {
						echo "<ul>";
						foreach ($$nomvariable as $cle => $valeur) {
	                        if (is_array($valeur)) {
	                            echo "<li>$".$nomvariable."[$cle] = ";
	                            print_r($valeur);
	                            echo "</li>";
	                        }
	                        else echo "<li>$".$nomvariable."[$cle] = $valeur</li>";
						}
						echo "</ul>";
					}
					echo "</div>";
				}
				else if(is_bool($$nomvariable)){
					echo "<div class = 'debug'><em>Valeur du Booléen $".$nomvariable.": </em>";
					if ($$nomvariable){
						echo "true";
					}
					else{
						echo "false";
					}
					echo "</div>";
				}
				else if(is_string($$nomvariable)){
					echo "<div class = 'debug'><em>Valeur de la chaîne de caractères $".$nomvariable.": </em>".$$nomvariable."</div>";
				}
				else if(is_numeric($$nomvariable)){
					echo "<div class = 'debug'><em>Valeur de la variable numrique $".$nomvariable.": </em>".$$nomvariable."</div>";
				}
				else{
					echo "<div class = 'debug'><em>La variable $".$nomvariable." existe mais je ne suis pas sûr de l'afficher correctement. Sa valeur est </em>".$$nomvariable."</div>";
				}
			}
			else{
				echo "<div class = 'debug'><em>La variable $".$nomvariable." n'est pas définie!</em></div>";
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
			return $this->goQuery("SELECT * FROM form WHERE username = LOWER(:user) ORDER BY date",$user);
		}

		/**
		* @brief Vérifie la validité d'une paire d'identifiants. Cherche si il existe un compte avec le même nom d'utilisateur et mot de passe
		* @param user - nom d'utilisateur
		* @param pswd - mot de passe
		* @rslt - 1 si il y a un (seul) compte correspondant; 0 si il n'y en a pas (ou si il y en a plus d'un; théoriquement impossible)
		*/
		function checkCredentials(string $user,string $pswd) {
			$rslt = $this->goQuery("SELECT * FROM users WHERE username = LOWER(:user) AND password=PASSWORD(:pswd)",$user,$pswd);
			return ($rslt["username"] ? 1 : 0);
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
		* @brief Renvoie la liste des spécialités
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
			$rslt = $this->goQuery("SELECT f.*, u.firstname, u.lastname, MAX(f.date) FROM form f, users u WHERE f.ens1 = :self OR f.ens2 = :self GROUP BY f.username",$user,$user);
			return ($rslt[0] ? $rslt : array($rslt));
			// Solution imparfaite; à voir comment changer goQuery() sans casser tout le reste du code
		}

		/**
		* @brief Cherche les formulaires les plus récents
		*/
		function allLastForms() {
			// TODO: switch status

			//return $this->goQuery("SELECT F.* FROM form F WHERE date=(SELECT MAX(date) FROM form WHERE username=F.username);");
			//return $this->goQuery("SELECT u.username, u.lastname, u.firstname, f.ens1, s.ens2, s.spec1, s.spec2, m.* FROM users u, students s, (SELECT * FROM form f WHERE date=(SELECT MAX(date) FROM form WHERE username=f.username)) m WHERE s.username=u.username AND m.username=u.username;");

			return $this->goQuery("SELECT f.*, u.firstname, u.lastname, MAX(f.date) FROM form f, users u GROUP BY f.username");
		}

		/**
		* @brief Renvoie la liste des classes à l'aide de la table students
		*/
		function classesQuery() {
			// TODO: switch status
			return $this->goQuery("SELECT class FROM students GROUP BY class");
		}

		/**
		* @brief Renvoie la liste des étudiants de la classe : $classe
		* @param classe - classe de l'étudiant (exemple 'T01')
		*/
		function studentsByClasseQuery($classe) {
			// TODO: switch status
			return $this->goQuery("SELECT u.username, u.lastname, u.firstname, u.password, s.ine, s.class FROM users u, students s WHERE u.username=s.username AND s.class=:classe",$classe);
		}

		/**
		* @brief Renvoie la liste des profs de spé à l'aide de la table users et du statut
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
			if(!$pswd) {
				$pswd = $this->random();
			}
			return $this->goQuery("INSERT INTO users (username,password,firstname,lastname,status,email) VALUES (LOWER(:user) , PASSWORD(:pswd) , :firstname , :lastname , :status , :email)",$user,$pswd,$firstname,$lastname,$status,$email);
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

		/**
		* @brief Efface l'utilisateur passé en paramètre de la table users et students s'il existe dans cette table
		* @param user - nom d'utilisateur (insensible à la casse)
		* @return - 1 si succès, 0 si erreur
		*/
		function deleteUser(string $user) {
			$this->goQuery("DELETE FROM students WHERE username=:user",$user);
			return $this->goQuery("DELETE FROM users WHERE username=:user",$user);
		}

		// à voir en considérant les changements dans la base de données à cause des questions à double spé
		function createStudent($user,$ine,$class) {
			//createUser doit être effectuée avant
			if(!$this->userQuery($user)) {
				return false;
			}
			return $this->goQuery("INSERT INTO students (username,ine,class) VALUES (LOWER(:user),:ine,:class)",$user,$ine,$class);
		}

		/**
		* @brief Modifie les données dans le formulaire actif d'un utilisateur (étudiant). Le formulaire actif est le formulaire le plus récent dans la base de données
		* @param user - nom de l'utilisateur dans la base de données
		* @param q1 - première question
		* @param q2 - deuxième question
		* @return - rowCount de stmt; 1 si succès, 0 si erreur, autre chose si grosse erreur
		*/
		function updateForm($user,$q1,$q2,$ens1,$ens2,$spec11,$spec12,$spec21,$spec22) {
			return $this->goQuery("INSERT INTO form (`username`, `q1`, `q2`, `ens1`,`ens2`,`spec11`,`spec12`,`spec21`,`spec22`) VALUES (LOWER(:user), :q1, :q2, :ens1, :ens2, :spec11, :spec12, :spec21, :spec22)",$user,$q1,$q2,$ens1,$ens2,$spec11,$spec12,$spec21,$spec22);
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
			$info = $this->userQuery($user);
			$form = $this->formQuery($stdt);

			switch ($info["status"]) {
				case 2 :
					return $this->goQuery("UPDATE `form` SET provalid = CURRENT_TIME() WHERE `form`.`username` = :stdt;",$stdt);
				case 1 :
					return $this->goQuery("UPDATE `form` SET ".($user == $form["ens1"] ? "`ens1valid`" : "`ens2valid`")." = CURRENT_TIME() WHERE `form`.`username` = :stdt;",$stdt);
				default:
					return false;
			}
		}

		function homonyms($user) {
			return $this->bdd->query("SELECT * FROM users WHERE username LIKE '".$user."%'")->rowCount();
		}
	}
?>
