                <!-- Begin Page Content -->
                <div class="container-fluid">
                
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <?= $this->session->flashdata('message'); ?>

                    <?php $dateWeek = date('N');
                    if(($dateWeek == 6) || ($dateWeek == 7)) :
                    ?>
                    <h2>Maap Hari Ini Hari Libur Anda Tidak Bisa Absen</h2>
                    <?php else : ?>
                        <?php if(date('H:i:s') < '15:59:59') :?>
                        <form action="<?= base_url('user/absen_in') ?>" method="post">
                            <div class="card" >
                                <div class="card-header">
                                    <h3>Absensi Masuk</h3>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Nama : <?= $user['name_user']; ?></li>
                                    <li class="list-group-item">Sekolah : <?= $user['school']; ?></li>
                                    <li class="list-group-item">Hari/Tanggal : <?= date('Y-m-d'); ?> </li>
                                    <li class="list-group-item">Jam : <?= date('H:i') ?></li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <span>Keterangan : </span>
                                        <select name="information" id="information" class="form-control ml-2" style="width: 15rem;">
                                            <option value="">Pilih Keterangan</option>
                                            <?php  foreach($value as $v)  : ?>
                                                <option value="<?= $v['id']; ?>"><?= $v['value']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <button type="submit" class="btn btn-success" style="margin-top: 15px;">Absen</button>
                        </form>
                        <?php elseif(date('H:i:s') > '16:00:00') :?>
                        <form action="<?= base_url('user/absen_out') ?>" method="post">
                            <div class="card" >
                                <div class="card-header">
                                    <h3>Absensi Pulang</h3>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Nama : <?= $user['name_user']; ?></li>
                                    <li class="list-group-item">Sekolah : <?= $user['school']; ?></li>
                                    <li class="list-group-item">Hari/Tanggal : <?= date('Y-m-d'); ?> </li>
                                    <li class="list-group-item">Jam Pulang: <?= date('H:i') ?></li>
                                </ul>
                            </div>
                            <button type="submit" class="btn btn-danger" style="margin-top: 15px;">Absen Bulik</button>
                        </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

