                <!-- Begin Page Content -->
                <div class="scroll">
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="card container-fluid">
                    <div class="table-responsive mt-3">
                        <div class="row mb-3">
                            <!-- Tambah Pekerjaan dan Refresh dalam satu baris -->
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="d-flex mb-2 mb-md-0">
                                            <a href="" class="btn btn-info w-100" data-toggle="modal" data-target="#newPrintDataActivitiesModal">
                                                <i class="fas fa-print"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex mb-2 mb-md-0">
                                            <form action="<?= base_url('mentor/refresh_dataactivities') ?>" method="post" class="w-100">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-sync"></i> Refresh
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <!-- Form pencarian dengan tanggal yang responsif -->
                                <form action="<?= base_url('mentor/dataactivities') ?>" method="post" class="row g-3">
                                    <!-- Input tanggal "Dari Tanggal" -->
                                    <div class="col-md-4">
                                        <label for="start_date" class="form-label">Dari Tanggal:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control">
                                    </div>
                                    <!-- Input tanggal "Sampai Tanggal" -->
                                    <div class="col-md-4">
                                        <label for="end_date" class="form-label">Sampai Tanggal:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control">
                                    </div>
                                    <!-- Tombol Cari -->
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-secondary w-100 mt-3">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <table class="table table-bordered table-hover table-striped " id="datatable">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($daily as $d): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $d['name_user']; ?></td>
                                    <td><?= date("d-m-Y", strtotime($d['date_job'])); ?></td>
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
<!-- Modal -->
<div class="modal fade" id="newPrintDataActivitiesModal" tabindex="-1" aria-labelledby="newPrintDataActivitiesModalLabel" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newPrintDataActivitiesModalLabel">Print</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">
                &times;
            </span>
        </button>
      </div>
      <form action="<?= base_url('mentor/print_dataactivities'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <label for="nama" class="form-label">Nama Siswa</label>
                <select name="nama" id="nama" class="form-control">
                    <option value="0">Pilih Siswa</option>
                    <?php  foreach($student as $s)  : ?>
                    <option value="<?= $s['id_user']; ?>"><?= $s['name_user']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date" class="form-label">Dari Tanggal:</label>
                <input type="date" id="start_date" name="start_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="end_date" class="form-label">Sampai Tanggal:</label>
                <input type="date" id="end_date" name="end_date" class="form-control">
            </div>
            <div class="form-check">
                <input class="form-check" type="checkbox" value="1" id="flexCheckChecked" name="checkk">
                <label class="form-check-label" for="checkk">
                    Semua Kegiatan?
                </label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
        </div>
      </form>
    </div>
  </div>
</div>
