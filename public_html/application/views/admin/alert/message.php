<!-- message.php -->
<?php if ($this->session->flashdata('success_message')): ?>
    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Sukses!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="checkmark-container">
                        <img src="<?php echo base_url('assets/img/checkmark.png'); ?>" alt="Checkmark" class="img-fluid checkmark">
                    </div>
                    <p><?php echo $this->session->flashdata('success_message'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
<?php endif; ?>


<?php if ($this->session->flashdata('error_message')): ?>
    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Error!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="checkmark-container">
                        <img src="<?php echo base_url('assets/img/cross.png'); ?>" alt="Checkmark" class="img-fluid checkmark">
                    </div>
                    <p><?php echo $this->session->flashdata('error_message'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
<?php endif; ?>

