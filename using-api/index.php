<?php 
session_start();

class ApiClient {
    private $apiUrl = "http://localhost/myapi/api/users.php";
    private $apiKey = "12345";

    // Setup cURL
    private function setupCurl($url, $method, $data = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        
        $headers = [
            "API-Key: " . $this->apiKey,
            "Content-Type: application/json"
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        return $curl;
    }
    
    // Get all users function
    public function getAllUsers() {
        $curl = $this->setupCurl($this->apiUrl, "GET");
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        return $error ? ["error" => $error] : json_decode($response, true);
    }

    // Get select user function
    public function getUser($id) {
        $url = $this->apiUrl . "?id=" . intval($id);
        $curl = $this->setupCurl($url, "GET");
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        return $error ? ["error" => $error] : json_decode($response, true);
    }

    // Add user function
    public function addUser($name, $email) {
        $data = ["name" => $name, "email" => $email];
        $curl = $this->setupCurl($this->apiUrl, "POST", $data);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        return $error ? ["error" => $error] : json_decode($response, true);
    }

    // Update user function
    public function updateUser($id, $name, $email) {
        $url = $this->apiUrl . "?id=" . intval($id);
        $data = ["name" => $name, "email" => $email];
        $curl = $this->setupCurl($url, "PUT", $data);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        return $error ? ["error" => $error] : json_decode($response, true);
    }

    // Delete user function
    public function deleteUser($id) {
        $url = $this->apiUrl . "?id=" . intval($id);
        $curl = $this->setupCurl($url, "DELETE");
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        return $error ? ["error" => $error] : json_decode($response, true);
    }
}

// Create Object
$client = new ApiClient();

// Get users
if(isset($_POST['getUser'])){
    $id = $_POST['id'];
    $getUser = $client->getUser($id);
    $getAllUsers = [$getUser];
    $back = true;

    // if No user found
    if(isset($getUser['error'])){
        $_SESSION['e_get_user'] = $getUser['error'];
        header("Location:". $_SERVER['PHP_SELF']);
        exit();
    }
}else{
    $getAllUsers = $client->getAllUsers();
}

// add user
if (isset($_POST['addUser'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $addUser = $client->addUser($name, $email);

    if (isset($addUser['error'])) {
        $_SESSION['e_add_user'] = $addUser['error'];
        header("Location:". $_SERVER['PHP_SELF']);
        exit();
    } else if (isset($addUser['success'])) {
        $_SESSION['add_user'] = $addUser['success'];
        header("Location:". $_SERVER['PHP_SELF']);
        exit();
    }
}

// Update user
if (isset($_POST['updUser'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $updateUser = $client->updateUser($id, $name, $email);

    if (isset($updateUser['error'])) {
        $_SESSION['e_update_user'] = $updateUser['error'];
        header("Location:". $_SERVER['PHP_SELF']);
        exit();
    } else if (isset($updateUser['success'])) {
        $_SESSION['update_user'] = $updateUser['success'];
        header("Location:". $_SERVER['PHP_SELF']);
        exit();
    }
}

//delete user
if(isset($_GET['du'])){
    $deleteUser = $client->deleteUser($_GET['du']);

    if($deleteUser['error']){
        $_SESSION['e_delete_user'] = $deleteUser['error'];

    }else if ($deleteUser['success']){
        $_SESSION['delete_user'] = $deleteUser['success'];
        header("Location:". $_SERVER['PHP_SELF']);
        exit;

    }
}

include_once 'user-management.php';
