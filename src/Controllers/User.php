<?php

namespace Controllers;

use BusinessLogic\AuthentificationManager;
use BusinessLogic\RegistrationManager;
use BusinessLogic\CommentManager;

class User extends \MVC\Controller {

    const PARAM_USERNAME = 'un';
    const PARAM_PASSWORD = 'pwd';
    const PARAM_CONFIRMED_PASSWORD = 'confirmedPwd';

    public function GET_Login() {
        return $this->renderView('login', array(
                    'currUser' => AuthentificationManager::getAuthenticatedUser(),
                    'newestComment' => CommentManager::getNewestComment(),
                    'username' => $this->getParam(self::PARAM_USERNAME)
        ));
    }

    public function GET_Logout() {
        AuthentificationManager::signOut();
        return $this->redirect('Index', 'Discussion');
    }

    public function POST_Login() {
        if (!AuthentificationManager::authenticate($this->getParam(self::PARAM_USERNAME), $this->getParam(self::PARAM_PASSWORD))) {
            return $this->renderView('login', array(
                        'currUser' => AuthentificationManager::getAuthenticatedUser(),
                        'newestComment' => CommentManager::getNewestComment(),
                        'username' => $this->getParam(self::PARAM_USERNAME),
                        'errors' => array('Invalid username or password.')
            ));
        }

        return $this->redirect('Index', 'Discussion');
    }

    public function GET_Register() {
        return $this->renderView('register', array(
                    'currUser' => AuthentificationManager::getAuthenticatedUser(),
                    'newestComment' => CommentManager::getNewestComment(),
                    'username' => $this->getParam(self::PARAM_USERNAME)
        ));
    }

    private function checkRegisterParams($username, $password, $confirmedPassword) {
        $errors = array();

        if ($username === null || strlen($username) === 0) {
            $errors[] = "Username is required.";
        }

        if ($confirmedPassword === null || strlen($password) === 0) {
            $errors[] = "Password is required.";
        }

        if (RegistrationManager::userExists($username)) {
            $errors[] = "User with name '" . $username . "' already exists.";
        }

        if ($password !== $confirmedPassword) {
            $errors[] = "Passwords don't match.";
        }

        return $errors;
    }

    public function POST_Register() {
        $username = $this->getParam(self::PARAM_USERNAME);
        $password = $this->getParam(self::PARAM_PASSWORD);
        $confirmedPassword = $this->getParam(self::PARAM_CONFIRMED_PASSWORD);

        $errors = $this->checkRegisterParams($username, $password, $confirmedPassword);

        if (sizeof($errors) === 0) {
            if (RegistrationManager::registerUser($username, $password)) {
                return $this->redirect('Index', 'Discussion');
            }
            $errors[] = 'Something went wrong.';
        }

        return $this->renderView('register', array(
                    'currUser' => AuthentificationManager::getAuthenticatedUser(),
                    'newestComment' => CommentManager::getNewestComment(),
                    'username' => $username,
                    'errors' => $errors
        ));
    }

}
