            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Tampilan Admin</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Starter Page</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <table class="table" id="admin_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Sisa Tagihan</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Total Pembayaran</th>
                                    <th scope="col">Status Transaksi</th>
                                    <th scope="col">Status Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($payments as $payment) : ?>
                                    <tr>
                                        <th scope="row"><?= $i++; ?></th>
                                        <td><?= $payment['user_id']; ?></td>
                                        <td><?= $payment['sisa_tagihan']; ?></td>
                                        <td><?= $payment['invoice']; ?></td>
                                        <td><?= $payment['total_pembayaran']; ?></td>
                                        <td><?= $payment['status_transaksi']; ?></td>
                                        <td><span class="badge <?= ($payment['status'] == 'PAID') ? 'badge-success' : 'badge-danger'; ?> badge-secondary"><?= $payment['status']; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->