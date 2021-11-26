<?php

namespace App\Model;

use Nette;


/**
 * Users management.
 */
class UserManager
{
	const
		TABLE_NAME = 'users',
		COLUMN_NAME = 'username';


	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

    /**
     * Vypis vsech uzivatelu
     * 
     */
    public function getUsers()
        {
            return $this->database->table(self::TABLE_NAME)
                ->order(self::COLUMN_NAME.' ASC ');
        }
    
    public function insertNewUser($values){
           
            $params = [               
                'username' => $values->username,
                'email' => $values->email,
                'type' => $values->type,
            ] ;
            
            $this->database->query('INSERT INTO users', [$params]);
            
        }
        
        
    public function editUser($values){    
        $this->database->query('UPDATE `users` SET', [
            'username' => $values->username,
            'type' => $values->type,
        ], 'WHERE email = ?', $values->email); 
    }
        
    public function deleteUser($userEmail)
    {       
        $this->database->query('DELETE FROM `users` WHERE email = ?', $userEmail);
    }
    
    
    public function getUserbyEmail($userEmail)
    {
        return $result = $this->database->fetchAll('SELECT * FROM `users` WHERE `email` = ? ', $userEmail);
    }
}


