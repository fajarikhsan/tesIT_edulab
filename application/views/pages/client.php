<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- midtrans -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-hG5ZzKHI2qRqnX1D"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        * {
            font-family: Helvetica, Arial, sans-serif;
        }

        .jumbotron {
            background-color: #102777;
            padding: 48px;
        }

        body .jumbotron .container p {
            color: #fefefe !important;
        }
    </style>

    <title><?= $title; ?></title>
</head>

<body style="background-color: #fbfbfb;">
    <nav class="navbar navbar-light">
        <div class="container">
            <div class="navbar-brand mx-auto align-text-top">
                <img src="<?= base_url('assets/img/logo.png'); ?>" alt="logo" width="30" height="24" class="d-inline-block">
                <span>Client Area</span>
            </div>
        </div>
    </nav>

    <div class="jumbotron">
        <div class="container">
            <p class="fs-3">Invoice Biaya Pendidikan</p>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="card-title d-flex justify-content-between">Invoice <span class="badge <?= ($isPaid == 'PAID') ? 'bg-success' : 'bg-danger'; ?> "><?= $isPaid; ?></span></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Nomor Invoice : <?= $order_id; ?></h6>
                        <h6 class="card-subtitle mb-2 text-muted">Due Date : <?= date('d/m/Y', strtotime('+ 7 days')); ?></h6>
                        <p class="card-text mt-4 fw-bold">Tagihan Untuk :</p>
                        <p class="card-text"><?= $student['user_id']; ?></p>
                        <p class="card-text fw-bold mt-5">Detail Invoice</p>
                        <p class="card-text">
                        <ol class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div>Biaya</div>
                                </div>
                                <span>Rp <?= number_format($student['total_biaya']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div>Potongan</div>
                                </div>
                                <span>Rp <?= number_format($student['potongan']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div>Sudah dibayar</div>
                                </div>
                                <span>Rp <?= number_format($student['arp']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div>Sisa tagihan</div>
                                </div>
                                <span class="fw-bold fs-4">Rp <?= number_format($student['sisa_tagihan']); ?></span>
                            </li>
                        </ol>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Total Pembayaran</h6>
                        <h5 class="card-title fw-bold">Rp <?= number_format($student['sisa_tagihan']); ?></h5>
                        <?php if ($isPaid == "UNPAID") : ?>
                            <div class="d-grid mt-4" style="color: white;">
                                <button type="button" id="pay-button" class="card-link btn btn-primary" data-order_id="<?= $order_id; ?>" data-gross_amount="<?= $student['sisa_tagihan']; ?>" data-user_id="<?= $student['user_id']; ?>" data-student_id="<?= $student['id']; ?>">Bayar</button>
                            </div>
                        <?php else : ?>
                            <form action="<?= base_url('/client/printPayment'); ?>" method="post">
                                <div class="d-grid mt-4" style="color: white;">
                                    <input type="hidden" name="user_id" id="user_id" value="<?= $student['user_id']; ?>">
                                    <input type="hidden" name="total_biaya" id="total_biaya" value="<?= $student['total_biaya']; ?>">
                                    <input type="hidden" name="potongan" id="potongan" value="<?= $student['potongan']; ?>">
                                    <input type="hidden" name="sudah_dibayar" id="sudah_dibayar" value="<?= $student['arp']; ?>">
                                    <input type="hidden" name="sisa_tagihan" id="sisa_tagihan" value="<?= $student['sisa_tagihan']; ?>">
                                    <input type="hidden" name="nomor_invoice" id="nomor_invoice" value="<?= $order_id; ?>">
                                    <button type="submit" class="card-link btn btn-success">Cetak Bukti Pembayaran</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <script type="text/javascript">
        window.base_url = '<?php echo base_url(); ?>';
        var base_url = window.base_url;
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <script>
        $("#pay-button").on("click", function() {
            window.snap.show();
            var order_id = $(this).data("order_id");
            var gross_amount = $(this).data("gross_amount");
            var user_id = $(this).data("user_id");
            var student_id = $(this).data("student_id");
            $.ajax({
                url: base_url + "client/paymentProccess",
                method: "post",
                dataType: "json",
                data: {
                    order_id: order_id,
                    gross_amount: gross_amount,
                    user_id: user_id,
                    student_id: student_id,
                },
                success: function(data) {
                    window.snap.hide();
                    console.log(data);
                    window.snap.pay(data, {
                        onSuccess: function(result) {
                            $.ajax({
                                url: base_url + "/client/recordOrder",
                                method: "post",
                                data: {
                                    order_id: result.order_id,
                                    student_id: student_id,
                                    user_id: user_id,
                                    token: data
                                },
                                success: function() {
                                    location.reload();
                                }
                            });
                        },
                        onPending: function(result) {
                            $.ajax({
                                url: base_url + "/client/recordOrder",
                                method: "post",
                                data: {
                                    order_id: result.order_id,
                                    student_id: student_id,
                                    user_id: user_id,
                                    token: data
                                },
                                success: function() {
                                    location.reload();
                                }
                            });
                        }
                    });
                },
                error: function() {
                    window.snap.hide();
                }
            });
        });
    </script>
</body>

</html>