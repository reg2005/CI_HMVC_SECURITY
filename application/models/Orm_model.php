<?php
/**
 * Created by PhpStorm.
 * User: evgeniy
 * Date: 26.04.16
 * Time: 20:30
 */

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Orm_model extends Eloquent{
    protected $table = 'users';

}