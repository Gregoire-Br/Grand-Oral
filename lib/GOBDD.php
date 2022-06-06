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
				//Initialisation de PDO
				$this->bdd = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8',$user,$pswd);
				if ($this->bdd && $this->debug) echo "Connexion à la base de données '$db' réussie<br>";
			} catch (Exception $e) {
				if ($e) echo $e;
				die('Erreur: ' . $e->getMessage());
			}
		}


		/**
		* @brief Prépare la requête $rq, lie les paramètres $params aux marqueurs, exécute et renvoie le résultat.
		* @param rq - requête à effectuer. Les champs de paramètre doivent être remplis avec des marqueurs.
		* Exemple : `SELECT * FROM users WHERE username = :user`
		* @param params - valeurs à lier aux marqueurs de paramètre dans la requête. Un nombre indéfini de paramètres peut être fourni; ils seront liés aux marqueurs dans l'ordre.
		* @return - Si la requête est SELECT, la méthode renvoie un tableau à deux dimensions; le premier index étant le numéro de ligne dans le jeu de résultats et le second étant une clé correspondant au nom de colonne d'une cellule de la ligne. Par exemple, pour obtenir le nom d'utilisateur du premier utilisateur retourné par  $foo = allUsers(), on utiliserait $foo[0]["username"].\n
		* <b>NOTE : Actuellement, goQuery("SELECT [...]") renvoie TOUJOURS un tableau à deux dimensions, même si la requête renvoie un seul résultat. Cela s'applique aussi aux méthodes qui dépendent de goQuery. Pour accéder à un résultat à une seule ligne, il faut donc utiliser la forme $var[0].</b>
		* Si la requête n'est pas SELECT, la méthode renvoie le nombre de lignes affectées par la requête.\n
		*/
		private function goQuery(string $rq, ...$params) {
			try {
				//trouve ts les mots commencant par ':'
				$regex = "/:\w+/i";

				// Préparation de la requête
				$stmt = $this->bdd->prepare($rq);
				if(!$stmt) {
					throw new Exception("Erreur requête",1);
				}

				// Liaison des paramètres
				preg_match_all($regex,$rq,$matches);
				for($i=0; $i<count($matches[0]); $i++) {
					if(!$stmt->bindParam($matches[0][$i], $params[$i])) {
						if($this->debug) {
							echo "<i>errorInfo():</i><br>";
							print_r($stmt->errorInfo());
							echo "<br>";
							echo "<br>";
							print_r($stmt);
						}
						throw new Exception("Erreur bindParam",2);
					}
				}

				//Exécution de la requête
				if(!$stmt->execute() && $this->debug){
					print_r($stmt->errorInfo());
					echo "<br>";
				}

				// Décision sur la valeur à renvoyer en fonction du type de requête
				if(strtoupper(explode(' ',trim($rq))[0]) == "SELECT") {
					if($this->debug) {
						print_r($stmt->errorInfo());
						echo "<br>";
						print_r($stmt);
						echo "<br><br>";
					}
					return $stmt->fetchAll(PDO::FETCH_BOTH);
				} else {
					if($this->debug) echo "$rq<br>rq: !SELECT<br>";
					return $stmt->rowCount();
				}
			} catch(Exception $e) {
				if($this->debug) {
					print_r($this->bdd);
					echo "<br>";
					print_r($stmt);
					echo "<br>";
				}
				echo "Exception dans le fichier ".$e->getFile()." ligne ".$e->getLine()." : ".$e->getMessage()."<br>";
				if($e->getCode() == 1) {
					print_r($this->bdd->errorInfo());
					echo "<br>";
				} else {
					print_r($stmt->errorInfo());
					echo "<br>";
				}
			}
		}

		/**
		* @brief Génère une chaîne pseudo-aléatoire de longueur length. Utilisée pour les tests.
		* @param length - longueur de la chaîne en caractères (défaut: 8)
		* @return - chaîne de caractères
		*/
		private function random($length = 8) {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&?";
			$str = substr(str_shuffle($chars), 0, $length);
			return $str;
		}

		/**
		* @brief Méthode de test unitaire. Exécute une autre méthode de la classe par rappel et affiche son résultat sous une forme formattée.
		* @param func - nom de la méthode sous forme de chaîne de caractères <strong>(la méthode doît être membre de GOBDD)</strong>
		* @param args - arguments à passer à la méthode
		* @return - retour de la fonction de rappel
		*/
		function ut($func, ...$args) {
			echo "<strong>$func :</strong><br>";
			$rslt = call_user_func_array(array($this, $func), $args);
			echo "<pre>";
			print_r($rslt);
			echo "</pre><br><br>";
			return $rslt;
		}


		// var_dump formaté
		// Par M.MIOSSEC
		// TODO : utiliser debug.php à la place et éviter la duplication
		/*function debugPrintVariable($nomvariable) {
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
		}*/

		/**
		* @brief Cherche les données sur un utilisateur
		* @param user - nom de l'utilisateur, insensible à la casse
		* @return - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery().\n
		* Les noms des colonnes sont les suivants:\n
		* <ul>
		* 	<li>username : nom d'utilisateur</li>
		* 	<li>status : rang de l'utilisateur; 0 pour étudiant, 1 pour enseignant, 2 pour proviseur, 3 pour secrétaire</li>
		* 	<li>password : mot de passe hashé par PASSWORD()</li>
		* 	<li>lastLog : date et heure de dernière connexion; NULL si l'utilisateur ne s'est jamais connecté</li>
		* 	<li>firstname : prénom</li>
		* 	<li>lastname : nom de famille</li>
		* 	<li>email : adresse email</li>
		* </ul>
		*/
		function userQuery(string $user) {
			return $this->goQuery("SELECT * FROM users WHERE username=LOWER(:user)",$user);
		}

		/**
		* @brief Renvoie les données de tous les utilisateurs
		* @return - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery() et GOBDD::userQuery()
		*/
		function allUsers(){
			return $this->goQuery("SELECT * FROM users");
		}

		/**
		* @brief Renvoie les données de tous les étudiants
		* @return - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery() et GOBDD::studentQuery()
		*/
		function allStudents(){
			return $this->goQuery("SELECT * FROM students");
		}

		/**
		* @brief Cherche la version la plus récente du formulaire d'un utilisateur
		* @param user - nom d'utilisateur
		* @return - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery().\n
		* Les noms des colonnes sont les suivants:\n
		* <ul>
		* <li>id: identifiant unique du formulaire</li>
		* <li>username: nom d'utilisateur du candidat</li>
		* <li>date : date de création du formulaire</li>
		* <li>q1: question 1</li>
		* <li>q2: question 2</li>
		* <li>ens1: nom d'utilisateur de l'enseignant encadrant 1</li>
		* <li>ens2: nom d'utilisateur de l'enseignant encadrant 2</li>
		* <li>ens1valid: date de validation par l'enseignant encadrant 1; NULL si non validé</li>
		* <li>ens2valid: date de validation par l'enseignant encadrant 2; NULL si non validé</li>
		* <li>provalid: date de validation par le proviseur adjoint; NULL si non validé</li>
		* <li>spec11: spécialisation en lien avec la question 1</li>
		* <li>spec12: 2e spécialisation en lien avec la question 1 ; NULL si il n'y en a pas</li>
		* <li>spec21: spécialisation en lien avec la question 2</li>
		* <li>spec22: 2e spécialisation en lien avec la question 2 ; NULL si il n'y en a pas</li>
		* </ul>
		*/
		function formQuery(string $user) {
			return $this->goQuery("SELECT * from form WHERE username = LOWER(:user) ORDER BY date DESC LIMIT 1",$user);
		}

		/**
		* @brief Cherche toutes les versions du formulaire d'un candidat présentes dans la base de données.
		* @param user - nom d'utilisateur du candidat
		* @return - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery() et GOBDD::formQuery()
		*/
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
			return ($rslt[0]["username"] ? 1 : 0);
		}

		/**
		* @brief Cherche un étudiant et retourne les informations sur lui
		* @param user - Nom d'utilisateur de l'étudiant à chercher
		* @return rslt - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery().\n
		* Les noms des colonnes sont les suivants:\n
		* <ul>
		* <li>username: nom d'utilisateur</li>
		* <li>ine: identifiant INE crypté</li>
		* <li>class: nom de la classe</li>
		* </ul>
		*/
		function studentQuery(string $user) {
			return $this->goQuery("SELECT * FROM students WHERE username = LOWER(:user)",$user);
		}

		/**
		* @brief Renvoie la liste des spécialités
		* @param Aucun
		* @return rslt - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery().\n
		* Les noms des colonnes sont les suivants:\n
		* <li>id : identifiant numérique unique pour la spécialité</li>
		* <li>spec : nom de la spécialité</li>
		*/
		function allSpecs() {
			return $this->goQuery("SELECT * FROM specs");
		}

		/**
		* @brief Cherche les versions les plus récentes des formulaires de tous les élèves encadrés par un enseignant
		* @param user - nom d'utilisateur de l'enseignant encadrant
		* @return - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery() et GOBDD::formQuery()
		*/
		function relatedForms(string $user) {
			// TODO: switch status
			//return $this->goQuery("SELECT f.*, u.firstname, u.lastname, MAX(f.date) FROM form f, users u WHERE f.ens1 = :self OR f.ens2 = :self GROUP BY f.username",$user,$user);
			return $this->goQuery("SELECT * from form WHERE ens1 = LOWER(:user) OR ens2 = LOWER(:user) ORDER BY date DESC LIMIT 1",$user,$user);

		}

		/**
		* @brief Cherche les versions les plus récentes des formulaires de tous les élèves
		* @return - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery() et GOBDD::formQuery()
		*/
		function allLastForms() {
			// TODO: switch status

			//return $this->goQuery("SELECT F.* FROM form F WHERE date=(SELECT MAX(date) FROM form WHERE username=F.username);");
			//return $this->goQuery("SELECT u.username, u.lastname, u.firstname, f.ens1, s.ens2, s.spec1, s.spec2, m.* FROM users u, students s, (SELECT * FROM form f WHERE date=(SELECT MAX(date) FROM form WHERE username=f.username)) m WHERE s.username=u.username AND m.username=u.username;");
			//echo "CECI EST UN APPEL A allLastForms()";

			//SELECT l.* FROM formulaire l INNER JOIN ( SELECT user, MAX(ladate) AS maxDate FROM formulaire GROUP BY user ) groupel ON l.user= groupel.user AND l.ladate = groupel.maxDate
			return $this->goQuery("SELECT f.* from form f INNER JOIN ( SELECT username, MAX(date) AS maxDate FROM form GROUP BY username ) groupef on f.username = groupef.username and f.date = groupef.maxDate");
		}

		/**
		* @brief Cherche toutes les classes trouvables dans la liste des étudiants
		* @return - tableau à deux dimensions contenant un tableau listant les classes. Utiliser $return[0].
		*/
		function classesQuery() {
			return $this->goQuery("SELECT class FROM students GROUP BY class");
		}

		/**
		* @brief Renvoie la liste des étudiants de la classe : $classe
		* @param classe - classe de l'étudiant (exemple 'T01')
		* @return TODO
		*/
		function studentsByClasseQuery($classe) {
			// TODO: switch status
			return $this->goQuery("SELECT u.username, u.lastname, u.firstname, u.password, s.ine, s.class FROM users u, students s WHERE u.username=s.username AND s.class=:classe",$classe);
		}

		/**
		* @brief Renvoie la liste des professeurs
		* @return - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery() et GOBDD::userQuery()
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
		* @param email - adresse mail
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
			return $this->goQuery("UPDATE users SET email=:email, status=:status WHERE username=LOWER(:user)",$email, $status, $user);
		}

		/**
		* @brief Efface l'utilisateur passé en paramètre de la table users et students s'il existe dans cette table
		* @param user - nom d'utilisateur (insensible à la casse)
		* @return - 1 si succès, 0 si erreur
		*/
		function deleteUser(string $user) {
			$this->goQuery("DELETE FROM students WHERE username=LOWER(:user)",$user);
			return $this->goQuery("DELETE FROM users WHERE username=LOWER(:user)",$user);
		}

		/**
		* @brief Ajoute un nouvel étudiant avec les valeurs données.
		* @param user - nom d'utilisateur (insensible à la casse)
		* @param ine - Identifiant National Etudiant
		* @param class - classe de l'étudiant
		* @return - 1 si succès, 0 si erreur
		*/
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
		* @param ens1 - nom d'utilisateur de l'enseignant encadrant 1
		* @param ens2 - nom d'utilisateur de l'enseignant encadrant 2
		* @param spec11 - spécialité liée à la question 1
		* @param spec12 - seconde spécialité liée à la question 1, si il y en a une
		* @param spec21 - spécialité liée à la question 2
		* @param spec22 - seconde spécialité liée à la question 2, si il y en a une
		* @return - rowCount de stmt; 1 si succès, 0 si erreur, autre chose si grosse erreur
		*/
		function updateForm($user,$q1,$q2,$ens1,$ens2,$spec11,$spec12,$spec21,$spec22) {
			if ($this->studentQuery($user)){
				return $this->goQuery("INSERT INTO form (`username`, `q1`, `q2`, `ens1`,`ens2`,`spec11`,`spec12`,`spec21`,`spec22`) VALUES (LOWER(:user), :q1, :q2, :ens1, :ens2, :spec11, :spec12, :spec21, :spec22)",$user,$q1,$q2,$ens1,$ens2,$spec11,$spec12,$spec21,$spec22);
			} else {
				return 0;
			}
		}

		/**
		* @brief Change le mot de passe d'un utilisateur. Le mot de passe fourni est hashé à l'exécution
		* @param user - nom d'utilisateur
		* @param pswd - nouveau mot de passe
		* @return - rowCount de stmt; 1 si succès, 0 si erreur, autre chose si grosse erreur
		*/
		function changePassword($user,$pswd) {
			return $this->goQuery("UPDATE users SET password=PASSWORD(:pswd) WHERE username = LOWER(:user)",$pswd,$user);
		}

		/**
		* @brief Cherche la version la plus récente du formulaire d'un élève par son INE
		* @param ine - Identifiant National Etudiant
		* @return - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery() et GOBDD::formQuery()
		*/
		function formByINE($ine) {
			return $this->goQuery("SELECT f.* FROM form f, students s WHERE s.ine = :ine AND f.username = s.username ORDER BY f.date DESC LIMIT 1",$ine);
		}

		/**
		* @brief Change l'état de validation par l'utilisateur donné sur la dernière version du formulaire d'un utilisateur donné.
		* @param user - nom d'utilisateur du validateur
		* @param stdt - nom d'utilisateur de l'étudiant
		* @return 1 si réussi, 0 si échec
		*/
		function validate($user,$stdt) {
			try {
				$info = $this->userQuery($user);
				$form = $this->formQuery($stdt);
				if (!$info[0]) {
					throw new Exception("Erreur validation : l'utilisateur validateur $user n'existe pas",1);
				}
				if (!$form[0]) {
					throw new Exception("Erreur validation : ce candidat $stdt n'a pas renseigné de formulaire",1);
				}
			} catch (Exception $e) {
				if ($e) echo $e;
				die('Erreur: ' . $e->getMessage());
			}

			switch ($info[0]["status"]) {
				case 2 :
					return $this->goQuery("UPDATE `form` SET provalid = CURRENT_TIME() WHERE id = :id;",$form[0]["id"]);
				case 1 :
					return $this->goQuery("UPDATE `form` SET ".($user == $form[0]["ens1"] ? "`ens1valid`" : "`ens2valid`")." = CURRENT_TIME() WHERE id = :id;",$form[0]["id"]);
				default:
					return 0;
			}
		}

		/**
		* @brief Pour un nom d'utilisateur donné, trouve tous les homonymes et génère un nom d'utilisateur unique ($user + un nombre incrémenté par chaque homonyme). <strong>/!\ ATTENTION : NE FONCTIONNE PAS.</b>
		* @param user - nom d'utilisateur
		* @return - nom d'utilisateur unique
		*/
		function homonyms($user) {
			//ALGO
			//Var:
			//	user: string
			//	n: int
			//	usern: string
			//Dbt:
			//	Si user existe ds bdd
			//		Faire
			//			n++
			//			usern = user + n
			//		tant que usern n'existe pas
			//		retourner usern
			//	retourner user
			//Fin

			$usern = "";
			if($this->userQuery($user)[0]) {
				do {
					$n++;
					$usern = $user . $n;
				} while (!$this->userQuery($usern)[0]);
				return $usern;
			}
			return $user;
		}

		/**
		* @brief Cherche les informations utilisateur et étudiant correspondant à un INE donné.
		* @param INE - Identifiant National Etudiant
		* @return - tableau à deux dimensions comme décrit dans la documentation de GOBDD::goQuery(), GOBDD::userQuery() et GOBDD::studentQuery()
		*/
		function INEquery($ine){
			return $this->goQuery("SELECT * FROM users INNER JOIN students ON users.username = students.username WHERE students.ine = :ine",$ine);
		}

		/**
		* @brief Efface une version de formulaire avec l'identifiant donné
		* @param id - identifiant de la version du formulaire
		* @return - 1 si succès, 0 si erreur
		*/
		function deleteForm($id) {
			return $this->goQuery("DELETE FROM form WHERE id = :id",$id);
		}

		function cleanFormHistory($user) {
			$max = 3;

			$history = $this->formHistoryQuery($user);

			for ($i = $max; $i<=count($history) ; $i++) {
				$this->deleteForm($history[$i]["id"]);
			}
		}

		/**
		* @brief Refuse le formulaire d'un utilisateur, enlevant les validations de tout les validateurs
		* @param user - nom d'utilisateur du candidat
		* @return - 1 si succès, 0 si erreur
		*/
		function deny($user) {
			$form = $this->formQuery($user);
			return $this->goQuery("UPDATE form SET ens1valid = NULL, ens2valid = NULL, provalid = NULL WHERE id = :id",$form[0]["id"]);
		}

		function specQuery($id) {
			return $this->goQuery("SELECT * FROM specs WHERE id = :id",$id);
		}
	}
?>
