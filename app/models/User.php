<?php 
namespace App\Models;
require_once __DIR__ . '/../../config/Database.php';

use Config\Database;
use PDO;
use PDOException;
abstract class User{
    protected int $idUser;
    protected string $username;
    protected string $email;
    protected string $password;
    protected string $phone;
    protected string $image;

    public function __construct(int $idUser,string $username,string $email,string $password,string $image, string $phone) {
        $this->idUser = $idUser;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->image = $image ;  
        $this->phone = $phone;
      }

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getImage(): string
    {
        return $this->image;
    }


    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }



    
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public static function login(string $email, string $password): ?User {
        $conn = Database::getConnection();  
    
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $phone = $user['phone'] ?? '';
        if ($user && password_verify($password, $user['password'])) {
            $id = $user['iduser'];
    
            $stmt = $conn->prepare("SELECT iduser FROM admin WHERE iduser = ?");
            $stmt->execute([$id]);
            if ($stmt->fetch()) {
                return new Admin($user['iduser'], $user['username'], $user['email'],"", $user['image'],$phone);
            }
    
            $stmt = $conn->prepare("SELECT iduser FROM participant WHERE iduser = ?");
            $stmt->execute([$id]);
            if ($stmt->fetch()) {
                return new Participant($user['iduser'], $user['username'], $user['email'],"", $user['image'],$phone);
            }
    
            $stmt = $conn->prepare("SELECT iduser FROM organisateur WHERE iduser = ?");
            $stmt->execute([$id]);
            if ($stmt->fetch()) {
                return new Organisateur($user['iduser'], $user['username'], $user['email'], "", $user['image'],$phone);
            }
        }
    
        return null;
    }
    
    
 
    

    public static function isEmailTaken(string $email): bool {
        $conn = Database::getConnection();  

        $sql = "SELECT email FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(1, $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return true;
        }

        return false;
    }

    public static function register($name, $email, $password, $role) {
        $conn = Database::getConnection();  
    
        $defaultImage = "../../public/assets/images/profil/profiledefault.jpg";
    
        if ($role === 'participant') {
            $sql = "INSERT INTO participant (username, email, password, image) VALUES (?, ?, ?, ?)";
        } elseif ($role === 'organisateur') {
            $sql = "INSERT INTO organisateur (username, email, password, image) VALUES (?, ?, ?, ?)";
        } else {
            throw new PDOException("Invalid role: $role");
        }
    
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $name, PDO::PARAM_STR);
        $stmt->bindValue(2, $email, PDO::PARAM_STR);
        $stmt->bindValue(3, password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $stmt->bindValue(4, $defaultImage, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
    

    }
    

    

    

  
    

    


?>