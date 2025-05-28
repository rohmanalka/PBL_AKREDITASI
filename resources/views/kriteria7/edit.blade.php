@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4>{{ $page->title }}</h4>
                    </div>
                    <form id="formPPEPP" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_kriteria" value="{{ auth()->user()->role->id_kriteria }}">
                        <!-- 1. Penetapan -->
                        <div class="row mx-1 mt-3 border-bottom pb-3">
                            <div class="col-md-9">
                                <h6 class="font-weight-bold">1. {{ __('messages.penetapan') }}</h6>
                                <textarea id="editor-penetapan" name="penetapan" class="form-control">
                                    {!! old('penetapan', $detail->penetapan->penetapan ?? '') !!}
                                </textarea>
                            </div>  
                            <div class="col-md-3 d-flex align-items-start justify-content-end pt-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <label class="btn btn-outline-primary btn-sm mb-2" for="input-penetapan">
                                            <i class="fas fa-upload"></i> {{ __('messages.upload_gambar') }}
                                        </label>
                                        <input type="file" id="input-penetapan" name="penetapan_file"
                                            class="form-control mt-2 d-none" accept="image/*"
                                            onchange="previewAndInsertImage(this, 'editor-penetapan', 'penetapan')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Pelaksanaan -->
                        <div class="row mx-1 mt-3 border-bottom pb-3">
                            <div class="col-md-9">
                                <h6 class="font-weight-bold">2. {{ __('messages.pelaksanaan') }}</h6>
                                <textarea id="editor-pelaksanaan" name="pelaksanaan" class="form-control">
                                    {!! old('pelaksanaan', $detail->pelaksanaan->pelaksanaan ?? '') !!}
                                </textarea>
                            </div>
                            <div class="col-md-3 d-flex align-items-start justify-content-end pt-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <label class="btn btn-outline-primary btn-sm mb-2" for="input-pelaksanaan">
                                            <i class="fas fa-upload"></i> {{ __('messages.upload_gambar') }}
                                        </label>
                                        <input type="file" id="input-pelaksanaan" name="pelaksanaan_file"
                                            class="form-control mt-2 d-none" accept="image/*"
                                            onchange="previewAndInsertImage(this, 'editor-pelaksanaan', 'pelaksanaan')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Evaluasi -->
                        <div class="row mx-1 mt-3 border-bottom pb-3">
                            <div class="col-md-9">
                                <h6 class="font-weight-bold">3. {{ __('messages.evaluasi') }}</h6>
                                <textarea id="editor-evaluasi" name="evaluasi" class="form-control">
                                    {!! old('evaluasi', $detail->evaluasi->evaluasi ?? '') !!}
                                </textarea>
                            </div>
                            <div class="col-md-3 d-flex align-items-start justify-content-end pt-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <label class="btn btn-outline-primary btn-sm mb-2" for="input-evaluasi">
                                            <i class="fas fa-upload"></i> {{ __('messages.upload_gambar') }}
                                        </label>
                                        <input type="file" id="input-evaluasi" name="evaluasi_file"
                                            class="form-control mt-2 d-none" accept="image/*"
                                            onchange="previewAndInsertImage(this, 'editor-evaluasi', 'evaluasi')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Pengendalian -->
                        <div class="row mx-1 mt-3 border-bottom pb-3">
                            <div class="col-md-9">
                                <h6 class="font-weight-bold">4. {{ __('messages.pengendalian') }}</h6>
                                <textarea id="editor-pengendalian" name="pengendalian" class="form-control">
                                    {!! old('pengendalian', $detail->pengendalian->pengendalian ?? '') !!}
                                </textarea>
                            </div>
                            <div class="col-md-3 d-flex align-items-start justify-content-end pt-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <label class="btn btn-outline-primary btn-sm mb-2" for="input-pengendalian">
                                            <i class="fas fa-upload"></i> {{ __('messages.upload_gambar') }}
                                        </label>
                                        <input type="file" id="input-pengendalian" name="pengendalian_file"
                                            class="form-control mt-2 d-none" accept="image/*"
                                            onchange="previewAndInsertImage(this, 'editor-pengendalian', 'pengendalian')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Peningkatan -->
                        <div class="row mx-1 mt-3 pb-3">
                            <div class="col-md-9">
                                <h6 class="font-weight-bold">5. {{ __('messages.peningkatan') }}</h6>
                                <textarea id="editor-peningkatan" name="peningkatan" class="form-control">
                                    {!! old('peningkatan', $detail->peningkatan->peningkatan ?? '') !!}
                                </textarea>
                            </div>
                            <div class="col-md-3 d-flex align-items-start justify-content-end pt-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <label class="btn btn-outline-primary btn-sm mb-2" for="input-peningkatan">
                                            <i class="fas fa-upload"></i> {{ __('messages.upload_gambar') }}
                                        </label>
                                        <input type="file" id="input-peningkatan" name="peningkatan_file"
                                            class="form-control mt-2 d-none" accept="image/*"
                                            onchange="previewAndInsertImage(this, 'editor-peningkatan', 'peningkatan')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Left side buttons -->
                                <div>
                                    <button type="reset" class="btn btn-outline-secondary me-2" onclick="resetForm()">
                                        <i class="fas fa-undo-alt me-1"></i> {{ __('messages.reset') }}
                                    </button>
                                    <a href="{{ url('kriteria7/') }}" class="btn btn-outline-danger">
                                        <i class="fas fa-times me-1"></i> {{ __('messages.cancel') }}
                                    </a>
                                </div>

                                <!-- Right side buttons -->
                                <div>
                                    <input type="hidden" name="status" id="statusInput" value="">

                                    <button type="button" class="btn btn-outline-primary me-2"
                                        onclick="submitForm('save')">
                                        <i class="fas fa-save me-1"></i> {{ __('messages.save') }}
                                    </button>

                                    <button type="button" class="btn btn-primary" id="submitBtn"
                                        onclick="submitForm('submit')">
                                        <i class="fas fa-paper-plane me-1"></i> {{ __('messages.submit') }}
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

