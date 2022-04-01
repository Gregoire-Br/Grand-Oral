<?php
    class GOBDD {
        private $bdd;
		private $debugToggle = 1;

		/*define("ETUDIANT",0);
		define("ENSEIGNANT",1);
		define("PROVISEUR",2);
		define("SECRETAIRE",3);*/

		/**
		* @param host - domaine du SGBD
		* @param db - nom de la base de données
		* @param user - nom d'utilisateur; à stocker dans un fichier séparé et sécurisé
		* @param pswd - mot de passe; à stocker dans un fichier séparé et sécurisé
		*/
        function __construct(string $host, string $db, string $user, string $pswd, $debug = 0) {
            try {
                $this->bdd = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8',$user,$pswd);
                if ($this->bdd && $this->debugToggle) echo "Connexion réussie<br>";
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
                if ($e) echo $e;
            }
			$this->$debugToggle = $debug;
        }

		/**
		* Generate a random string, using a cryptographically secure
		* pseudorandom number generator (random_int)
		*
		* For PHP 7, random_int is a PHP core function
		* For PHP 5.x, depends on https://github.com/paragonie/random_compat
		*
		* https://stackoverflow.com/a/31284266/12113891
		*
		* @param int $length      How many characters do we want?
		* @param string $keyspace A string of all possible characters
		*                         to select from
		* @return string
		*/
		private function random_str(
		    $length,
		    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
		) {
		    $str = '';
		    $max = mb_strlen($keyspace, '8bit') - 1;
		    if ($max < 1) {
		        throw new Exception('$keyspace must be at least two characters long');
		    }
		    for ($i = 0; $i < $length; ++$i) {
		        $str .= $keyspace[random_int(0, $max)];
		    }
		    return $str;
		}

		/**
		* @brief Cherche un utilisateur et retourne les informations sur lui
		* @param user - Nom d'utilisateur à chercher
		* @return rslt - tableau associatif contenant toutes les informations, avec ces paires : <ul><li>username: nom d'utilisateur</li><li>password: mot de passe hashé</li><li>firstname: prénom</li><li>lastname: nom de famille</li><li>status: grade de l'utilisateur; 0: étudiant; 1: enseignant; 2: proviseur adjoint; 3: secrétaire</li><li>email: adresse email</li></ul>
		*/
		function userQuery(string $user) {
			$lcuser = strtolower($user);
			$stmt = $this->bdd->prepare("SELECT * FROM users WHERE username = LOWER(:user)");
			if(!$stmt && $this->debugToggle) {
				echo "<br>userQuery - PDO::errorInfo():<br>";
				echo $this->bdd->errorInfo();
			}
			$stmt->bindParam(':user',$lcuser,PDO::PARAM_STR);
			if(!$stmt->execute() && $this->debugToggle){
				var_dump($stmt->errorInfo());
			}
			$rslt = $stmt->fetch(PDO::FETCH_ASSOC);   // sort un array clé-valeur
			return $rslt;
		}

		/**
		* @brief Change le mot de passe d'un utilisateur
		* @param user - nom d'utilisateur
		* @param pswd - nouveau mot de passe. Ne doit pas être hashé car cette méthode s'en chargera
		* @return - rowCount de stmt; 1 si succès, 0 si erreur, autre chose si grosse erreur
		*/
		function changePassword($user, $pswd) {
			$lcuser = strtolower($user);
			$stmt = $this->bdd->prepare("UPDATE users SET password=PASSWORD(:pswd) WHERE username = LOWER(:user)");
			if(!$stmt && $this->debugToggle) {
				echo "<br>changePassword - PDO::errorInfo():<br>";
				echo $this->bdd->errorInfo();
			}
			$stmt->bindParam(':user',$lcuser,PDO::PARAM_STR);
			$stmt->bindParam(':pswd',$pswd,PDO::PARAM_STR);
			if(!$stmt->execute() && $this->debugToggle){
				var_dump($stmt->errorInfo());
			}
			return $stmt->rowCount();
		}

		/**
		* @brief Cherche un étudiant et retourne les informations sur lui
		* @param user - Nom d'utilisateur de l'étudiant à chercher
		* @return rslt - tableau associatif contenant toutes les informations, avec ces paires : <ul><li>username: nom d'utilisateur</li><li>ine: identifiant INE crypté</li><li>spec1: spécialité 1</li><li>spec2: spécialité 2</li><li>ens1: nom d'utilisateur de l'enseignant 1</li><li>ens2: nom d'utilisateur de l'enseignant 2</li><li>etabville: etablissement et ville; peut-être inutile</li></ul>
		*/
		function studentQuery($user){
			$lcuser = strtolower($user);
			$stmt = $this->bdd->prepare("SELECT * FROM students WHERE username = LOWER(:user)");
			if(!$stmt && $this->debugToggle) {
				echo "<br>studentQuery - PDO::errorInfo():<br>";
				echo $this->bdd->errorInfo();
			}
			$stmt->bindParam(':user',$lcuser,PDO::PARAM_STR);
			if(!$stmt->execute() && $this->debugToggle){
				var_dump($stmt->errorInfo());
			}
			$rslt = $stmt->fetch(PDO::FETCH_ASSOC);   // sort un array clé-valeur
			return $rslt;
		}

		/**
		* @brief Vérifie la validité d'une paire d'identifiants. Cherche si il existe un compte avec le même nom d'utilisateur et mot de passe
		* @param user - nom d'utilisateur
		* @param pswd - mot de passe
		* @rslt - 1 si il y a un (seul) compte correspondant; 0 si il n'y en a pas (ou si il y en a plus d'un; théoriquement impossible)
		*/
		function checkCredentials($user,$pswd) {
			$lcuser = strtolower($user);
			$user = $this->userQuery($user)['username'];
			$stmt = $this->bdd->prepare("SELECT * FROM users WHERE username = LOWER(:user) AND password=PASSWORD(:pswd)");
			if(!$stmt && $this->debugToggle) {
				echo "<br>checkCredentials - PDO::errorInfo():<br>";
				echo $this->bdd->errorInfo();
			}
			$stmt->bindParam(':user',$lcuser,PDO::PARAM_STR);
			$stmt->bindParam(':pswd',$pswd,PDO::PARAM_STR);
			if(!$stmt->execute() && $this->debugToggle){
				var_dump($stmt->errorInfo());
			}
			return ($stmt->rowCount() == 1 ? 1 : 0);
		}

		// TODO: doc, tests
		function formHistoryQuery(string $user) {
			$lcuser = strtolower($user);
			$stmt = $this->bdd->prepare("SELECT * FROM form WHERE username = LOWER(:user);");
			if(!$stmt && $this->debugToggle) {
				echo "<br>formHistoryQuery - PDO::errorInfo():<br>";
				echo $this->bdd->errorInfo();
			}
			$stmt->bindParam(':user',$lcuser,PDO::PARAM_STR);
			if(!$stmt->execute() && $this->debugToggle){
				var_dump($stmt->errorInfo());
			}
			$rslt = $stmt->fetch(PDO::FETCH_ASSOC);   // sort un array clé-valeur
			return $rslt;
		}

		/**
		* @brief Cherche le formulaire le plus récent pour un utilisateur
		* @param user - nom d'utilisateur
		* @return rslt - tableau associatif contenant toutes les informations, avec ces paires : <ul><li>id: identifiant unique du formulaire</li><li>username: nom d'utilisateur</li><li>q1: question 1</li><li>q2: question 2</li><li>e1valid: 1 si validé par enseignant 1, sinon 0</li><li>e1valid: 1 si validé par enseignant 1, sinon 0</li><li>proValid: 1 si validé par proviseur adjoint, sinon 0</li></ul>
		*/
		function formQuery($user) {
			$lcuser = strtolower($user);
			$stmt = $this->bdd->prepare("SELECT * from form WHERE username = LOWER(:user) ORDER BY date DESC LIMIT 1;");
			if(!$stmt && $this->debugToggle) {
				echo "<br>formQuery - PDO::errorInfo():<br>";
				echo $this->bdd->errorInfo();
			}
			$stmt->bindParam(':user',$lcuser,PDO::PARAM_STR);
			if(!$stmt->execute() && $this->debugToggle){
				var_dump($stmt->errorInfo());
			}
			$rslt = $stmt->fetch(PDO::FETCH_ASSOC);   // sort un array clé-valeur
			return $rslt;
		}

		/**
		* @brief Modifie les données dans le formulaire actif d'un utilisateur (étudiant). Le formulaire actif est le formulaire le plus récent dans la base de données
		* @param user - nom de l'utilisateur dans la base de données
		* @param q1 - première question
		* @param q2 - deuxième question
		* @return - rowCount de stmt; 1 si succès, 0 si erreur, autre chose si grosse erreur
		*/
		function updateForm(string $user, string $q1, string $q2) {
			$lcuser = strtolower($user);
			//$stmt = $this->bdd->prepare("UPDATE form SET `q1`=:q1,`q2`=:q2 WHERE `username`=:user ORDER BY date DESC LIMIT 1");
			$stmt = $this->bdd->prepare("INSERT INTO form (`username`, `q1`, `q2`) VALUES (:user, :q1, :q2)");
			if(!$stmt && $this->debugToggle) {
				echo "<br>updateForm - PDO::errorInfo():<br>";
				echo $this->bdd->errorInfo();
			}
			$stmt->bindParam(':user',$lcuser,PDO::PARAM_STR);
			$stmt->bindParam(':q1',$q1,PDO::PARAM_STR);
			$stmt->bindParam(':q2',$q2,PDO::PARAM_STR);
			if(!$stmt->execute() && $this->debugToggle){
				var_dump($stmt->errorInfo());
			}
			return $stmt->rowCount();;
		}

		/**
		* @brief Modifie les données d'un étudiant. Ces données étant fixes en théorie, elles sont séparées des données du formulaire
		* @param user - nom de l'utilisateur dans la base de données
		* @param spec1 - première spécialité
		* @param spec2 - deuxième spécialité
		* @return - rowCount de stmt; 1 si succès, 0 si erreur, autre chose si grosse erreur
		*/
		function updateStudent($user,$spec1,$spec2) {
			$lcuser = strtolower($user);
			$stmt = $this->bdd->prepare("UPDATE students SET spec1=:spec1, spec2=:spec2 WHERE username=:user;");

			if(!$stmt && $this->debugToggle) {
				echo "<br>updateStudent - PDO::errorInfo():<br>";
				echo $this->bdd->errorInfo();
			}

			$stmt->bindParam(':user',$lcuser,PDO::PARAM_STR);
			$stmt->bindParam(':spec1',$spec1,PDO::PARAM_STR);
			$stmt->bindParam(':spec2',$spec2,PDO::PARAM_STR);

			if(!$stmt->execute() && $this->debugToggle){
				var_dump($stmt->errorInfo());
			}
			return $stmt->rowCount();;
		}

		// cassé
		// function createUser($user,$status,$firstname,$lastname,$email) {
		// 	echo "func start<br>debug: ".strval($this->debugToggle)."<br>";
		// 	$lcuser = strtolower($user);
		// 	echo "user :".$user."<br>";
		// 	$usrStmt = $this->bdd->prepare("INSERT INTO users (username, status, password) VALUES (:user, :status, PASSWORD(:password)) ");
		// 	var_dump($usrStmt);
		// 	echo "<br>";
		// 	/*if(!$usrStmt && $this->debugToggle) {
		// 		echo "<br>userQuery - PDO::errorInfo():<br>";
		// 		echo $this->bdd->errorInfo();
		// 	}*/
		//
		// 	$password = "fuck"/*random_str(10)*/;
		//
		// 	$usrStmt->bindParam(':user',$lcuser,PDO::PARAM_STR);
		// 	$usrStmt->bindParam(':status',$status,PDO::PARAM_INT);
		// 	/*$usrStmt->bindParam(':firstname',$firstname,PDO::PARAM_STR);
		// 	$usrStmt->bindParam(':lastname',$lastname,PDO::PARAM_STR);
		// 	$usrStmt->bindParam(':email',$email,PDO::PARAM_STR);*/
		// 	$usrStmt->bindParam(':password',$password,PDO::PARAM_STR);
		// 	var_dump($usrStmt);
		// 	echo "<br>";
		//
		// 	$usrStmt->execute();
		// 	var_dump($usrStmt->errorInfo());
		//
		// 	/*if(!$usrStmt->execute() && $this->debugToggle){
		// 		var_dump($usrStmt->errorInfo());
		// 	}*/
		// 	var_dump($usrStmt);
		// 	echo "<br>";
		// 	#$sdtStmt = $this->bdd>prepare("INSERT INTO students (user) VALUES (:user);");
		// 	return $usrStmt->rowCount();
		// }

		function createUser(string $username, int $status, string $email, string $firstname="", string $lastname="") {
			$username = strtolower($username);
			$password = "abc";

			try {
				$stmt = $this->bdd->prepare("INSERT INTO users (`username`, `password`, `firstname`, `lastname`, `email`,`status`) VALUES (:username,PASSWORD(:password),:firstname,:lastname,:email,:status)");
				if(!$stmt){
					echo "Erreur prepare(): <br>";
					var_dump($this->bdd->errorInfo());
				}
			} catch(PDOException $e) {
				die('Exception prepare(): ' . $e->getMessage()."<br>");
                if ($e) echo $e;
			}

			if(!$stmt->bindParam(":username",$username)
				|| !$stmt->bindParam(":password",$password)
				|| !$stmt->bindParam(":firstname",$firstname)
				|| !$stmt->bindParam(":lastname",$lastname)
				|| !$stmt->bindParam(":email",$email)
				|| !$stmt->bindParam(":status",$status)) {
					echo "Erreur bindParam(): <br>";
					var_dump($stmt->errorInfo());
			}

			if(!$stmt->execute()){
				echo "Erreur execute(): <br>";
				var_dump($stmt->errorInfo());
			}
		}
    }
?>
