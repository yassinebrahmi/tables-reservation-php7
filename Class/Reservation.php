<?php
include 'DataBase.php';
class Reservation
{
    private $id;
    private $table_id;
    private $name;
    private $phone;
    private $many_people;
    private $day;
    private $time;
    private $special_request;
    private $created_by;
    private $status = array('Accept', 'Refuse', 'Waiting');
    private $created_at;

    public function __construct() 
    {
    }
    public function create($fields = array())
    {
        try {

            //write query
            $query = "INSERT INTO reservations(table_id,name,phone,many_people,day,time,special_request,created_by,status) VALUES (:table_id,:name,:phone,:many_people,:day,:time,:special_request,:created_by,:status)";
            $stmt = DataBase::getConnection()->prepare($query);
            // posted values
            $this->table_id = htmlspecialchars(strip_tags($fields['table_id']));
            $this->name = htmlspecialchars(strip_tags($fields['name']));
            $this->phone = htmlspecialchars(strip_tags($fields['phone']));
            $this->many_people = htmlspecialchars(strip_tags($fields['many_people']));
            $this->day = htmlspecialchars(strip_tags($fields['day']));
            $this->time = htmlspecialchars(strip_tags($fields['time']));
            $this->special_request = htmlspecialchars(strip_tags($fields['special_request']));
            $this->created_by = htmlspecialchars(strip_tags($_SESSION['user']['id']));
            $this->status = "Waiting";
            // bind values
            $stmt->bindParam(":table_id", $this->table_id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":many_people", $this->many_people);
            $stmt->bindParam(":day", $this->day);
            $stmt->bindParam(":time", $this->time);
            $stmt->bindParam(":special_request", $this->special_request);
            $stmt->bindParam(":created_by", $this->created_by);
            $stmt->bindParam(":status", $this->status);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function readAllNotification($search = "", $length = 5, $start = 1, $draw = 0, $order = "")
    {
        $output = array();
        $sql = "SELECT a.id,a.table_id,concat(b.placement,b.id,'-',c.desc) as tablebook,a.name,a.phone,a.many_people,a.day,a.time,a.special_request,a.status,a.created_at,a.created_by FROM reservations a,tables b,categories c WHERE (a.table_id=b.id) AND (b.category_id=c.id) AND (a.status='Waiting') ";
        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $total_all_rows = $q->rowCount();

        if (isset($search) and $search != "") {
            $sql .= " AND  ( b.placement   like '%" . $search . "%'";
            $sql .= " OR c.desc like '%" . $search . "%'";
            $sql .= " OR a.name like '%" . $search . "%'";
            $sql .= " OR a.phone like '%" . $search . "%'";
            $sql .= " OR a.many_people LIKE  '%" . $search . "%'";
            $sql .= " OR a.time Like  '%" . $search . "%'";
            $sql .= " OR a.day LIKE  '%" . $search . "%')";
        }


        if ($order != "") {

            $sql .= " ORDER BY " . $order[0]['column'] . " " . $order[0]['dir'] . " ";
        } else {
            $sql .= " ORDER BY created_at desc";
        }

        if (isset($length) and $length != -1) {
            $sql .= " LIMIT  " . $start . ", " . $length;
        }

        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $count_rows = $q->rowCount();

        $data = array();

        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $sub_array = array();

            $sub_array['id'] = $row["id"];
            $sub_array['table_id'] = $row["table_id"];
            $sub_array['tablebook'] = $row["tablebook"];
            $sub_array['name'] = $row["name"];
            $sub_array['phone'] = $row["phone"];
            $sub_array['many_people'] = $row["many_people"];
            $sub_array['day'] = $row["day"];
            $sub_array['time'] = $row["time"];
            $sub_array['special_request'] = $row["special_request"];
            $sub_array['status'] = $row["status"];
            $sub_array['created_by'] = $this->findUser($row['created_by'])['name'];
            $sub_array['created_at'] = $row["created_at"];
            $sub_array['actions'] = '<a class="btn btn-outline-info btn-sm" href="#" >View</a>';
            $data[] = $sub_array;
        }


        $output = array(
            'draw' =>  intval($draw),
            'recordsTotal' => $count_rows,
            'recordsFiltered' =>   $total_all_rows,
            'data' => $data
        );
        echo  json_encode($output);
    }
    public function readAllNotificationByEmploy($search = "", $length = 5, $start = 1, $draw = 0, $order = "")
    {
        $output = array();
        $sql = "SELECT a.id,a.table_id,concat(b.placement,b.id,'-',c.desc) as tablebook,a.name,a.phone,a.many_people,a.day,a.time,a.special_request,a.status,a.created_at,a.created_by FROM reservations a,tables b,categories c WHERE (a.table_id=b.id) AND (b.category_id=c.id) AND (a.status='Waiting') AND (a.created_by=" . $_SESSION['user']['id'] . " )";
        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $total_all_rows = $q->rowCount();

        if (isset($search) and $search != "") {
            $sql .= " AND  ( b.placement   like '%" . $search . "%'";
            $sql .= " OR c.desc like '%" . $search . "%'";
            $sql .= " OR a.name like '%" . $search . "%'";
            $sql .= " OR a.phone like '%" . $search . "%'";
            $sql .= " OR a.many_people LIKE  '%" . $search . "%'";
            $sql .= " OR a.time Like  '%" . $search . "%'";
            $sql .= " OR a.day LIKE  '%" . $search . "%')";
        }


        if ($order != "") {

            $sql .= " ORDER BY " . $order[0]['column'] . " " . $order[0]['dir'] . " ";
        } else {
            $sql .= " ORDER BY created_at desc";
        }

        if (isset($length) and $length != -1) {
            $sql .= " LIMIT  " . $start . ", " . $length;
        }

        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $count_rows = $q->rowCount();

        $data = array();

        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $sub_array = array();

            $sub_array['id'] = $row["id"];
            $sub_array['table_id'] = $row["table_id"];
            $sub_array['tablebook'] = $row["tablebook"];
            $sub_array['name'] = $row["name"];
            $sub_array['phone'] = $row["phone"];
            $sub_array['many_people'] = $row["many_people"];
            $sub_array['day'] = $row["day"];
            $sub_array['time'] = $row["time"];
            $sub_array['special_request'] = $row["special_request"];
            $sub_array['status'] = $row["status"];
            $sub_array['created_by'] = $this->findUser($row['created_by'])['name'];
            $sub_array['created_at'] = $row["created_at"];
            $sub_array['actions'] = '<a class="btn btn-outline-primary btn-sm mr-2" href="#" onclick="EditNotify(' . $row['id'] . ')">Edit</a><a class="btn btn-outline-danger btn-sm" href="#" onclick="DelNotify(' . $row['id'] . ')">Del</a>';
            $data[] = $sub_array;
        }


        $output = array(
            'draw' =>  intval($draw),
            'recordsTotal' => $count_rows,
            'recordsFiltered' =>   $total_all_rows,
            'data' => $data
        );
        echo  json_encode($output);
    }
    public function readAllReservation($search = "", $length = 5, $start = 1, $draw = 0, $order = "")
    {
        $output = array();
        $sql = "SELECT a.id,a.table_id,concat(b.placement,b.id,'-',c.desc) as tablebook,a.name,a.phone,a.many_people,a.day,a.time,a.special_request,a.created_at,a.created_by,a.status FROM reservations a,tables b,categories c WHERE (a.table_id=b.id) AND (b.category_id=c.id) AND (a.status in ('Accept','Refuse'))";
        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $total_all_rows = $q->rowCount();

        if (isset($search) and $search != "") {
            $sql .= " AND  ( b.placement   like '%" . $search . "%'";
            $sql .= " OR c.desc like '%" . $search . "%'";
            $sql .= " OR a.name like '%" . $search . "%'";
            $sql .= " OR a.phone like '%" . $search . "%'";
            $sql .= " OR a.many_people LIKE  '%" . $search . "%'";
            $sql .= " OR a.time Like  '%" . $search . "%'";
            $sql .= " OR a.day LIKE  '%" . $search . "%')";
        }


        if ($order != "") {

            $sql .= " ORDER BY " . $order[0]['column'] . " " . $order[0]['dir'] . " ";
        } else {
            $sql .= " ORDER BY created_at desc";
        }

        if (isset($length) and $length != -1) {
            $sql .= " LIMIT  " . $start . ", " . $length;
        }

        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $count_rows = $q->rowCount();

        $data = array();

        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $sub_array = array();

            $sub_array['id'] = $row["id"];
            $sub_array['table_id'] = $row["table_id"];
            $sub_array['tablebook'] = $row["tablebook"];
            $sub_array['name'] = $row["name"];
            $sub_array['phone'] = $row["phone"];
            $sub_array['many_people'] = $row["many_people"];
            $sub_array['day'] = $row["day"];
            $sub_array['time'] = $row["time"];
            $sub_array['special_request'] = $row["special_request"];
            $sub_array['status'] = $row["status"];
            $sub_array['created_by'] = $this->findUser($row['created_by'])['name'];
            $sub_array['created_at'] = $row["created_at"];
            $sub_array['actions'] = '<a class="btn btn-outline-primary btn-sm mr-2" href="#" onclick="EditBook(' . $row['id'] . ')">Edit</a><a class="btn btn-outline-danger btn-sm" href="#" onclick="DelBook(' . $row['id'] . ')">Del</a>';
            $data[] = $sub_array;
        }


