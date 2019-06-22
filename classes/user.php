<?php

session_start();

class user
{
    protected $db;

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function __get($name)
    {
        return $_SESSION[$name] ?? null;
    }

    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }

    public function __construct()
    {
        $this->db = sql::getInstance();
        $this->init();
    }

    public function isUser()
    {
        return isset($this->user_id);
    }

    public function init()
    {
        if (!isset($this->user_id)) {
            if (isset($_COOKIE['token'])) {
                $user = $this->db->select('users', '*', ['token' => $_COOKIE['token']]);
                if (count($user) > 0) {
                    $user = reset($user);
                    $this->user_id = $user['user_id'];
                    $this->email = $user['email'];
                    $this->nickname = $user['nickname'];
                    setcookie('token', $_COOKIE['token'], time() + 24 * 60 * 60 * 365, '/');
                }
            }
        }
    }

    public function reg($userData)
    {
        $user = $this->db->select('users', '*', ['email' => $userData['email']]);
        if (count($user) > 0) {
            throw new Exception('Email has been used');
        }
        $userData['salt'] = mt_rand();
        $userData['password'] = md5($userData['password'] . $userData['salt']);
        $userData['status'] = 1;
        $userData['account_token'] = md5(time() . mt_rand());
        $this->db->insert('users', $userData);
        return $userData['account_token'];
    }

    public function login($userData)
    {
        $user = $this->db->select('users', '*', ['email' => $userData['email']]);

        print_r($user);
        print_r($userData);
        if (count($user) == 0) {
            throw new Exception('You need to registrate');
        }
        $user = reset($user);
        $passwordHash = md5($userData['password'] . $user['salt']);
        if ($passwordHash != $user['password']) {
            throw new Exception('Wrong Password');
        }
        if ($user['status'] == 1) {
            if ($userData['account_token'] != $user['account_token']) {
                throw new Exception('Wrong confirmation link!');
            } else {
                $this->db->update('users', ['account_token' => '', 'status' => 0], ['user_id' => $user['user_id']]);
            }
        }

        $token = md5(time() . mt_rand());
        $this->db->update('users', ['token' => $token], ['user_id' => $user['user_id']]);

        setcookie('token', $token, time() + 24 * 60 * 60 * 365, '/');
        $this->user_id = $user['user_id'];
        $this->email = $user['email'];
        $this->nickname = $user['nickname'];
    }

    public function userCheck($account_token)
    {
        $user = $this->db->select('users', '*', ['account_token' => $account_token]);
        $user = reset($user);
        if (count($user) == 0) {
            throw new Exception('Wrong confirmation link');
        } else {
            $this->db->update('users', ['account_token' => '', 'status' => 0], ['user_id' => $user['user_id']]);
        }
    }

    public function logout()
    {
        $_SESSION = [];
        setcookie('token', '', time() + 1);
        header('location: ?page=main&action=index');
    }
}
