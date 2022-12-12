<?= $this->extend('ServiceApplication/Layout/ServiceLayout'); ?>
<?= $this->section('content'); ?>


<?php $link = base_url('service-request'); ?>
<?= Success() ?>
<?= Error() ?>


<!-- Modal -->


<!-- Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- <object data="http://localhost/vipimo/uploads/documents/Registered Vehicle Tanks_1668243364_6a2c39037b48e434d1f8.pdf" > -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- *********************************************************** -->
<div class="modal fade" id="attachmentModelEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <?= csrf_field() ?>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Attachment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="attachmentFormEdit" enctype="multipart/form-data">
                    <input type="text" name="userId" id="" class="form-control" value="<?= $userId ?>" hidden>
                    <input type="text" name="id" id="id" class="form-control" value="" hidden>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name Of The Document</label>
                                <select class="form-control" name="documentName" id="docName">
                                    <option value="Business License">Business License</option>
                                    <option value="TIN Number">TIN Number</option>
                                    <option value="Tax Clearance">Tax Clearance</option>
                                    <option value="Brela Registration Document">Brela Registration Document</option>
                                    <option value="National Id / Voter Id Or Driver License">National Id / Voter Id Or Driver License</option>
                                    <option value="Work Permit">Work Permit(Non Tanzanian)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">File</label>
                                <input type="file" name="document" id="file" class="form-control" accept="application/pdf" required>
                                <small id="document" class="text-danger document"></small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="progressEdit">
                                <div class="progress-bar progress-barEdit" role="progressbar" style="width: 0%;"></div>
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- *********************************************************** -->

<div class="modal fade" id="attachmentModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <?= csrf_field() ?>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="attachmentForm" enctype="multipart/form-data">
                    <input type="text" name="userId" id="" class="form-control" value="<?= $userId ?>" hidden>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name Of The Document</label>
                                <select class="form-control" name="documentName" id="">
                                    <option value="Business License">Business License</option>
                                    <option value="TIN Number">TIN Number</option>
                                    <option value="Tax Clearance">Tax Clearance</option>
                                    <option value="Brela Registration Document">Brela Registration Document</option>
                                    <option value="National Id / Voter Id Or Driver License">National Id / Voter Id Or Driver License</option>
                                    <option value="Work Permit">Work Permit(Non Tanzanian)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">File</label>
                                <input type="file" name="document" id="file" class="form-control" accept="application/pdf" required>
                                <small id="document" class="text-danger document"></small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="progress" style="display:none;">
                                <div class="progress-bar progress-barUpload " role="progressbar" style="width: 0%;"></div>
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>



<div class="card card-box">
    <div class="card-header">


        <button id="sample_editable_1_new" class="btn btn-primary btn-sm pull-left" data-toggle="modal" data-target="#attachmentModel">
            <i class="fa fa-plus"></i> Add Attachment
        </button>
        <div class="btn-group pull-right btn-prev-next">

            <a href="<?= $link . '/tools' ?>" class="btn btn-sm btn-primary" type="button">
                <i class="fa fa-chevron-left"></i>back: Tools/Equipments
            </a>
            <a href="<?= $link . '/submission' ?>" class="btn btn-sm btn-primary <?= empty($attachments) ? 'disabled' : '' ?>" id="nextBtn" type="button">
                next: Submit Application <i class="fa fa-chevron-right"></i>
            </a>

        </div>
    </div>
    <div class="card-body">
        <div>
            <table class="table table-sm" style="width:100% ;">
                <thead>
                    <tr>
                        <th>Document Name</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="attachments">
                    <?php foreach ($attachments as $attachment) : ?>
                        <tr>
                            <td><?= $attachment->document ?></td>
                            <td>
                                <a href="'<?= $attachment->path ?>" class="btn btn-success btn-tbl-edit btn-xs" download><i class="fas fa-file-pdf"></i></a>




                            </td>
                            <td>


                                <button class="btn btn-primary btn-tbl-edit btn-xs" onclick="editAttachment('<?= $attachment->id ?>')"><i class="fas fa-pen"></i></button>




                            </td>
                            <td>


                                <a href="<?= $link . '/deleteAttachment/' . $attachment->id ?>" class="btn btn-danger btn-tbl-edit btn-xs"><i class="fas fa-trash"></i></a>


                            </td>


                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>




    </div>
</div>
</div>

