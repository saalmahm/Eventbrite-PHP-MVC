<?php 
namespace App\Models;
require_once __DIR__ . '../../config/database.php';  


abstract class User{
    protected int $idUser;
    protected string $username;
    protected string $email;
    protected string $password;
    protected string $phone;
    protected string $image;

    public function __construct(int $idUser,string $username,string $email,string $password,string $role,string $image) {
        $this->idUser = $idUser;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->image = $image ;  
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

    public function getRole(): string
    {
        return $this->role;
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

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public static function login(string $email, string $password): ?User {
        $conn = Database::getConnection();  
    
        $sql = "SELECT * FROM Utilisateur WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['motdepasse'])) {
            $id = $user['iduser'];
    
            $stmt = $conn->prepare("SELECT id FROM admin WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->fetch()) {
                return new Admin($user['iduser'], $user['nom'], $user['email'], $user['motdepasse'], $user['image']);
            }
    
            $stmt = $conn->prepare("SELECT id FROM participant WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->fetch()) {
                return new Participant($user['iduser'], $user['nom'], $user['email'], $user['motdepasse'], $user['image']);
            }
    
            $stmt = $conn->prepare("SELECT id FROM organisateur WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->fetch()) {
                return new Organisateur($user['iduser'], $user['nom'], $user['email'], $user['motdepasse'], $user['image']);
            }
        }
    
        return null;
    }
    
 
    

    public static function isEmailTaken(string $email): bool {
        $conn = Database::getConnection();  

        $sql = "SELECT email FROM Utilisateur WHERE email = ?";
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

        $defaultImage = "../../public/assets/images/userProfiles/profiledefault.jpg";
        $sql = "INSERT INTO Utilisateur (nom, email, motDePasse , role,image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(1, $name, PDO::PARAM_STR);
        $stmt->bindValue(2, $email, PDO::PARAM_STR);
        $stmt->bindValue(3, password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $stmt->bindValue(4, $role, PDO::PARAM_STR);
        $stmt->bindValue(5, $defaultImage, PDO::PARAM_STR); 

        return $stmt->execute();
    }

    }
    

    

    

  
    

    


?>