@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4>{{ $page->title }}</h4>
                    </div>
                    <form method="POST" action="#">
                        @csrf

                        <!-- 1. Penetapan -->
                        <div class="row mx-1 mt-3 border-bottom pb-3">
                            <div class="col-md-9">
                                <h6 class="font-weight-bold">1. Penetapan</h6>
                                <textarea id="editor-penetapan" name="penetapan_konten" class="form-control"></textarea>
                            </div>
                            <div class="col-md-3 d-flex align-items-start justify-content-end pt-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="fas fa-upload"></i> Upload Gambar
                                        </button>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Dokumen</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Uploaded files will appear here -->
                                                    <tr>
                                                        <td colspan="2" class="text-center">Belum ada dokumen</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Pelaksanaan -->
                        <div class="row mx-1 mt-3 border-bottom pb-3">
                            <div class="col-md-9">
                                <h6 class="font-weight-bold">2. Pelaksanaan</h6>
                                <textarea id="editor-pelaksanaan" name="pelaksanaan_konten" class="form-control"></textarea>
                            </div>
                            <div class="col-md-3 d-flex align-items-start justify-content-end pt-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="fas fa-upload"></i> Upload Gambar
                                        </button>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Dokumen</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" class="text-center">Belum ada dokumen</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Evaluasi -->
                        <div class="row mx-1 mt-3 border-bottom pb-3">
                            <div class="col-md-9">
                                <h6 class="font-weight-bold">3. Evaluasi</h6>
                                <textarea id="editor-evaluasi" name="evaluasi_konten" class="form-control"></textarea>
                            </div>
                            <div class="col-md-3 d-flex align-items-start justify-content-end pt-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="fas fa-upload"></i> Upload Gambar
                                        </button>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Dokumen</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" class="text-center">Belum ada dokumen</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Pengendalian -->
                        <div class="row mx-1 mt-3 border-bottom pb-3">
                            <div class="col-md-9">
                                <h6 class="font-weight-bold">4. Pengendalian</h6>
                                <textarea id="editor-pengendalian" name="pengendalian_konten" class="form-control"></textarea>
                            </div>
                            <div class="col-md-3 d-flex align-items-start justify-content-end pt-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="fas fa-upload"></i> Upload Gambar
                                        </button>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Dokumen</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" class="text-center">Belum ada dokumen</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Peningkatan -->
                        <div class="row mx-1 mt-3 pb-3">
                            <div class="col-md-9">
                                <h6 class="font-weight-bold">5. Peningkatan</h6>
                                <textarea id="editor-peningkatan" name="peningkatan_konten" class="form-control"></textarea>
                            </div>
                            <div class="col-md-3 d-flex align-items-start justify-content-end pt-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="fas fa-upload"></i> Upload Gambar
                                        </button>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Dokumen</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" class="text-center">Belum ada dokumen</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Left side buttons -->
                                <div>
                                    <button type="reset" class="btn btn-outline-secondary me-2" onclick="resetForm()">
                                        <i class="fas fa-undo-alt me-1"></i> Reset Form
                                    </button>
                                    <a href="#" class="btn btn-outline-danger">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                </div>

                                <!-- Right side buttons -->
                                <div>
                                    <button type="button" class="btn btn-outline-primary me-2" onclick="saveDraft()">
                                        <i class="fas fa-save me-1"></i> Save Draft
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-paper-plane me-1"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .tox-tinymce {
            border-radius: 8px !important;
            border: 1px solid #d2d6da !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all TinyMCE editors
            ['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'].forEach(section => {
                tinymce.init({
                    selector: `#editor-${section}`,
                    plugins: 'lists link',
                    toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link',
                    height: 250,
                    menubar: false,
                    branding: false,
                    image_advtab: true,
                    relative_urls: false,
                    remove_script_host: false,
                    setup: function(editor) {
                        editor.on('change', function() {
                            editor.save();
                        });
                    }
                });
            });

            // Upload button functionality (example)
            document.querySelectorAll('[type="button"]').forEach(button => {
                button.addEventListener('click', function() {
                    // Implement your file upload logic here
                    console.log('Upload button clicked for section');
                });
            });
        });
    </script>
@endpush
