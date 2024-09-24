                <!-- Begin Page Content -->
                <div class="scroll">
                <div class="container-fluid">
                    <div class="row">
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <div class="card container-fluid">
                    <?= $this->session->flashdata('message'); ?>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover table-striped " id="datatable">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Hari/Tanggal</th>
                                    <th>Masuk</th>
                                    <th>Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($daily as $d): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $d['name_user']; ?></td>
                                    <td><?= $d['date_job']; ?></td>
                                    <td><?= $d['time']; ?></td>
                                    <td><?= $d['job']; ?></td>
                                </tr>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    </div>
                </div>
                </div>
