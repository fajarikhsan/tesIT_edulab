            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Resume Statistik</h1>
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
                        <?php if ($this->session->flashdata('export-success')) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Data has been exported successfully. Export location : <i>xxx</i>/laporan/laporan.xlsx
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <form action="<?= base_url('statistics/export'); ?>">
                            <button type="submit" class="btn btn-primary">Cetak Laporan</button>
                        </form>
                        <div id="userCount" style="height: 300px; width: 80%;" class="mt-3 mx-auto"></div>
                        <div id="paidUser" style="height: 300px; width: 80%;" class="mt-3 mx-auto"></div>
                        <div id="unpaidUser" style="height: 300px; width: 80%;" class="mt-3 mx-auto"></div>
                        <div id="totalWithDiscount" style="height: 300px; width: 80%;" class="mt-3 mx-auto"></div>
                        <div id="totalPaid" style="height: 300px; width: 80%;" class="mt-3 mx-auto"></div>
                        <div id="totalUnpaid" style="height: 300px; width: 80%;" class="mt-3 mx-auto"></div>
                        <div id="paidPercentage" style="height: 300px; width: 80%;" class="mt-3 mx-auto"></div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->