<?php
class UserService
{
    public function registerUser($name, $email, $password)
    {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();
        $stmt = $conn->prepare(
            'INSERT INTO users (ho_ten, email, mat_khau) VALUES (?, ?, ?)'
        );
        $stmt->execute([$name, $email, $password]);

        return [
            'id_user' => $conn->lastInsertId(),
            'ho_ten' => $name,
            'email' => $email,
        ];
    }

    
    public function loginUser($email, $password)
    {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();
        $stmt = $conn->prepare(
            'SELECT id_user, ho_ten, email, mat_khau FROM users WHERE email = ? LIMIT 1'
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || $password !== $user['mat_khau']) {
            return false;
        }

        unset($user['mat_khau']);
        return $user;
    }

}