@section('script')
    <script src="{{ asset('tinymce\js\tinymce\tinymce.min.js') }}"></script>
    <script src="{{ asset('tinymce\js\tinymce\icons\default\icons.min.js') }}"></script>

    <script type='text/javascript'>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof tinymce !== 'undefined') {
                // Inisialisasi untuk semua section
                ['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'].forEach(section => {
                    tinymce.init({
                        selector: `#editor-${section}`,
                        height: 400,
                        plugins: 'link',
                        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | link',
                        branding: false,
                    });
                });
            } else {
                console.error('TinyMCE tidak terdefinisi!');
                // Fallback ke textarea biasa untuk semua editor
                ['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'].forEach(section => {
                    const editor = document.getElementById(`editor-${section}`);
                    if (editor) {
                        editor.style.display = 'block';
                        editor.style.minHeight = '200px';
                    }
                });
            }
        });

        function previewAndInsertImage(input, targetId, section) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('image', input.files[0]);
                formData.append('section', section);

                fetch("{{ url('kriteria7/upload') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status) {
                            const url = data.url; // URL gambar yang disimpan di server

                            // Sisipkan ke TinyMCE
                            const editor = tinymce.get(targetId);
                            if (editor) {
                                editor.insertContent(`<img src="${url}" style="max-width:100%;"/>`);
                            }

                            // Tampilkan preview jika ingin
                            const preview = document.getElementById(`preview-${targetId}`);
                            if (preview) {
                                preview.src = url;
                                preview.style.display = 'block';
                            }
                        } else {
                            Swal.fire('Gagal Upload', data.message || 'Gagal mengunggah gambar.', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Terjadi kesalahan saat mengunggah gambar.', 'error');
                    });
            }
        }

        // function previewAndInsertImage(input, targetId, section) {
        //     if (input.files && input.files[0]) {
        //         const formData = new FormData();
        //         formData.append('image', input.files[0]);
        //         formData.append('section', section);

        //         fetch("{{ url('kriteria7/upload') }}", {
        //                 method: "POST",
        //                 headers: {
        //                     'X-CSRF-TOKEN': "{{ csrf_token() }}",
        //                     'Accept': 'application/json',
        //                 },
        //                 body: formData
        //             })
        //             .then(res => res.json())
        //             .then(data => {
        //                 if (data.status) {
        //                     const url = data.url;

        //                     // Hanya tampilkan preview (tidak insert ke TinyMCE)
        //                     const preview = document.getElementById(`preview-${targetId}`);
        //                     if (preview) {
        //                         preview.src = url;
        //                         preview.style.display = 'block';
        //                     }
        //                 } else {
        //                     Swal.fire('Gagal Upload', data.message || 'Gagal mengunggah gambar.', 'error');
        //                 }
        //             })
        //             .catch(err => {
        //                 console.error(err);
        //                 Swal.fire('Error', 'Terjadi kesalahan saat mengunggah gambar.', 'error');
        //             });
        //     }
        // }

        function submitForm(status) {
            // pastikan semua TinyMCE disimpan
            if (typeof tinymce !== 'undefined') {
                ['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'].forEach(sec => {
                    const ed = tinymce.get(`editor-${sec}`);
                    if (ed) ed.save();
                });
            }

            const form = document.getElementById('formPPEPP');
            const formData = new FormData(form);

            formData.set('status', status);
            document.getElementById('statusInput').value = status;

            formData.append('_method', 'PUT');
            fetch("{{ url('kriteria7/' . $detail->id_detail_kriteria . '/update') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData
                })
                .then(async res => {
                    const ct = res.headers.get('content-type') || '';
                    // jika status bukan 2xx
                    if (!res.ok) {
                        const text = await res.text();
                        console.error('Server returned HTTP', res.status, text);
                        throw new Error(`Server error ${res.status}`);
                    }
                    // jika bukan JSON
                    if (!ct.includes('application/json')) {
                        const text = await res.text();
                        console.error('Expected JSON, got:', text);
                        throw new Error('Invalid JSON response');
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.status) {
                        Swal.fire({
                            title: 'Sukses!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ url('kriteria7') }}";
                        });
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    Swal.fire('Error', err.message, 'error');
                });
        }
    </script>
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
@endpush
