<?php
    class GOBDD {
        private $bdd;

		/**
		* @param host - domaine du SGBD
		* @param db - nom de la base de données
		* @param user - nom d'utilisateur; à stocker dans un fichier séparé et sécurisé
		* @param pswd - mot de passe; à stocker dans un fichier séparé et sécurisé
		*/
        function __construct(string $host, string $db, string $user, string $pswd) {
            try {
                $this->bdd = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8',$user,$pswd);
                //if ($this->bdd) echo "Connexion réussie";
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
                if ($e) echo $e;
            }
        }

		/**
		* @brief Cherche un utilisateur et retourne les informations sur lui
		* @param user - Nom d'utilisateur à chercher
		* @return rslt - tableau associatif contenant toutes les informations, avec ces paires : <ul><li>username: nom d'utilisateur</li><li>password: mot de passe hashé</li><li>firstname: prénom</li><li>lastname: nom de famille</li><li>status: grade de l'utilisateur; 0: étudiant; 1: enseignant; 2: proviseur adjoint; 3: secrétaire</li><li>email: adresse email</li><ul>
		*/
		function userQuery(string $user) {
			$stmt = $this->bdd->prepare("SELECT * FROM users WHERE username = LOWER(:user)");
			if(!$stmt) {
				echo "\nPDO::errorInfo():\n";
				echo $bdd->errorInfo();
			}
			$stmt->bindParam(':user',strtolower($user),PDO::PARAM_STR);
			if(!$stmt->execute()){
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
			$stmt = $this->bdd->prepare("UPDATE users SET password=PASSWORD(:pswd) WHERE username = LOWER(:user)");
			if(!$stmt) {
				echo "\nPDO::errorInfo():\n";
				echo $bdd->errorInfo();
			}
			$stmt->bindParam(':user',strtolower($user),PDO::PARAM_STR);
			$stmt->bindParam(':pswd',$pswd,PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->rowCount();
		}

		/**
		* @brief Cherche un étudiant et retourne les informations sur lui
		* @param user - Nom d'utilisateur de l'étudiant à chercher
		* @return rslt - tableau associatif contenant toutes les informations, avec ces paires : <ul><li>username: nom d'utilisateur</li><li>ine: identifiant INE crypté</li><li>spec1: spécialité 1</li><li>spec2: spécialité 2</li><li>ens1: nom d'utilisateur de l'enseignant 1</li><li>ens2: nom d'utilisateur de l'enseignant 2</li><li>etabville: etablissement et ville; peut-être inutile</li><ul>
		*/
		function studentQuery($user){
			$stmt = $this->bdd->prepare("SELECT * FROM students WHERE username = LOWER(:user)");
			if(!$stmt) {
				echo "\nPDO::errorInfo():\n";
				echo $bdd->errorInfo();
			}
			$stmt->bindParam(':user',strtolower($user),PDO::PARAM_STR);
			if(!$stmt->execute()){
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
			$user = userQuery($user);
			$stmt = $this->bdd->prepare("SELECT * FROM users WHERE username = LOWER(:user) AND password=PASSWORD(:pswd)");
			$stmt->bindParam(':user',strtolower($user),PDO::PARAM_STR);
			$stmt->bindParam(':pswd',$pswd,PDO::PARAM_STR);
			$stmt->execute();
			return ($stmt->rowCount() == 1 ? 1 : 0);
		}

		function formHistoryQuery(string $user) {
			$stmt = $this->bdd->prepare("SELECT * FROM forms WHERE username = LOWER(:user);");
			$stmt->bindParam(':user',strtolower($user),PDO::PARAM_STR);
			$stmt->execute();
			$rslt = $stmt->fetch(PDO::FETCH_ASSOC);   // sort un array clé-valeur
			return $rslt;
		}

		function formQuery($user) {
			$stmt = $this->bdd->prepare("SELECT TOP 1 * from forms WHERE username = LOWER(:user) ORDER BY date DESC;");
			$stmt->bindParam(':user',strtolower($user),PDO::PARAM_STR);
			$stmt->execute();
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
			$stmt = $this->bdd->prepare("UPDATE table SET q1=:q1, q2=:q2 WHERE (SELECT TOP 1 * from forms WHERE username = LOWER(:user) ORDER BY date DESC);");
			$stmt->bindParam(':user',strtolower($user),PDO::PARAM_STR);
			$stmt->bindParam(':q1',$q1,PDO::PARAM_STR);
			$stmt->bindParam(':q2',$q2,PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->rowCount();;
		}

		/**
		* @brief Modifie les données d'un étudiant. Ces données étant fixes en théorie, elles sont séparées des données du formulaire
		* @param user - nom de l'utilisateur dans la base de données
		* @param spec1 - première spécialité
		* @param spec2 - deuxième spécialité
		* @return - rowCount de stmt; 1 si succès, 0 si erreur, autre chose si grosse erreur
		*/
		function updateStudent() {
			$stmt = $this->bdd->prepare("UPDATE table SET spec1=:spec1, spec2=:spec2 WHERE (SELECT TOP 1 * from forms WHERE username = LOWER(:user) ORDER BY date DESC)");
			$stmt->bindParam(':user',strtolower($user),PDO::PARAM_STR);
			$stmt->bindParam(':spec1',$spec1,PDO::PARAM_STR);
			$stmt->bindParam(':spec2',$spec2,PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->rowCount();;
		}

		/*function swapForm() {}*/ // TODO:
    }
?>
