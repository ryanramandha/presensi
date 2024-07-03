<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-2">
            <h1>Presensi Pegawai</h1>
        </div>
    </div>
</section>

<section class="content mx-3">

    <div class="card">
        <div class="card-body my-2">

            <?php if ($libur) : ?>
                <div class="alert alert-danger">
                    Hari ini libur: <?= $nama_libur ?>
                </div>
            <?php else : ?>
                <?php if ($cuti) : ?>
                    <div class="alert alert-danger">
                        Anda sedang izin/cuti/off
                    </div>
                <?php else : ?>

                    <?php if (empty($jam_masuk) || empty($jam_pulang)) : ?>
                        <?php if (empty($jam_masuk) || (!empty($jam_masuk) && $foto != '')) : ?>
                            <button class="btn btn-success btn-block mb-2" id="btnScan"><i class="fa fa-qrcode mr-2"></i> Scan QR Code</button>
                        <?php endif; ?>
                        <?php if ($jam_masuk && $foto == '') : ?>
                            <button class="btn btn-primary btn-block mb-2" id="btnFoto"><i class="fa fa-camera mr-2"></i> Foto</button>
                        <?php endif; ?>
                        <a href="<?= route_to('presensi') ?>" id="btnBatal" class="btn btn-danger btn-block mb-4 d-none"><i class="fa fa-times mr-2"></i> Batal</a>
                        <div class="form-group mb-2 d-none" id="formKamera">
                            <label for="selectKamera">Pilih Kamera</label>
                            <select class="form-control" id="selectKamera"></select>
                        </div>
                        <div class="form-group mb-2 d-none" id="formKamera2">
                            <label for="selectKamera2">Pilih Kamera</label>
                            <select class="form-control" id="selectKamera2"></select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <video class="mb-2 d-none" id="previewKamera" style="width: 300px; height: 300px;"></video>
                            <video id="video" autoplay class="mb-2" style="width: 300px; height: 300px; display: none;"></video>
                        </div>
                        <canvas id="canvas" class="d-none"></canvas>
                        <button class="btn btn-primary btn-block mb-4 d-none" id="btnAmbilFoto"><i class="fa fa-check mr-2"></i> Ambil Foto</button>
                    <?php endif; ?>

                    <div class="table- mt-2">
                        <table class="table table-hover">
                            <tr>
                                <th>Tanggal</th>
                                <td><?= $tanggal_hari_ini ?></td>
                            </tr>
                            <tr>
                                <th>Masuk</th>
                                <td>
                                    <?= $jam_masuk ?? '' ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Pulang</th>
                                <td>
                                    <?= $jam_pulang ?? '' ?>
                                </td>
                            </tr>
                            <?php if ($foto) : ?>
                                <tr>
                                    <th>Foto</th>
                                    <td>
                                        <img src="<?= base_url('uploads/' . $foto) ?>" alt="Foto" class="img-thumbnail">
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>

