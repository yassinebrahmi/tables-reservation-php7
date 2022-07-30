<!-- Table Reservation Form -->
<section id="book-a-table" class="book-a-table">
    <div class="container mt-5" data-aos="fade-up">
        <table class="table table-striped table-bordered table-hover table-checkable" id="idtabBook">
            <thead style="background-color:#5161ce;color:black;font-size: 14px">
            <tr>
                <th colspan="12"
                    style="font-weight: bold;font-size:large; text-align:center;background-color:#f1f3f4;color:#000000">
                    Reservation List
                </th>
            </tr>
            <tr>
                <th>ID</th>
                <th>TableID</th>
                <th>Table Name</th>
                <th>Client</th>
                <th>Phone</th>
                <th>Many People</th>
                <th>Day</th>
                <th>Time</th>
                <th>special_request</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Book Date</th>
                <th>###</th>
            </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
            <tr>

                <th>ID</th>
                <th>TableID</th>
                <th>Table Name</th>
                <th>Client</th>
                <th>Phone</th>
                <th>Many People</th>
                <th>Day</th>
                <th>Time</th>
                <th>special_request</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Book Date</th>
                <th>###</th>
            </tr>
            </tfoot>
        </table>
    </div>
</section>

<div class="modal" id="AddBookModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Make a reservation</h5>
            </div>
            <div class="modal-body">
                <form role="form" id="FormModalAddBook" method="post">
                    <input type="hidden" id="book_id" name="book_id" value="">
                    <div class="form-row">
                        <label class="control-label col-md-2" for="email">Table *</label>
                        <div class="col-md-4">

                            <select name="table_id" id="table_id" class="custom-select mr-sm-2" required>
                                <option value="" selected>Select Table</option>
                                <?php
                                include 'Class/Reservation.php';
                                $db = new Reservation();
                                $cats = $db->readTables();
                                foreach ($cats as $cat) {
                                    ?>
                                    <option value="<?=$cat['id'] ?>"><?=$cat['tablebook'] ?></option>
                                <?php } ?>

                            </select>
                        </div>

                        <label class="control-label col-md-2" for="name">Client Name *</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Client name"
                                   required autocomplete="off">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <label class="control-label col-md-2" for="phone">Phone </label>
                        <div class="col-md-4">
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone" required
                                   autocomplete="off">
                        </div>
                        <label class="control-label col-md-2" for="many_people">Many People *</label>
                        <div class="col-md-4">
                            <input type="number" class="form-control" name="many_people" id="many_people"
                                   placeholder="How Many People" required autocomplete="off" min="1">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <label class="control-label col-md-2" for="email">Date *</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="day" id="day" placeholder="Date" required
                                   autocomplete="off">
                        </div>
                        <label class="control-label col-md-2" for="time">Time *</label>
                        <div class="col-md-4">
                            <input type="time" class="form-control" name="time" id="time" placeholder="Time" required
                                   autocomplete="off">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <label class="control-label col-md-2" for="special_request">Special Request</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="special_request" name="special_request"
                                      placeholder="Special Request" autocomplete="off"></textarea>
                        </div>

                    </div>
                    <br>
                    <div class="modal-footer">
                        <button id="SaveBook" type="submit" class="btn btn-success">Book Now</button>
                        <button id="CloseFormBook" type="button" class="btn btn-secondary" data-dismiss="modal"
                                aria-hidden="true">Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
