<!-- Table Reservation Form -->
<?php include 'Class/Table.php'; ?>

<section id="book-a-table" class="book-a-table">
    <div class="container mt-5" data-aos="fade-up">
        <table class="table table-striped table-bordered table-hover" id="idtab">

            <thead style="background-color:#5161ce;color:black;font-size: 14px">
            <tr>
                <th colspan="10"
                    style="font-weight: bold;font-size:large; text-align:center;background-color:#f1f3f4;color:#000000">
                    Table List
                </th>
            </tr>
            <tr>

                <th>ID</th>
                <th>category_id</th>
                <th>REF</th>
                <th>Placement</th>
                <th>Style</th>
                <th>Guests</th>
                <th>Created Date</th>
                <th>description</th>
                <th>###</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <th>ID</th>
                <th>category_id</th>
                <th>REF</th>
                <th>Placement</th>
                <th>Style</th>
                <th>Guests</th>
                <th>Created Date</th>
                <th>description</th>
                <th>###</th>
            </tr>
            </tfoot>
        </table>
    </div>
</section>

<div class="modal" id="AddTableModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="title">Add New Table</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="FormModalAddTable" method="post">
        <input type="hidden" id="table_id" name="table_id" value="">
          <div class="form-row">
            <label class="control-label col-md-2" for="placement">Placements *</label>
            <div class="col-md-4">
              <select name="placement" id="placement" class="custom-select mr-sm-2" required>
                        <option value="" selected>Select Placement</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
            </div>

            <label class="control-label col-md-2" for="email">Styles *</label>
            <div class="col-md-4">
            <select name="category_id" id="category_id" class="custom-select mr-sm-2" required>
                        <option value="" selected>Select Style</option>
                        <?php $table = new  Table();
                        $cats = $table->readCategories();
                        foreach ($cats as $cat){
                        ?>
                        <option value="<?=$cat['id'] ?>"><?=$cat['desc'] ?></option>
                        <?php } ?>
                    </select>
            </div>
          </div>
          <hr>
          <div class="form-row">
            <label class="control-label col-md-2" for="guests">No.Guests *</label>
            <div class="col-md-4">
            <input type="number" class="form-control" name="guests" id="guests" placeholder="No. of Guests" required autocomplete="off" min="1">
            </div>
            <label class="control-label col-md-2" for="email">Description</label>
            <div class="col-md-4">
            <textarea class="form-control" id="description" name="Description" placeholder="Description"  autocomplete="off"></textarea>
            </div>
          </div>
         <br>
          <div class="modal-footer">
            <button id="SaveTable" type="submit" class="btn btn-success">Save Table</button>
            <button id="CloseForm" type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">Close</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
