<?php

include 'DataBase.php';

class User
{


    public function __construct($user = null) {
    }


    public function readAllJson($search="",$length=5,$start=1,$draw=0,$order="")
    {
        $output= array();
        $sql = "SELECT *  FROM users WHERE 1=1 ";
        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $total_all_rows= $q->rowCount();

        if(isset($search) and $search!="")
        {
            $sql .= " AND  ( username like '%".$search."%'";
            $sql .= " OR name like '%".$search."%'";
            $sql .= " OR profil like  '%".$search."%' )";
        }


        if($order!="")
        {

            $sql .= " ORDER BY ".$order[0]['column']." ".$order[0]['dir']." ";
        }
        else
        {
            $sql .= " ORDER BY created_at desc";
        }

        if(isset($length) and $length != -1)
        {
            $sql .= " LIMIT  ".$start.", ".$length;
        }

        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $count_rows =$q->rowCount();

        $data = array();

        while($row = $q->fetch(PDO::FETCH_ASSOC)){
            $sub_array = array();
            $sub_array['id'] = $row["id"];
            $sub_array['name'] = $row["name"];
            $sub_array['username'] = $row["username"];
            $sub_array['profil'] = $row["profil"];
            $sub_array['password'] = $this->decryptPass($row["password"]);
            $sub_array['created_by'] = $this->findUser($row['created_by'])['name'];
            $sub_array['created_at'] = $row["created_at"];
            $sub_array['actions'] ='<a class="btn btn-outline-primary btn-sm mr-2" onclick="EditUser('.$row['id'].')">Edit</a><a class="btn btn-outline-danger btn-sm" href="#" onclick="DelUser('.$row['id'].')">Del</a>';
            $data[] = $sub_array;
        }
        $output = array(
            'draw'=>  intval($draw),
            'recordsTotal' =>$count_rows ,
            'recordsFiltered'=>   $total_all_rows,
            'data'=>$data,
        );
        echo  json_encode($output);

    }
    public function create($fields = array()) {
        try
        {
            $pass= $this->encryptPass($fields['password']);

            $stmt = DataBase::getConnection()->prepare("INSERT INTO users (username,password,name,profil,created_by) VALUES(:username, :password, :name,:profil,:created_by)");
            $stmt->bindparam(":name",$fields['name']);
            $stmt->bindparam(":username",$fields['username']);
            $stmt->bindparam(":password",$pass);
            $stmt->bindparam(":profil",$fields['profil']);
            $stmt->bindparam(":created_by",$fields['created_by']);
            if($stmt->execute())
            return true;
            else
                return true;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }

    }
    public function update($fields = array()) {
        try
        {
            $pass= $this->encryptPass($fields['password']);
            $stmt = DataBase::getConnection()->prepare("UPDATE users SET username=:username,name=:name,profil=:profil,password=:password,created_by=:created_by WHERE id=:id");
            $stmt->bindparam(":id",$fields['id']);
            $stmt->bindparam(":username",$fields['username']);
            $stmt->bindparam(":name",$fields['name']);
            $stmt->bindparam(":profil",$fields['profil']);
            $stmt->bindparam(":password",$pass);
            $stmt->bindparam(":created_by",$fields['created_by']);

            if($stmt->execute())
            return true;
            else
                return false;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }

    }
    public function delete($id) {
        try
        {
            $stmt = database::getConnection()->prepare("DELETE FROM users WHERE id=:id");
            $stmt->bindparam(":id",$id);
            if($stmt->execute())
            return true;
            else
                return false;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }

    }
    public function findUser($id)
    {
        $stmt = DataBase::getConnection()->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }
    public function findUserJson($id)
    {
        $stmt = DataBase::getConnection()->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(array(":id"=>$id));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $sub_array=array();
        $sub_array['id'] = $row["id"];
        $sub_array['name'] = $row["name"];
        $sub_array['username'] = $row["username"];
        $sub_array['profil'] = $row["profil"];
        $sub_array['password'] = $this->decryptPass($row["password"]);
        $sub_array['created_at'] = $row["created_at"];
        echo json_encode($sub_array);
    }
    public function existUser($email)
    {
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindparam(":email",$email);
        $stmt->execute();
        $row_count = $stmt->rowCount();
        if($row_count ==1)
            return true;
        else
            return false;
    }
    public function login($username = null, $password = null) {

        try {
            $pass = $this->encryptPass($password);

            //Check Mail :
            $q = DataBase::getConnection()->prepare('SELECT * FROM users WHERE username=:username');
            $q->bindParam(':username', $username);
            $q->execute();
            $row_count = $q->rowCount();

            if ($row_count == 0)
                return json_encode(["status" => "failure", "message" => "Your username address is incorrect"]);
            else {
                //Check Password :
                $q = DataBase::getConnection()->prepare('SELECT * FROM users WHERE username=:username and password=:password');
                $q->bindParam(':username', $username);
                $q->bindParam(':password', $pass);
                $q->execute();
                $row_count = $q->rowCount();
                if ($row_count == 0)
                    return json_encode(["status" => "failure", "message" => "Your Password is incorrect"]);
                else {
                    $q = DataBase::getConnection()->prepare('SELECT * FROM users WHERE username=:username AND password=:password');
                    $q->bindParam(':username', $username);
                    $q->bindParam(':password', $pass);
                    $q->execute();
                    $row = $q->fetch(PDO::FETCH_ASSOC);
                    session_status() == true ? '' : session_start();
                    $_SESSION['user'] = $row;
                    return json_encode(["status" => "success", "profil" => $row['profil']]);
                }

            }
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    }
    public function logout() {
        session_destroy();
        unset($_SESSION);
        header('Location: index.php');
    }
    public function encryptPass($password) {
        $sSalt = '20adeb83e85f03cfc84d0fb7e5f4d290';
        $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
        $method = 'aes-256-cbc';

        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

        $encrypted = base64_encode(openssl_encrypt($password, $method, $sSalt, OPENSSL_RAW_DATA, $iv));
        return $encrypted;
    }
    public function decryptPass($password) {
        $sSalt = '20adeb83e85f03cfc84d0fb7e5f4d290';
        $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
        $method = 'aes-256-cbc';

        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

        $decrypted = openssl_decrypt(base64_decode($password), $method, $sSalt, OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }
    public function updateAdminUser($fields = array()) {
        try
        {
            $pass= $this->encryptPass($fields['new_password']);
            $stmt = DataBase::getConnection()->prepare("UPDATE users SET username=:username,name=:name,password=:new_password WHERE id=:user_id");
            $stmt->bindparam(":user_id",$fields['user_id']);
            $stmt->bindparam(":name",$fields['name']);
            $stmt->bindparam(":username",$fields['username']);
            $stmt->bindparam(":new_password",$pass);
            if($stmt->execute())
            return true;
            else
                return false;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }

    }
}