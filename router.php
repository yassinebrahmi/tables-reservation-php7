<?php
!isset($_SESSION) ? session_start() :'';


if(isset($_GET['query']))
switch ($_GET['query']) {
    case'login':
        include 'Class/User.php';
        $user = new User();
        if (isset($_POST)) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            echo $user->login($username, $password);
        }
        break;
    case'logout':
        include 'Class/User.php';
        $user = new User();
        $user->logout();
        break;
    case'save_table':
        include 'Class/Table.php';
        $table = new Table();

        if (isset($_GET['table_id']) and $_GET['table_id'] != "") {

            $data = array();
            if (isset($_POST))
                $data = [
                    "table_id" => $_GET['table_id'],
                    "placement" => $_POST['placement'],
                    "category_id" => $_POST['category_id'],
                    "guests" => $_POST['guests'],
                    "description" => $_POST['description']
                ];

            if ($table->update($data) == true)
                echo json_encode(["status" => "success", "message" => "Table successfully updated"]);
            else
                echo json_encode(["status" => "failure", "message" => "Error : Table not updated"]);
        } else {
            $data = array();
            if (isset($_POST))
                $data = [
                    "placement" => $_POST['placement'],
                    "category_id" => $_POST['category_id'],
                    "guests" => $_POST['guests'],
                    "description" => $_POST['description']
                ];

            if ($table->create($data) == true)
                echo json_encode(["status" => "success", "message" => "Table successfully added"]);
            else
                echo json_encode(["status" => "failure", "message" => "Error : Table not added"]);
        }

        break;
    case'delete_table':
        include 'Class/Table.php';
        $table = new Table();
        if (isset($_POST['table_id']) && !empty($_POST['table_id'])) {
            if ($table->delete($_POST['table_id']) == true)
                echo json_encode(["status" => "success", "message" => "Table successfully deleted"]);
            else
                echo json_encode(["status" => "failure", "message" => "Error : Table not deleted"]);
        }

        break;
    case'show_table':
        include 'Class/Table.php';
        $table = new Table();
        $table->findTable($_GET['table_id']);
        break;
    case'save_user':
        include 'Class/User.php';
        $user = new User();
        if (isset($_GET['user_id']) and $_GET['user_id'] != "") {

            $data = array();
            if (isset($_POST))
                $data = [
                    "id" => $_GET['user_id'],
                    "name" => $_POST['name'],
                    "username" => $_POST['username'],
                    "password" => $_POST['password'],
                    "profil" => $_POST['profil'],
                    "created_by" => $_SESSION['user']['id']
                ];

            if ($user->update($data) == true)
                echo json_encode(["status" => "success", "message" => "User successfully updated"]);
            else
                echo json_encode(["status" => "failure", "message" => "Error : User not updated"]);
        } else {
            $data = array();
            if (isset($_POST))
                $data = [
                    "name" => $_POST['name'],
                    "username" => $_POST['username'],
                    "password" => $_POST['password'],
                    "profil" => $_POST['profil'],
                    "created_by" => $_SESSION['user']['id']
                ];

            if ($user->create($data) == true)
                echo json_encode(["status" => "success", "message" => "User successfully added"]);
            else
                echo json_encode(["status" => "failure", "message" => "Error : User not added"]);
        }

        break;
    case'delete_user':
        include 'Class/User.php';
        $user = new User();
        if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
            if ($user->delete($_POST['user_id']) == true)
                echo json_encode(["status" => "success", "message" => "User successfully deleted"]);
            else
                echo json_encode(["status" => "failure", "message" => "Error : User not deleted"]);
        }

        break;
    case'save_book':
        include 'Class/Reservation.php';
        $book = new Reservation();
        if (isset($_GET['book_id']) and $_GET['book_id'] != "") {

            $data = array();
            if (isset($_POST))
                $data = [
                    "book_id" => $_GET['book_id'],
                    "table_id" => $_POST['table_id'],
                    "name" => $_POST['name'],
                    "phone" => $_POST['phone'],
                    "many_people" => $_POST['many_people'],
                    "day" => $_POST['day'],
                    "time" => $_POST['time'],
                    "special_request" => $_POST['special_request'],
                    "created_by" => $_SESSION['user']['id']
                ];
            if ($book->CheckTableIsAvailable($_POST['table_id'], $_POST['day'], $_POST['time'],$_GET['book_id'])==false) {
                if ($book->update($data) == true)
                    echo json_encode(["status" => "success", "message" => "Reservation successfully updated"]);
                else
                    echo json_encode(["status" => "failure", "message" => "Error : User not updated"]);
            } else
                echo json_encode(["status" => "failure", "message" => "Error : Day Time not available"]);


        }
        else {
            $data = array();
            if (isset($_POST))
                $data = [
                    "table_id" => $_POST['table_id'],
                    "name" => $_POST['name'],
                    "phone" => $_POST['phone'],
                    "many_people" => $_POST['many_people'],
                    "day" => $_POST['day'],
                    "time" => $_POST['time'],
                    "special_request" => $_POST['special_request'],
                    "created_by" => $_SESSION['user']['id']
                ];

            if ($book->CheckTableIsAvailable($_POST['table_id'], $_POST['day'], $_POST['time'],"")==false) {
                if ($book->create($data) == true)
                    echo json_encode(["status" => "success", "message" => "Book successfully added"]);
                else
                    echo json_encode(["status" => "failure", "message" => "Error : book not added"]);

            } else
                echo json_encode(["status" => "failure", "message" => "Error : Day Time not available"]);

        }
        break;
    case'delete_book':
        include 'Class/Reservation.php';
        $book = new Reservation();
        if(isset($_POST['book_id']) && !empty($_POST['book_id'])) {
            if($book->delete($_POST['book_id'])==true)
                echo json_encode(["status"=>"success","message"=>"Book successfully deleted"]);
            else
                echo json_encode(["status"=>"failure","message"=>"Error : Book not deleted"]);
        }

        break;
    case'show_book':
              include 'Class/Reservation.php';
              $book = new Reservation();
        $book->findBook($_GET['book_id']);
              break;
    case'alltables':
        include 'Class/Table.php';
        $table = new Table();
            $table->readAllJson($_POST['search']['value'],$_POST['length'],$_POST['start'],$_POST['draw'],$_POST['order']);
        break;
    case'allusers':
        include 'Class/User.php';
        $user = new User();
        $user->readAllJson($_POST['search']['value'],$_POST['length'],$_POST['start'],$_POST['draw'],$_POST['order']);
        break;
    case'showuser':
        include 'Class/User.php';
        $user = new User();
        $user->findUserJson($_GET['user_id']);
        break;
    case'allbooks':
        include 'Class/Reservation.php';
        $book = new Reservation();
        $book->readAllReservation($_POST['search']['value'],$_POST['length'],$_POST['start'],$_POST['draw'],$_POST['order']);
        break;
    case'mybooks':
        include 'Class/Reservation.php';
        $book = new Reservation();
        $book->readReservationByEmploy($_POST['search']['value'],$_POST['length'],$_POST['start'],$_POST['draw'],$_POST['order']);
        break;
    case'allnotifys':
        include 'Class/Reservation.php';
        $book = new Reservation();
        $book->readAllNotification($_POST['search']['value'],$_POST['length'],$_POST['start'],$_POST['draw'],$_POST['order']);
        break;
    case'mynotifys':
        include 'Class/Reservation.php';
        $book = new Reservation();
        $book->readAllNotificationByEmploy($_POST['search']['value'],$_POST['length'],$_POST['start'],$_POST['draw'],$_POST['order']);
        break;
    case'accept_book':
        include 'Class/Reservation.php';
        $book = new Reservation();
        if(isset($_POST['book_id']) && !empty($_POST['book_id'])) {
            if($book->accept($_POST['book_id'])==true)
                echo json_encode(["status"=>"success","message"=>"Book successfully accepted"]);
            else
                echo json_encode(["status"=>"failure","message"=>"Error : Book not accepted"]);
        }
        break;
    case'refuse_book':
        include 'Class/Reservation.php';
        $book = new Reservation();
        if(isset($_POST['book_id']) && !empty($_POST['book_id'])) {
            if($book->refuse($_POST['book_id'])==true)
                echo json_encode(["status"=>"success","message"=>"Book successfully refused"]);
            else
                echo json_encode(["status"=>"failure","message"=>"Error : Book not refused"]);
        }
        break;
    case'profil_update':
        include 'Class/User.php';
        $user = new User();
            $data = array();

            if (isset($_POST))
                $data = [
                    "user_id" => $_POST['user_id'],
                    "name" => $_POST['name'],
                    "username" => $_POST['username'],
                    "new_password" => $_POST['new_password'],
                ];
            if ($user->updateAdminUser($data) == true)
                echo json_encode(["status" => "success", "message" => "User successfully updated"]);
            else
                echo json_encode(["status" => "failure", "message" => "Error : User not updated"]);

        break;
}

?>
