<?php
include 'DataBase.php';

class Table
{

    private $id;
    private $placement;
    private $category_id;
    private $description;
    private $guests;
    private $created_by;
    private $created_at;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getGuests()
    {
        return $this->guests;
    }

    /**
     * @param mixed $guests
     */
    public function setGuests($guests)
    {
        $this->guests = $guests;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param mixed $created_by
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }


    public function __construct()
    {
    }

    public function create($fields = array())
    {
        try {

            //write query
            $query = "INSERT INTO tables(placement,category_id,description,guests,created_by) VALUES (:placement,:category_id,:description,:guests,:created_by)";
            $stmt = DataBase::getConnection()->prepare($query);
            // posted values
            $this->placement = htmlspecialchars(strip_tags($fields['placement']));
            $this->category_id = htmlspecialchars(strip_tags($fields['category_id']));
            $this->description = htmlspecialchars(strip_tags($fields['description']));
            $this->guests = htmlspecialchars(strip_tags($fields['guests']));
            $this->created_by = htmlspecialchars(strip_tags($_SESSION['user']['id']));
            // bind values
            $stmt->bindParam(":placement", $this->placement);
            $stmt->bindParam(":category_id", $this->category_id);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":guests", $this->guests);
            $stmt->bindParam(":created_by", $this->created_by);

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
    public function readAllJson($search="",$length=5,$start=1,$draw=0,$order="")
    {
        $output= array();
        $sql = "SELECT tables.*,categories.desc,categories.ref,users.name as created_name  FROM tables,categories,users WHERE (tables.category_id=categories.id) AND (tables.created_by=users.id) ";
        $q = DataBase::getConnection()->prepare($sql);
        $q->execute();
        $total_all_rows= $q->rowCount();

        if(isset($search) and $search!="")
        {
            $sql .= " AND  ( categories.desc like '%".$search."%'";
            $sql .= " OR categories.ref like '%".$search."%'";
            $sql .= " OR tables.description like '%".$search."%'";
            $sql .= " OR tables.guests = '".$search."' )";
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
            $sub_array['category_id'] = $row["category_id"];
            $sub_array['ref'] = $row["ref"];
            $sub_array['placement'] = $row["placement"];
            $sub_array['desc'] = $row["desc"];
            $sub_array['guests'] = $row["guests"];
            $sub_array['created_at'] = $row["created_at"];
            $sub_array['description'] = $row["description"];
            $sub_array['actions'] ='<a class="btn btn-outline-primary btn-sm mr-2"  href="#" onclick="EditTable('.$row['id'].')" >Edit</a><a class="btn btn-outline-danger btn-sm" href="#" onclick="DelTable('.$row['id'].')">Del</a>';
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
    public function update($fields = array())
    {
        try {

            //write query
            $query = "UPDATE tables SET placement=:placement,category_id=:category_id,description=:description,guests=:guests,created_by=:created_by WHERE id=:table_id";
            $stmt = DataBase::getConnection()->prepare($query);
            // posted values
            $this->id = htmlspecialchars(strip_tags($fields['table_id']));
            $this->placement = htmlspecialchars(strip_tags($fields['placement']));
            $this->category_id = htmlspecialchars(strip_tags($fields['category_id']));
            $this->description = htmlspecialchars(strip_tags($fields['description']));
            $this->guests = htmlspecialchars(strip_tags($fields['guests']));
            $this->created_by = htmlspecialchars(strip_tags($_SESSION['user']['id']));
            // bind values
            $stmt->bindParam(":table_id", $this->id);
            $stmt->bindParam(":placement", $this->placement);
            $stmt->bindParam(":category_id", $this->category_id);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":guests", $this->guests);
            $stmt->bindParam(":created_by", $this->created_by);

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
            $query = "DELETE FROM tables WHERE id=:table_id";
            $stmt = DataBase::getConnection()->prepare($query);
            // posted values
            $this->id = htmlspecialchars(strip_tags($table_id));
            // bind values
            $stmt->bindParam(":table_id", $this->id);
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
    public function readCategories()
    {
        try {
            $stmt = DataBase::getConnection()->prepare("SELECT * FROM categories");
            $stmt->execute();
            return  $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public function findUser($id)
    {
        $stmt = DataBase::getConnection()->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }
    public function findTable($id)
    {
        $stmt = DataBase::getConnection()->prepare("SELECT tables.*,categories.desc FROM tables,categories WHERE (tables.category_id=categories.id) AND tables.id=:id");
        $stmt->execute(array(":id"=>$id));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    }
}


