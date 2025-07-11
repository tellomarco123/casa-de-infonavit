<?php
/**}
 * 
 */

 class IndexModel extends ModelBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
        try {
            $query = $this->con->pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
            $query->bindParam(':usuario', $username);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
