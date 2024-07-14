<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\FriendModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $userModel = new UserModel();
        $friendModel = new FriendModel();

        $user = session()->get('user');
        $userId = $user['id']; 

        // Get all users except the logged-in user
        $query = "SELECT * 
        FROM users 
        WHERE id != ?";

// Execute the query
$users = $userModel->query($query, [$userId])->getResult();




        // echo  $lastQuery = $db->getLastQuery(); exit;


        // Get accepted friends
        $friends = $friendModel->select('friends.*, users.name as name')
        ->join('users', 'users.id = friends.user_id')
        ->where('friends.friend_id', $userId)
        ->where('friends.status', 'accepted')
        ->findAll();

        // Get pending friend requests
        $pendingRequests = $friendModel->select('friends.*, users.name as name')
        ->join('users', 'users.id = friends.user_id')
        ->where('friends.friend_id', $userId)
        ->where('friends.status', 'pending')
        ->findAll();
// echo"<pre>";
//                                                print_r($data['pendingRequests']);
//                                                exit;

// $filteredUsers = [];

// foreach ($users as $user) {
//     $isFriend = false;
    
//     // Check if user is already a friend
//     foreach ($friends as $friend) {
//         if ($user['id'] == $friend['friend_id']) { 

          
//             $isFriend = true;
//             break;
//         }
//     }

//     // Check if user has a pending friend request
//     if (!$isFriend) {
//         foreach ($pendingRequests as $request) {
//             if ($user['id'] == $request['friend_id'] && $request['status'] == 'pending') {
//                 $isFriend = true;
//                 break;
//             }
//         }
//     }

//     if (!$isFriend) {
//         $filteredUsers[] = $user;
//     }
// }

// echo "<pre>";

// print_r($filteredUsers);
// exit;


// Pass data to view
$data = [
    'filteredUsers' => $users,
    'friends' => $friends,
    'pendingRequests' => $pendingRequests,
    // Other data you may need to pass to the view
];


        return view('dashboard', $data);
    }

    public function sendRequest($friendId)
    {
        $friendModel = new FriendModel();

        $userModel = new UserModel();

        $user = session()->get('user');
     $userId = $user['id']; 

        $data = [
            'user_id' => $userId,
            'friend_id' => $friendId,
            'status' => 'pending'
        ];

        $user_data = [
            'user_status' => 1
        ];

    
     //   $userModel = new \App\Models\UserModel();
       // $userId = 1; // Assuming you have the user ID
        
        

        $friendModel->save($data);

        // $friendModel->update($uid,  $user_data);

         // Using the query builder
         $db = \Config\Database::connect();
         $builder = $db->table('users'); // Assuming your table name is 'users'
 
         $builder->where('id', $friendId);
         if ($builder->update($user_data)) {
             echo "User status updated successfully using query builder.";
         } else {
             echo "Failed to update user status using query builder.";
         }

        return redirect()->to('/dashboard');
    }

    public function acceptRequest($requestId)
    {
        $friendModel = new FriendModel();
        $friendModel->update($requestId, ['status' => 'accepted']);

        return redirect()->to('/dashboard');
    }

    public function addFriend($friendId)
    {
        $friendModel = new FriendModel();
        $friendModel->save([
            'user_id' => session()->get('user')['id'],
            'friend_id' => $friendId,
        ]);

        return redirect()->to('/dashboard');
    }

    public function friends()
    {
        $user = session()->get('user');
        $userId = $user['id']; 

        
        $friendModel = new FriendModel();
        $friends = $friendModel->getFriends($userId);


        return view('friends', ['friends' => $friends]);
    }

    public function profile()
    {
        return view('profile', ['user' => session()->get('user')]);
    }

    public function updateProfile()
    {

        // echo"test"; exit;
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'profile_pic' => 'uploaded[profile_pic]|max_size[profile_pic,1024]|is_image[profile_pic]',
            'gender' => 'required|in_list[male,female,other]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $file = $this->request->getFile('profile_pic');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
        }

        $userModel->update(session()->get('user')['id'], [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'profile_pic' => $newName,
            'gender' => $this->request->getPost('gender'),
        ]);

        session()->set('user', $userModel->find(session()->get('user')['id']));

        return redirect()->to('/profile')->with('message', 'Profile updated successfully');
    }
}
