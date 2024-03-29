<?php

namespace BusinessLogic;

use BusinessLogic\AuthentificationManager;

class PrivilegeManager {
    public static function isAuthenticatedUserOriginator($originator){
        return AuthentificationManager::isAuthenticated() && 
                $originator === AuthentificationManager::getAuthenticatedUser()->getUsername();
    }
    
    public static function isAuthenticatedUserAllowedToAdd(){
        return AuthentificationManager::isAuthenticated();
    }
}