<script>
    function validationError(field, errors) {
        const element = document.querySelector('.' + field)
        errors[field] ? element.textContent = errors[field] : element.textContent = ''

    }
    const attachmentForm = document.querySelector('#attachmentForm')

    attachmentForm.addEventListener('submit', (e) => {
        e.preventDefault()
        const formData = new FormData(attachmentForm)
        const progress = document.querySelector('.progress')
        const progressBar = document.querySelector('.progress-barUpload')
        progress.style.display = 'block'


        // formData.append('document', document.querySelector('#file').files[0])
        formData.append('csrf_hash', document.querySelector('.token').value)

        let xhr = new XMLHttpRequest()
        xhr.open('POST', 'addAttachment')
        xhr.upload.addEventListener('progress', ({
            loaded,
            total
        }) => {
            const uploaded = Math.floor((loaded / total) * 100)
            progressBar.style.width = uploaded + '%'
            progressBar.textContent = uploaded + '%'

        })
        xhr.onload = function() {
            const data = JSON.parse(this.response)
            const {
                status,
                token,
                errors,
                attachments,
                msg
            } = data

            // console.log(data);
            document.querySelector('.token').value = token
            validationError('document', errors)

            if (status == 1) {
                document.querySelector('#nextBtn').classList.remove('disabled')
                document.querySelector('#attachments').innerHTML = attachments
                attachmentForm.reset()
                progressBar.style.width = 0 + '%'
                progressBar.textContent = 0 + '%'
                progress.style.display = 'none'
                $('#attachmentModel').modal('hide')
                swal({
                    title: msg,
                    icon: "success",
                });
            } 



        }
        xhr.send(formData)

    })

    function editAttachment(id) {

        document.querySelector('#id').value = id
        const csrf_hash = document.querySelector('.token').value



        fetch('editAttachment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    "X-Requested-With": "XMLHttpRequest"
                },

                body: JSON.stringify({
                    id,
                    csrf_hash
                }),

            }).then(response => response.json())
            .then(data => {
                document.querySelector('.token').value = data.token
                const {
                    status,
                    token,
                    documentName
                } = data
                if (status == 1) {
                    $("#docName").val(documentName).change();
                    $('#attachmentModelEdit').modal({
                        show: true
                    })
                }
                console.log(data)
            })
    }


    const attachmentFormEdit = document.querySelector('#attachmentFormEdit')
    attachmentFormEdit.addEventListener('submit', e => {

        e.preventDefault()

        const formData = new FormData(attachmentFormEdit)
        const progressEdit = document.querySelector('.progressEdit')
        const progressBarEdit = document.querySelector('.progress-barEdit')
        progressEdit.style.display = 'block'


        // formData.append('document', document.querySelector('#file').files[0])
        formData.append('csrf_hash', document.querySelector('.token').value)

        let xhr = new XMLHttpRequest()
        xhr.open('POST', 'updateAttachment')
        xhr.upload.addEventListener('progress', ({
            loaded,
            total
        }) => {
            const uploadedData = Math.floor((loaded / total) * 100)
            progressBarEdit.style.width = uploadedData + '%'
            progressBarEdit.textContent = uploadedData + '%'

            console.log('uploadedData' + uploadedData)

        })
        xhr.onload = function() {
            const data = JSON.parse(this.response)
            //console.log(data)
            const {
                status,
                token,
                attachments,
                msg
            } = data
            document.querySelector('.token').value = token
            // validationError('document', errors)

            if (status == 1) {
                document.querySelector('#attachments').innerHTML = attachments
                attachmentFormEdit.reset()
                progressBarEdit.style.width = 0 + '%'
                progressBarEdit.textContent = 0 + '%'
                // progressEdit.style.display = 'none'
                $('#attachmentModelEdit').modal('hide')
                swal({
                    title: msg,
                    icon: "success",
                });
            }



        }
        xhr.send(formData)
    })




    //<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.0.279/pdf.worker.min.js" integrity="sha512-UiXicZonl1pXJaZk0apG3TN/yE/a52JjAyZmr1MmvjI01f7MURJD+M4UUdBxxz1Zzte1zjie37VtotaR3b1/1g==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.0.279/pdf.min.js" integrity="sha512-QJy1NRNGKQoHmgJ7v+45V2uDbf2me+xFoN9XewaSKkGwlqEHyqLVaLtVm93FzxVCKnYEZLFTI4s6v0oD0FbAlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.0.279/pdf.worker.min.js" integrity="sha512-UiXicZonl1pXJaZk0apG3TN/yE/a52JjAyZmr1MmvjI01f7MURJD+M4UUdBxxz1Zzte1zjie37VtotaR3b1/1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script src="<?= base_url() ?>/ServiceApplication/assets/js/pdfjs-dist/build/pdf.worker.js"></script>
<script src="<?= base_url() ?>/ServiceApplication/assets/js/pdfjs-dist/build/pdf.js"></script>



<?= $this->endSection(); ?>