</section>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?php if (!$libur || !$cuti) : ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <script>
        // inisialisasi scanner
        const qrCodeReader = new ZXing.BrowserMultiFormatReader();
        const selectKamera = $("#selectKamera");
        let selectedDeviceId = null;

        // event handler button scan saat click
        $("#btnScan").on('click', startScanning);

        // event handler select kamera pada saat change value
        $(document).on('change', '#selectKamera', function() {
            // set selected device id
            selectedDeviceId = $(this).val();
            // lalu reset dan init scanner
            resetAndInitScanner();
        });

        function startScanning() {
            // cek jika qrCodeReader tidak null, maka reset dan init scanner
            if (qrCodeReader) {
                resetAndInitScanner();
            }
        }

        function resetAndInitScanner() {
            // reset scanner
            qrCodeReader.reset();
            // tampilkan form kamera, preview kamera, dan button batal
            $("#formKamera, #previewKamera, #btnBatal").removeClass("d-none");
            $("#btnFoto").hide();
            // init scanner
            initScanner();
        }

        function initScanner() {
            qrCodeReader
                .listVideoInputDevices() // ambil list video input devices
                .then(handleVideoInputDevices) // lalu handle video input devices
                .catch(handleError); // handle error
        }

        // fungsi untuk handle video input devices
        function handleVideoInputDevices(videoInputDevices) {
            // jika video input devices lebih dari 0
            if (videoInputDevices.length > 0) {
                // update select kamera dengan list video input devices
                updateSelectKamera(videoInputDevices);

                // decode sekali (tidak berulang) dari video device terpilih ke preview kamera
                qrCodeReader
                    .decodeOnceFromVideoDevice(selectedDeviceId, 'previewKamera')
                    .then(handleScanResult) // lalu handle hasil scan
                    .catch(handleError);
            } else {
                // jika video input devices tidak ditemukan, maka tampilkan alert
                alert("Kamera tidak ditemukan!");
            }
        }

        // fungsi untuk update select kamera dengan list video input devices
        function updateSelectKamera(videoInputDevices) {
            // kosongkan select kamera
            selectKamera.empty();

            // loop video input devices
            videoInputDevices.forEach((element) => {
                // tambahkan option ke select kamera dengan value deviceId dan label device label
                const option = $('<option>').text(element.label).val(element.deviceId);

                // jika deviceId sama dengan selectedDeviceId, maka set option selected true
                if (element.deviceId == selectedDeviceId) {
                    option.prop('selected', true);
                }

                // tambahkan option ke select kamera
                selectKamera.append(option);
            });
        }

        // fungsi untuk handle hasil scan
        function handleScanResult(result) {
            console.log(result.text);

            // result.text berisi data url dari qr code

            // buat form data kosong
            const formData = new FormData();

            // kirim post request
            fetch(result.text, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // tampilkan alert success
                        swal({
                                icon: 'success',
                                title: 'Success',
                                text: data.success,
                                showConfirmButton: true,
                            })
                            .then(() => {
                                // redirect ke halaman presensi
                                window.location.href = data.redirect;
                            });
                    }
                })
                .catch(error => {
                    console.error('Error dalam POST request:', error);
                });

        }

        function handleError(err) {
            console.error(err);
        }

        // cek jika browser tidak support mediaDevices, maka tampilkan alert
        if (!navigator.mediaDevices) {
            alert('Tidak bisa mengakses kamera!');
        }

        // proses foto
        const video = $("#video")[0];
        const canvas = $("#canvas")[0];
        const deviceList = $("#selectKamera2");
        const capturePhotoButton = $("#btnAmbilFoto");

        let currentStream;

        function getVideoDevices() {
            navigator.mediaDevices
                .enumerateDevices()
                .then((devices) => {
                    deviceList.empty(); // Clear existing options
                    const videoDevices = devices.filter(
                        (device) => device.kind === "videoinput"
                    );
                    videoDevices.forEach((device) => {
                        const option = $("<option>")
                            .val(device.deviceId)
                            .text(device.label || `Camera ${videoDevices.indexOf(device) + 1}`);
                        deviceList.append(option);
                    });

                    // If there are video devices, select the first one and set up the webcam
                    if (videoDevices.length > 0) {
                        const firstDeviceId = videoDevices[0].deviceId;
                        setupWebcam(firstDeviceId);
                    }
                })
                .catch((err) => {
                    console.error("Error enumerating video devices: ", err);
                });
        }

        function setupWebcam(deviceId) {
            const constraints = {
                video: {
                    deviceId: {
                        exact: deviceId
                    }
                },
            };
            navigator.mediaDevices
                .getUserMedia(constraints)
                .then((stream) => {
                    stopStream(); // Stop previous stream if exists
                    currentStream = stream;
                    video.srcObject = stream;
                    capturePhotoButton.removeClass("d-none");
                })
                .catch((err) => {
                    console.error("Error accessing the webcam: ", err);
                });
        }

        function stopStream() {
            if (currentStream) {
                currentStream.getTracks().forEach((track) => track.stop());
            }
        }

        $("#btnFoto").on('click', function() {
            $("#formKamera2, #btnBatal").removeClass("d-none");
            video.style.display = "block";
            $("#btnScan").hide();
            getVideoDevices();
        });

        // Event listener for when the selected device changes
        deviceList.change(function() {
            const selectedDeviceId = $(this).val();
            if (selectedDeviceId) {
                setupWebcam(selectedDeviceId);
            }
        });

        // Event listener for capturing the photo
        capturePhotoButton.click(function() {
            const context = canvas.getContext("2d");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert canvas image to base64 data URL
            const imageData = canvas
                .toDataURL("image/png")
                .replace("data:image/png;base64,", "");

            $.ajax({
                type: "POST",
                url: "<?= route_to('presensi.foto') ?>",
                data: {
                    image: imageData
                },
                success: function(response) {
                    window.location.href = response.redirect
                },
            });
        });
    </script>
<?php endif; ?>
<?= $this->endSection() ?>