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
                                    <select name="id_role" id="id_role" class="form-control" onchange="toggleJurusan()">
                                        <option value="0"> ----> Pilih Role <---- </option>
                                        <option value="3"> Siswa </option>
                                        <option value="4"> Guru </option>
                                    </select>  
                                </div>
                                <div class="form-group" id="jurusan-container">
                                    <select name="id_jurusan" id="id_jurusan" class="form-control" >
                                        <option value="">Pilih Jurusan Magang</option>
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

            <script>
                function toggleJurusan() {
                    var role = document.getElementById("id_role").value;

                    if (role == 3) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "<?= base_url('mentor/get_jurusan_siswa'); ?>", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                document.getElementById("id_jurusan").innerHTML = xhr.responseText;
                            }
                        };

                        xhr.send("role=" + role); // Kirim role ke server
                    } else {
                        // Jika bukan siswa, kosongkan jurusan
                        document.getElementById("id_jurusan").innerHTML = '<option value=""> --> Pilih Jurusan Magang <-- </option>';
                    }
                }
            </script>



