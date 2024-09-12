                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <form action="<?= base_url('user/absensi') ?>" method="post">
                        <div class="card" >
                            <div class="card-header">
                                <h3>Absensi</h3>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Nama : <?= $user['name_user']; ?></li>
                                <li class="list-group-item">Sekolah : <?= $user['school']; ?></li>
                                <li class="list-group-item">Hari/Tanggal : <?= $hari; ?> </li>
                                <li class="list-group-item">Jam : <?= date('H:i') ?></li>
                                <li class="list-group-item d-flex align-items-center">
                                    <span>Keterangan : </span>
                                    <select name="information" id="information" class="form-control ml-2" style="width: 15rem;">
                                        <option value="">Pilih Keterangan</option>
                                        <?php  foreach($value as $v)  : ?>
                                            <option value="<?= $v['value']; ?>"><?= $v['value']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </li>
                            </ul>
                        </div>
                        <button type="submit" class="btn btn-success" style="margin-top: 15px;">Absen</button>
                    </form>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

