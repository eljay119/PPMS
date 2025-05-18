@if (session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
            style="background-color: #d4edda; border: 1px solid #c3e6cb;">
            <div class="toast-header" style="background-color: #d4edda;">
                <img src="/img/bisu.png" class="rounded me-2" alt="Logo" style="width: 20px; height: 20px;">
                <strong class="me-auto">Success</strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" style="background-color: #d4edda; color: #155724;">
                {{ session('success') }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successToast = new bootstrap.Toast(document.getElementById('successToast'));
            successToast.show();
        });
    </script>
@endif
