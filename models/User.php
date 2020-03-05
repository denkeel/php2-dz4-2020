<?php
namespace App\models;

class User extends Model
{
    public $id;
    public $login;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function insert()
    {

    }
}
