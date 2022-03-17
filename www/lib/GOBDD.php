<?php
    class GOBDD {
        private $bdd;

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
        * @brief Tire toutes les infos d'une entrée dans une table donnée, sélectionnée selon une valeur et une colonne données
        * @param table - table dans laquelle chercher
        * @param col - colonne selon laquelle chercher
        * @param id - valeur identifiante à chercher;
        * @return rslt - array contenant les colonnes en clé et les valeurs
        */
        /*function generalSelect(string $table, string $col, int $id) {
            $request = "SELECT * FROM `".$table."` WHERE ".$col."=:id/".$id."<br>";
            $stmt = $this->bdd->prepare($request);
            if (!$stmt) {
                echo "\nPDO::errorInfo():\n";
                echo $bdd->errorInfo();
            }
            //echo $stmt->bindParam(':id',$id,PDO::PARAM_INT)."<br>";
        	if(!$stmt->execute()){
                var_dump($stmt->errorInfo());
            }
            //var_dump($stmt);
        	$rslt = $stmt->fetch(PDO::FETCH_ASSOC); // sort un array clé-valeur
            return $rslt;
        }*/

        /**
        * @brief Fonction générale pour INSERT
        */
		/*
        function generalInsert(string $table, array $data) {
            $q = "INSERT INTO".$table."(";
            foreach($data as $a => $b) {
                $q .= $a.",";
            }
            $q .= ") VALUES (";
            foreach($data as $a => $b) {
                $q .=  ":".$a.",";
            }
            $stmt = $this->bdd->prepare($q);
            foreach($data as $a => $b) {
                $stmt->bindParam(":".$a,$b);
            }
            $stmt->execute();
        }*/

		function userQuery(string $user) {
			$stmt = $this->bdd->prepare("SELECT * FROM users WHERE username = LOWER(:user)");
			if(!$stmt) {
				echo "\nPDO::errorInfo():\n";
				echo $bdd->errorInfo();
			}
			$stmt->bindParam(':user',LOWER($user),PDO::PARAM_STR);
			if(!$stmt->execute()){
				var_dump($stmt->errorInfo());
			}
			$rslt = $stmt->fetch(PDO::FETCH_ASSOC);   // sort un array clé-valeur
			return $rslt;
		}

		function changePassword($user, $pswd) {
			$stmt = $this->bdd->prepare("UPDATE users SET password=PASSWORD(:pswd) WHERE username = LOWER(:user)");
			if(!$stmt) {
				echo "\nPDO::errorInfo():\n";
				echo $bdd->errorInfo();
			}
			$stmt->bindParam(':user',LOWER($user),PDO::PARAM_STR);
			$stmt->bindParam(':pswd',$pswd,PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->rowCount();
		}

		function studentQuery($user){
			$stmt = $this->bdd->prepare("SELECT * FROM students WHERE username = LOWER(:user)");
			if(!$stmt) {
				echo "\nPDO::errorInfo():\n";
				echo $bdd->errorInfo();
			}
			$stmt->bindParam(':user',LOWER($user),PDO::PARAM_STR);
			if(!$stmt->execute()){
				var_dump($stmt->errorInfo());
			}
			$rslt = $stmt->fetch(PDO::FETCH_ASSOC);   // sort un array clé-valeur
			return $rslt;
		}

		function checkCredentials($user,$pswd) {
			$user = userQuery($user);
			$stmt = $this->bdd->prepare("SELECT * FROM users WHERE username = LOWER(:user) AND password=PASSWORD(:pswd)");
			$stmt->bindParam(':user',LOWER($user),PDO::PARAM_STR);
			$stmt->bindParam(':pswd',$pswd,PDO::PARAM_STR);
			$stmt->execute();
			return ($stmt->rowCount() == 1 ? 1 : 0);
		}

		function formHistoryQuery(string $user) {
			$stmt = $this->bdd->prepare("SELECT * FROM forms WHERE username = LOWER(:user);");
			$stmt->bindParam(':user',LOWER($user),PDO::PARAM_STR);
			$stmt->execute();
			$rslt = $stmt->fetch(PDO::FETCH_ASSOC);   // sort un array clé-valeur
			return $rslt;
		}

		function formQuery($user) {
			$stmt = $this->bdd->prepare("SELECT TOP 1 * from forms WHERE username = LOWER(:user) ORDER BY date DESC;");
			$stmt->bindParam(':user',LOWER($user),PDO::PARAM_STR);
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
			$stmt->bindParam(':user',LOWER($user),PDO::PARAM_STR);
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
			$stmt->bindParam(':user',LOWER($user),PDO::PARAM_STR);
			$stmt->bindParam(':spec1',$spec1,PDO::PARAM_STR);
			$stmt->bindParam(':spec2',$spec2,PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->rowCount();;
		}

		/*function swapForm() {}*/ // TODO: 
    }
?>
