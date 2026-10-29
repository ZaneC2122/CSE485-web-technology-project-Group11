<?php
class UserService
{
    public function loginUser($email, $password)
    {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();
        $stmt = $conn->prepare(
            'SELECT id_user, ho_ten, email, mat_khau FROM users WHERE email = ? LIMIT 1'
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        $storedPassword = (string) $user['mat_khau'];
        $passwordInfo = password_get_info($storedPassword);
        $isHashed = !empty($passwordInfo['algo']);
        $isValid = $isHashed
            ? password_verify($password, $storedPassword)
            // Tương thích tài khoản cũ chưa được chuyển sang password hash.
            : hash_equals($storedPassword, $password);

        if (!$isValid) {
            return false;
        }

        if (!$isHashed || password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
            $update = $conn->prepare('UPDATE users SET mat_khau = ? WHERE id_user = ?');
            $update->execute([password_hash($password, PASSWORD_DEFAULT), $user['id_user']]);
        }

        unset($user['mat_khau']);
        return $user;
    }
}
