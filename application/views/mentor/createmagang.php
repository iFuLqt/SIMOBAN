                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
                    <?= $this->session->flashdata('message') ?>
                    <form class="user" method="post" action="<?= base_url('mentor/registration'); ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="name" name="name"
                                        placeholder="Nama Lengkap" value="<?= set_value('name');?>">
                                        <?= form_error('name','<small class="text-danger pl-3">','</small>');?>      
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="email" name="email"
                                        placeholder="Email" value="<?= set_value('email');?>">
                                        <?= form_error('email','<small class="text-danger pl-3">','</small>');?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="school" name="school"
                                        placeholder="Sekolah" value="<?= set_value('school');?>">
                                        <?= form_error('school','<small class="text-danger pl-3">','</small>');?>
                                </div>
                                <div class="form-group">
                                    <select name="id_jurusan" id="id_jurusan" class="form-control">
                                        <option value="">Pilih Jurusan Magang</option>
                                        <?php foreach( $jur as $j) : ?>
                                        <option value="<?= $j['id']; ?>">
                                            <?= $j['jurusan']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>  
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="password1" name="password1" placeholder="Password">
                                            <?= form_error('password1','<small class="text-danger pl-3">','</small>');?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="password2" name="password2" placeholder="Ulangi Password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

