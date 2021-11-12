            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Keuangan Murid</h1>
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
                        <?php if ($this->session->flashdata('upload-success')) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Data Import has been successful.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('upload-failed')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Data Import Failed.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <?= form_open_multipart('student/upload_data'); ?>
                        <div class="row">
                            <div class="col-4">
                                Upload Data to MySQL (excel)
                                <div class="mt-2">
                                    <input type="file" name="uploadExcel">
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Submit</button>
                            </div>
                        </div>
                        </form>
                        <div class="card mt-4">
                            <div class="card-body">
                                <table class="table" id="students">
                                    <thead>
                                        <tr>
                                            <th scope="col">USER ID</th>
                                            <th scope="col">CABANG BELAJAR</th>
                                            <th scope="col">TOTAL BIAYA</th>
                                            <th scope="col">POTONGAN</th>
                                            <th scope="col">DP</th>
                                            <th scope="col">ANGSURAN 1</th>
                                            <th scope="col">ANGSURAN 2</th>
                                            <th scope="col">PRICE</th>
                                            <th scope="col">ARP</th>
                                            <th scope="col">ARO</th>
                                            <th scope="col">STATUS</th>
                                            <th scope="col">PERSENTASE</th>
                                            <th scope="col">CETAK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $student) : ?>
                                            <tr>
                                                <td><?= $student['user_id']; ?></td>
                                                <td><?= $student['cabang_belajar']; ?></td>
                                                <td><?= $student['total_biaya']; ?></td>
                                                <td><?= $student['potongan']; ?></td>
                                                <td><?= $student['dp']; ?></td>
                                                <td><?= $student['angsuran_1']; ?></td>
                                                <td><?= $student['angsuran_2']; ?></td>
                                                <td><?= $student['price']; ?></td>
                                                <td><?= $student['arp']; ?></td>
                                                <td><?= $student['aro']; ?></td>
                                                <td><?= $student['status']; ?></td>
                                                <td><?= $student['persentase']; ?> %</td>
                                                <td>
                                                    <form action="<?= base_url('student/invoice'); ?>" method="post">
                                                        <input type="hidden" name="user_id" id="user_id" value="<?= $student['user_id']; ?>">
                                                        <input type="hidden" name="total_biaya" id="total_biaya" value="<?= $student['total_biaya']; ?>">
                                                        <input type="hidden" name="potongan" id="potongan" value="<?= $student['potongan']; ?>">
                                                        <input type="hidden" name="total" id="total" value="<?= $student['price']; ?>">
                                                        <input type="hidden" name="sudah_dibayar" id="sudah_dibayar" value="<?= $student['arp']; ?>">
                                                        <input type="hidden" name="sisa_tagihan" id="sisa_tagihan" value="<?= $student['aro']; ?>">
                                                        <button type="submit" class="btn btn-info btnCetak"> Cetak </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->