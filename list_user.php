<!-- Table Reservation Form -->
<?php include 'Class/User.php'; ?>

<section id="book-a-table" class="book-a-table">
    <div class="container mt-5" data-aos="fade-up">
        <table class="table table-striped table-bordered table-hover table-checkable" id="idtabUser">

            <thead style="background-color:#5161ce;color:black;font-size: 14px">
            <tr>
                <th colspan="9"
                    style="font-weight: bold;font-size:large; text-align:center;background-color:#f1f3f4;color:#000000">
                    User List
                </th>
            </tr>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Profil</th>
                <th>Owner</th>
                <th>created date</th>
                <th>Password</th>
                <th>###</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Profil</th>
                <th>Owner</th>
                <th>created date</th>
                <th>Password</th>
                <th>###</th>
            </tr>
            </tfoot>
        </table>
    </div>
</section>

<div class="modal" id="AddUserModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="title">Add New User</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="FormModalAddUser" method="post">
        <input type="hidden" id="user_id" name="user_id" value="">
          <div class="form-row">
            <label class="control-label col-md-2" for="email">Name *</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" placeholder="Name" required autocomplete="off">
            </div>
            <label class="control-label col-md-2" for="email">Username *</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required autocomplete="off">
            </div>
          </div>
          <hr>
          <div class="form-row">
            <label class="control-label col-md-2" for="email">Password *</label>
            <div class="col-md-4">
            <input type="text" class="form-control" name="password" id="password" placeholder="Password" required autocomplete="off">
            </div>
            <label class="control-label col-md-2" for="email">Profil</label>
            <div class="col-md-4">
                <select name="role" id="profil" class="custom-select mr-sm-2" required>
                    <option value="" selected>Select Profil</option>
                    <option value="User">User</option>
                    <option value="Administrator">Administrator</option>
                </select>
            </div>
          </div>
         <br>
          <div class="modal-footer">
            <button id="SaveUser" type="submit" class="btn btn-success">Save</button>
            <button id="CloseFormUser" type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">Close</button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
