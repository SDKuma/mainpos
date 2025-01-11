<?php
include('includes/header.php');
?>

    <main>
        <div class="container-fluid px-4">
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Customers
                        <a href="customer-create.php" class="btn btn-primary float-end">Add Customer</a>
                    </h4>

                </div>
                <div class="card-body">
                    <?php alertMessage() ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="customers-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $customers = getAll('customers');
                            if (mysqli_num_rows($customers) > 0) {
                                foreach ($customers as $item) :
                                    ?>
                                    <tr>
                                        <td><?= $item['id'] ?></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['email'] ?></td>
                                        <td><?= $item['phone'] ?></td>
                                        <td>
                                            <?php
                                            if ($item['status'] == 1) {
                                                echo '<span class="badge bg-danger">Banned</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <button onclick="viewhistory('<?= $item['id'] ?>')"><i class="fa fa-history" aria-hidden="true"></i>
                                            </button>
                                            &nbsp;
                                            <a href="customer-edit.php?id=<?= $item['id']; ?>"
                                               class="btn btn-sm btn-success">Edit</a>
                                            <a href="customer-delete.php?id=<?= $item['id']; ?>"
                                               class="btn btn-sm btn-danger">Delete</a>

                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center">No Records Found!</td>
                                </tr>
                                <?php
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <dialog id="history-modal">
        <div>
            <h3>Customer History</h3>
            <div id="customer-detail-footer">
                <button class="btn btn-danger" onclick="close_modal()"><i class="fa fa-close" aria-hidden="true"></i></button>
            </div>
            <hr/>

        </div>
        <div>
            <table width="100%">
                <tr>
                    <td id="customer-detail" style="border-right: 1px solid black;padding: 10px">

                    </td>
                    <td id="total-orders" style="padding: 20px">
                        <table width="100%">
                            <thead>
                            <tr><th>Order Id</th><th>Date</th><th>Amount</th></tr>
                            </thead>
                            <tbody id="order-rows-con">

                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

    </dialog>
<?php
include('includes/footer.php');
?>