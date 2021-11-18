<?php

namespace App\Model;
/*namespace App\Presenters;*/

use Nette;


/**
 * Users management.
 */
class UserManager
{
	const
		TABLE_NAME = 'users',
		COLUMN_ID = 'user_id',
		COLUMN_NAME = 'user_name',
		COLUMN_EMAIL = 'email',
		COLUMN_TYPE = 'type';


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
           
            $params = array(               
                'user_name' => $values->username,
                'email' => $values->email,
                'type' => $values->type,
            ) ;
            
            $this->database->query('INSERT INTO users', [$params]);
            
        }
        
        
    public function editUser($values){    
        $this->database->query('UPDATE `users` SET', [
            'user_name' => $values->username,
            'type' => $values->type,
        ], 'WHERE email = ?', $values->user_email); 
    }
        
    public function deleteUser($user_email)
    {       
        $this->database->query('DELETE FROM `users` WHERE email = ?', $user_email);
    }
    
    
    public function getUserbyEmail($user_email)
    {
        return $result = $this->database->fetchAll('SELECT * FROM `users` WHERE `email` = ? ', $user_email);
    }
}


