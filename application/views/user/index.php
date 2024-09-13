


                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $this->session->flashdata('message'); ?>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <!-- Kolom untuk gambar dengan margin kanan 1 -->
                        <div class="col-md-4 pr-3 mb-5">
                            <img src="<?= base_url('assets/img/profile/') . $user['image'];?>" class="img-fluid rounded-center" style="width: 100%; height: auto;">
                        </div>
                        <!-- Kolom untuk kartu profil -->
                        <div class="col-md-8 pl-1">
                            <div class="card m-0 ">
                                <div class="card-header">
                                    <h3>PROFIL</h3>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Nama : <?= $user['name_user']; ?></li>
                                    <li class="list-group-item">Email : <?= $user['email_user']; ?></li>
                                    <li class="list-group-item">No. HP : <?= $user['no_hp']; ?></li>
                                    <li class="list-group-item">Sekolah : <?= $user['school']; ?></li>
                                    <li class="list-group-item">Nama Pembimbing (Sekolah) : <?= $user['nama_pembimbing']; ?></li>
                                    <li class="list-group-item">No. HP Pembimbing (Sekolah) : <?= $user['nohp_pembimbing']; ?></li>
                                    <?php
                                    $hari_indonesia = [
                                        'Sunday' => 'Minggu',
                                        'Monday' => 'Senin',
                                        'Tuesday' => 'Selasa',
                                        'Wednesday' => 'Rabu',
                                        'Thursday' => 'Kamis',
                                        'Friday' => 'Jumat',
                                        'Saturday' => 'Sabtu'
                                    ];

                                    $bulan_indonesia = [
                                        'January' => 'Januari',
                                        'February' => 'Februari',
                                        'March' => 'Maret',
                                        'April' => 'April',
                                        'May' => 'Mei',
                                        'June' => 'Juni',
                                        'July' => 'Juli',
                                        'August' => 'Agustus',
                                        'September' => 'September',
                                        'October' => 'Oktober',
                                        'November' => 'November',
                                        'December' => 'Desember'
                                    ];
                                    ?>
                                    <?php
                                    // Mengambil hari dan bulan dari timestamp
                                    $hari_inggris = date('l', $user['date_created']);
                                    $bulan_inggris = date('F', $user['date_created']);
                                    
                                    // Mengubah ke dalam bahasa Indonesia
                                    $hari = $hari_indonesia[$hari_inggris];
                                    $bulan = $bulan_indonesia[$bulan_inggris];
                                    
                                    // Format tanggal dalam bahasa Indonesia
                                    $tanggal_lengkap = $hari . ', ' . date('d', $user['date_created']) . ' ' . $bulan . ' ' . date('Y', $user['date_created']);
                                    ?>
                                    <li class="list-group-item">Tanggal Dibuat : <?= $tanggal_lengkap; ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

