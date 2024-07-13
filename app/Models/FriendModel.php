<?php
namespace App\Models;

use CodeIgniter\Model;

class FriendModel extends Model
{
    protected $table = 'friends';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'friend_id', 'status'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


}
