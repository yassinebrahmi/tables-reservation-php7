<!-- Table Reservation Form -->
<?php include 'Class/User.php';
$db = new User();
$data = $db->findUser($_SESSION['user']['id']);
?>
<section id="book-a-table" class="book-a-table">
    <div class="container mt-5" data-aos="fade-up">
        <form id="FormProfil" method="post">
            <div class="form-row">
                <input type="hidden" id="user_id" value="<?=$data['id']?>">
                <div class="form-group col-md-6">
                    <label for="name">Profil</label>
                    <input type="text" class="form-control" id="role" placeholder="Role" value="<?=$data['profil']?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Username" required value="<?=$data['username']?>" autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Created_at</label>
                    <input type="text" class="form-control" id="inputPassword4" placeholder="Role" value="<?=$data['created_at']?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name" required value="<?=$data['name']?>" autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label for="old_password">Old Password</label>
                    <input type="text" class="form-control" id="old_password" placeholder="Old Password" value="<?=$db->decryptPass($data['password'])?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label for="new_password">New Password</label>
                    <input type="text" class="form-control" id="new_password" placeholder="New Password" value="" required autocomplete="off">
                </div>
                <div class="form-group col-md-3">
                    <label for="conf_password">Confirm Password</label>
                    <input type="text" class="form-control" id="conf_password" placeholder="Confirm Password" required value="" autocomplete="off">
                    <small id="CheckPasswordMatch" class="form-text text-muted"></small>
                </div>
                <div class="form-group col-md-12">
                <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>


        </form>
    </div>
</section>
<!-- End Table Reservation Form -->