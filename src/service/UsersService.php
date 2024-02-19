<?php

namespace service;


use Exception;
use models\User;
use PDO;

require_once __DIR__ . '/../models/User.php';

class UsersService
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function authenticate($username, $password): User
    {
        $user = $this->findUserByUsername($username);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        throw new Exception('Usuario o contraseña no válidos');
    }

    public function findUserByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userRow) {
            return null;
        }
        $stmtRoles = $this->db->prepare("SELECT roles FROM user_roles WHERE user_id = :user_id");
        $stmtRoles->bindParam(':user_id', $userRow['id']);
        $stmtRoles->execute();
        $roles = $stmtRoles->fetchAll(PDO::FETCH_COLUMN);
        return new User(
            $userRow['id'],
            $userRow['username'],
            $userRow['password'],
            $userRow['nombre'],
            $userRow['apellidos'],
            $userRow['email'],
            $userRow['created_at'],
            $userRow['updated_at'],
            $userRow['is_deleted'],
            $roles
        );
    }

    public function registrarse(User $user)
    {
        $username = $user->username;
        $password = $user->password;
        $nombre = $user->nombre;
        $apellidos = $user->apellidos;
        $email = $user->email;

        $user = $this->findUserByUsername($username);
        if ($user) {
            throw new Exception('El usuario ya existe');
        }
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO usuarios (username, password, nombre, apellidos, email) VALUES (:username, :password, :nombre, :apellidos, :email)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        //Añadir el rol de usuario
        $roles = [];
        $roles[] = 'USER';
        $user = $this->findUserByUsername($username);
        $stmt = $this->db->prepare("INSERT INTO user_roles (user_id, roles) VALUES (:user_id, :roles)");
        $stmt->bindParam(':user_id', $user->id);
        $stmt->bindParam(':roles', $roles[0]);
        $stmt->execute();


    }

    public function showUserInfo($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        //roles
        $stmtRoles = $this->db->prepare("SELECT roles FROM user_roles WHERE user_id = :user_id");
        $stmtRoles->bindParam(':user_id', $userRow['id']);
        $stmtRoles->execute();
        $roles = $stmtRoles->fetchAll(PDO::FETCH_COLUMN);

        return new User(
            $userRow['id'],
            $userRow['username'],
            $userRow['password'],
            $userRow['nombre'],
            $userRow['apellidos'],
            $userRow['email'],
            $userRow['created_at'],
            $userRow['updated_at'],
            $userRow['is_deleted'],
            $roles
        );
    }

}
