<style>
    .fade-in {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
    .fade-in.show {
        opacity: 1;
    }
</style>

<footer class="footer mt-3 text-white">
    <div class="text-center">
        <p>Website Design By
            @if(Request::is('backend/register'))
                {{-- <button id="debugModeBtn" style="background: none; border: none; color: inherit; font-weight: bold; padding: 0; cursor: default">
                    Mahasiswa UBSI
                </button> --}}
                <span style="font-weight: bold">Mahasiswa UBSI</span>
            @else
                <span style="font-weight: bold">Mahasiswa UBSI</span>
            @endif
        </p>
    </div>
</footer>

<!-- Modal Debug Password (letakkan di layout utama jika perlu) -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="passwordModalLabel">Masukkan Password Debug</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="alertWrongPassword" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                <strong> Password salah!</strong> Silakan coba lagi.
            </div>
                <input type="password" id="passwordInputDebug" class="form-control" placeholder="Password Debug">
            </div>
            <div class="modal-footer">
                <button type="button" id="submitPassword" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Password yang benar dari backend
    const correctPassword = @json($passDebug ?? '');

    // Tombol untuk memunculkan modal password
    document.getElementById("debugModeBtn").addEventListener("click", function() {
        document.getElementById("alertWrongPassword").style.display = "none";
        document.getElementById("passwordInputDebug").value = "";
        $('#passwordModal').modal('show');
    });

    // Tombol submit untuk mengecek password
    document.getElementById("submitPassword").addEventListener("click", function() {
        const passwordInputDebug = document.getElementById("passwordInputDebug").value;
        if (passwordInputDebug === correctPassword) {
            const debugContent = document.getElementById("debugContent");
            debugContent.style.display = "block";
            setTimeout(() => {
                debugContent.classList.add("show");
            }, 10);
            $('#passwordModal').modal('hide');
            document.getElementById("debugModeBtn").ariaDisabled = true;
            document.getElementById("debugModeBtn").style.pointerEvents = "none";
            document.getElementById("debugModeBtn").style.cursor = "not-allowed";
        } else {
            document.getElementById("alertWrongPassword").style.display = "block";
        }
    });

    // Tombol untuk mematikan mode debug
    document.getElementById("turnOffDebugBtn")?.addEventListener("click", function() {
        const debugContent = document.getElementById("debugContent");
        const roleUnchange = document.getElementById("role");
        debugContent.classList.remove("show");
        if (roleUnchange) roleUnchange.value = 0;
        setTimeout(() => {
            debugContent.style.display = "none";
        }, 500);
        document.getElementById("debugModeBtn").ariaDisabled = false;
        document.getElementById("debugModeBtn").style.pointerEvents = "auto";
        document.getElementById("debugModeBtn").style.cursor = "default";
    });
</script>

<!-- Bootstrap JS, Popper.js, dan jQuery -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