        $output = array(
            'draw' =>  intval($draw),
            'recordsTotal' => $count_rows,
            'recordsFiltered' =>   $total_all_rows,
            'data' => $data
        );
        echo  json_encode($output);
    }
    public function readReservationByEmploy($search = "", $length = 5, $start = 1, $draw = 0, $order = "")
    {
        $output = array();
        $sql = "SELECT a.id,a.table_id,concat(b.placement,b.id,'-',c.desc) as tablebook,a.name,a.phone,a.many_people,a.day,a.time,a.special_request,a.created_at,a.created_by,a.status FROM reservations a,tables b,categories c WHERE (a.table_id=b.id) AND (b.category_id=c.id) AND (a.status in ('Accept','Refuse')) AND (a.created_by=" . $_SESSION['user']['id'] . " ) ";
        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $total_all_rows = $q->rowCount();

        if (isset($search) and $search != "") {
            $sql .= " AND  ( b.placement   like '%" . $search . "%'";
            $sql .= " OR c.desc like '%" . $search . "%'";
            $sql .= " OR a.name like '%" . $search . "%'";
            $sql .= " OR a.phone like '%" . $search . "%'";
            $sql .= " OR a.many_people LIKE  '%" . $search . "%'";
            $sql .= " OR a.time Like  '%" . $search . "%'";
            $sql .= " OR a.day LIKE  '%" . $search . "%')";
        }

        if ($order != "") {

            $sql .= " ORDER BY " . $order[0]['column'] . " " . $order[0]['dir'] . " ";
        } else {
            $sql .= " ORDER BY created_at desc";
        }


        if (isset($length) and $length != -1) {
            $sql .= " LIMIT  " . $start . ", " . $length;
        }

        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $count_rows = $q->rowCount();

        $data = array();

        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $sub_array = array();

            $sub_array['id'] = $row["id"];
            $sub_array['table_id'] = $row["table_id"];
            $sub_array['tablebook'] = $row["tablebook"];
            $sub_array['name'] = $row["name"];
            $sub_array['phone'] = $row["phone"];
            $sub_array['many_people'] = $row["many_people"];
            $sub_array['day'] = $row["day"];
            $sub_array['time'] = $row["time"];
            $sub_array['special_request'] = $row["special_request"];
            $sub_array['status'] = $row["status"];
            $sub_array['created_by'] = $this->findUser($row['created_by'])['name'];
            $sub_array['created_at'] = $row["created_at"];
            $sub_array['actions'] = '<a class="btn btn-outline-primary btn-sm mr-2" href="#" onclick="EditBook(' . $row['id'] . ')">Edit</a>';
            $data[] = $sub_array;
        }


        $output = array(
            'draw' =>  intval($draw),
            'recordsTotal' => $count_rows,
            'recordsFiltered' =>   $total_all_rows,
            'data' => $data
        );
        echo  json_encode($output);
    }
    public function CheckTableIsAvailable($table_id, $day, $time, $book_id = "")
    {
        $time_start = $time;
        $time_end = date("H:i", strtotime($time) + 3600);

        if ($book_id != "")
            $update = " AND id<>" . intval($book_id) . "";
        else
            $update = "";


        $stmt = DataBase::getConnection()->prepare("SELECT * FROM reservations WHERE table_id=:table_id AND day=:day AND hour(time) between  '" . $time_start . "' AND '" . $time_end . "' AND ( status in ('Accept','Waiting') ) " . $update);

        $stmt->bindparam(":table_id", $table_id);
        $stmt->bindparam(":day", $day);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
            return true;
        else
            return false;
    }
    public function countAll()
    {

        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    public function update($fields = array())
    {
        try {

            //write query
            $query = "UPDATE reservations SET  name=:name,phone=:phone,many_people=:many_people,day=:day,time=:time,special_request=:special_request,created_by=:created_by,status=:status WHERE id=:book_id";
            $stmt = DataBase::getConnection()->prepare($query);
            // posted values
            $this->id = htmlspecialchars(strip_tags($fields['book_id']));
            $this->name = htmlspecialchars(strip_tags($fields['name']));
            $this->phone = htmlspecialchars(strip_tags($fields['phone']));
            $this->many_people = htmlspecialchars(strip_tags($fields['many_people']));
            $this->day = htmlspecialchars(strip_tags($fields['day']));
            $this->time = htmlspecialchars(strip_tags($fields['time']));
            $this->special_request = htmlspecialchars(strip_tags($fields['special_request']));
            $this->status = 'Waiting';
            $this->created_by = htmlspecialchars(strip_tags($_SESSION['user']['id']));
            // bind values
            $stmt->bindParam(":book_id", $this->id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":many_people", $this->many_people);
            $stmt->bindParam(":day", $this->day);
            $stmt->bindParam(":time", $this->time);
            $stmt->bindParam(":special_request", $this->special_request);
            $stmt->bindParam(":created_by", $this->created_by);
            $stmt->bindParam(":status", $this->status);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function accept($book_id)
    {
        try {

            //write query
            $query = "UPDATE reservations SET  status='Accept' WHERE id=:book_id";
            $stmt = DataBase::getConnection()->prepare($query);
            // posted values
            $this->id = htmlspecialchars(strip_tags($book_id));
            // bind values
            $stmt->bindParam(":book_id", $this->id);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function refuse($book_id)
    {
        try {

            //write query
            $query = "UPDATE reservations SET  status='Refuse' WHERE id=:book_id";
            $stmt = DataBase::getConnection()->prepare($query);
            // posted values
            $this->id = htmlspecialchars(strip_tags($book_id));
            // bind values
            $stmt->bindParam(":book_id", $this->id);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function delete($table_id)
    {
        try {
            //write query
            $query = "DELETE FROM reservations WHERE id=:book_id";
            $stmt = DataBase::getConnection()->prepare($query);
            // posted values
            $this->id = htmlspecialchars(strip_tags($table_id));
            // bind values
            $stmt->bindParam(":book_id", $this->id);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function readTables()
    {
        try {
            $stmt = DataBase::getConnection()->prepare("SELECT a.id,concat(a.placement,a.id,'-',b.desc) as tablebook FROM tables a,categories b WHERE a.category_id=b.id");
            $stmt->execute();
            return  $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public function findBook($id)
    {
        $stmt = DataBase::getConnection()->prepare("SELECT reservations.*,users.name FROM reservations,users WHERE reservations.created_by=users.id AND  reservations.id=:id");
        $stmt->execute(array(":id" => $id));
        $editRow = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($editRow);
    }
    public function findUser($id)
    {
        $stmt = DataBase::getConnection()->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(array(":id" => $id));
        $editRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }
}
