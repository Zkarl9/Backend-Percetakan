@extends('layouts.app')

@section('title', 'Produk')

@section('content')

<style>
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-slide-up {
        animation: slideInUp 0.5s ease-out;
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    .animate-scale-in {
        animation: scaleIn 0.3s ease-out;
    }

    .gradient-bg {
        background: linear-gradient(135deg, #ec4899 0%, #f472b6 50%, #fbbf24 100%);
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .btn-gradient {
        background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        background: linear-gradient(135deg, #db2777 0%, #ec4899 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(236, 72, 153, 0.5);
    }

    .image-preview-hover {
        position: relative;
        overflow: hidden;
    }

    .image-preview-hover::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s;
    }

    .image-preview-hover:hover::after {
        left: 100%;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .modal-backdrop {
        backdrop-filter: blur(8px);
        animation: fadeIn 0.3s ease-out;
    }

    .modal-content {
        animation: scaleIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-modern {
        transition: all 0.3s ease;
    }

    .input-modern:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(236, 72, 153, 0.2);
    }

    .table-row-hover {
        transition: all 0.2s ease;
    }

    .table-row-hover:hover {
        background: linear-gradient(90deg, rgba(236, 72, 153, 0.05) 0%, rgba(244, 114, 182, 0.05) 100%);
        transform: scale(1.01);
    }

    .icon-bounce {
        transition: transform 0.3s ease;
    }

    .icon-bounce:hover {
        transform: scale(1.2) rotate(10deg);
    }

    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }

    .preview-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .preview-item:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .gradient-text {
        background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .pulse-border {
        animation: pulse-border 2s ease-in-out infinite;
    }

    @keyframes pulse-border {
        0%, 100% {
            border-color: rgba(236, 72, 153, 0.5);
        }
        50% {
            border-color: rgba(236, 72, 153, 1);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing product and file handlers...');

    window.fileHandler = {
        maxFiles: 4,
        validTypes: [
            'image/jpeg', 'image/png', 'image/jpg', 'image/gif',
            'image/bmp', 'image/webp', 'image/svg+xml'
        ],
        maxSize: 2 * 1024 * 1024,

        validateFile: function(input) {
            if (!input.files || input.files.length === 0) return true;

            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                if (!this.validTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: `File ${file.name} harus berupa gambar yang valid.`,
                        confirmButtonColor: '#ec4899'
                    });
                    input.value = '';
                    return false;
                }

                if (file.size > this.maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: `File ${file.name} tidak boleh lebih dari 2MB`,
                        confirmButtonColor: '#ec4899'
                    });
                    input.value = '';
                    return false;
                }
            }
            return true;
        }
    };

    window.productHandler = {
        
        handleFileChange: function(input, previewContainerId) {
            const container = document.getElementById(previewContainerId);
            const groupId = input.closest('.file-input-group').getAttribute('data-group-id');
            const previewId = `preview-${groupId}`;
            let previewElement = document.getElementById(previewId);
            
            if (previewElement) {
                previewElement.remove();
            }

            if (fileHandler.validateFile(input) && input.files && input.files[0]) {
                const file = input.files[0];
                
                const previewWrapper = document.createElement('div');
                previewWrapper.id = previewId;
                previewWrapper.className = 'preview-item animate-scale-in';

                const img = document.createElement('img');
                img.className = 'w-full h-full object-cover';
                img.alt = 'Preview Gambar';

                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);

                previewWrapper.appendChild(img);
                
                const inputGroup = input.closest('.file-input-group');
                if (inputGroup) {
                    if (previewContainerId === 'preview-container-add') {
                         container.appendChild(previewWrapper);
                    } else {
                        inputGroup.after(previewWrapper);
                    }
                }
            } else {
                if (previewElement) {
                    previewElement.remove();
                }
            }

            this.updateFileInputs(input.closest('form').id === 'addForm' ? 'add' : 'edit');
        },

        showAddModal: function() {
            document.getElementById('preview-container-add').innerHTML = '';
            document.getElementById('upload-container-add').innerHTML = '';
            this.addFileInput('add');
            document.getElementById('addModal').classList.remove('hidden');
        },

        closeAddModal: function() {
            const modal = document.getElementById('addModal');
            const form = document.getElementById('addForm');
            form.reset();
            document.getElementById('preview-container-add').innerHTML = '';
            document.getElementById('upload-container-add').innerHTML = '';
            modal.classList.add('hidden');
        },

        submitAdd: async function() {
             try {
                const form = document.getElementById('addForm');
                
                const fileInputs = form.querySelectorAll('#upload-container-add input[type="file"]');
                for(let input of fileInputs) {
                     if (!fileHandler.validateFile(input)) {
                         return;
                     }
                }

                const formData = new FormData(form);
                
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                let data;
                try {
                    data = await response.json();
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    throw new Error('Server mengembalikan response yang tidak valid');
                }

                if (!response.ok) {
                    throw new Error(data.message || 'Terjadi kesalahan pada server');
                }

                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Produk berhasil ditambahkan',
                        timer: 1500,
                        showConfirmButton: false,
                        confirmButtonColor: '#ec4899'
                    });
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan saat menyimpan data');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message,
                    confirmButtonColor: '#ec4899'
                });
            }
        },

        showEditModal: async function(id, nama, kategori, harga, deskripsi) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const previewContainer = document.getElementById('preview-container-edit');
            const kategoriSelect = document.getElementById('edit_kategori');

            form.action = `/produk/${id}`;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_deskripsi').value = deskripsi;
            kategoriSelect.value = kategori;

            previewContainer.innerHTML = '';
            document.getElementById('upload-container-edit').innerHTML = '';
            form.querySelectorAll('input[name="deleted_images[]"]').forEach(input => input.remove());

            try {
                const response = await fetch(`/produk/${id}/image`);
                const data = await response.json();

                if (data.images && data.images.length > 0) {
                    data.images.forEach((image, index) => {
                        const previewWrapper = document.createElement('div');
                        previewWrapper.className = 'preview-item relative group existing-image animate-scale-in';

                        const preview = document.createElement('img');
                        preview.className = 'w-full h-full object-cover';
                        preview.src = image.url;
                        preview.alt = `Gambar ${index + 1}`;

                        const deleteBtn = document.createElement('button');
                        deleteBtn.type = 'button';
                        deleteBtn.className = 'absolute top-2 right-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg z-10 transform hover:scale-110';
                        deleteBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                        deleteBtn.onclick = (e) => {
                            e.preventDefault();
                            this.handleImageDelete(form, image.path, previewWrapper);
                        };

                        previewWrapper.appendChild(preview);
                        previewWrapper.appendChild(deleteBtn);
                        previewContainer.appendChild(previewWrapper);
                    });
                }
            } catch (error) {
                console.error('Error fetching images:', error);
            }
            
            this.addFileInput('edit'); 
            this.updateFileInputs('edit');

            modal.classList.remove('hidden');
        },

        handleImageDelete: function(form, imagePath, previewElement) {
            Swal.fire({
                title: 'Hapus Gambar?',
                text: "Gambar akan dihapus saat menyimpan perubahan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ec4899',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const deletedImagesInput = document.createElement('input');
                    deletedImagesInput.type = 'hidden';
                    deletedImagesInput.name = 'deleted_images[]';
                    deletedImagesInput.value = imagePath;
                    form.appendChild(deletedImagesInput);
                    previewElement.remove();
                    this.updateFileInputs('edit');
                    
                    console.log('Image marked for deletion:', imagePath);
                }
            });
        },

        closeEditModal: function() {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            form.reset();
            modal.classList.add('hidden');
        },

        submitEdit: async function() {
            const form = document.getElementById('editForm');
            const formData = new FormData(form);

            const fileInputs = form.querySelectorAll('#upload-container-edit input[type="file"]');
            for(let input of fileInputs) {
                 if (!fileHandler.validateFile(input)) {
                     return;
                 }
            }
            
            try {
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                formData.append('_method', 'PUT');

                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Produk berhasil diperbarui',
                        timer: 1500,
                        showConfirmButton: false,
                        confirmButtonColor: '#ec4899'
                    });
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message,
                    confirmButtonColor: '#ec4899'
                });
            }
        },

        confirmDelete: function(id) {
             Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Produk yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ec4899',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/produk/${id}`;
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    
                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        },
        
        addFileInput: function(type) {
            const container = document.getElementById(`upload-container-${type}`);
            
            let existingImagesCount = 0;
            if (type === 'edit') {
                 existingImagesCount = document.querySelectorAll('#preview-container-edit .existing-image:not(.removed-image)').length;
            }
            
            const currentNewInputs = container.querySelectorAll('input[type="file"]').length;
            const totalImages = existingImagesCount + currentNewInputs;

            if (totalImages >= fileHandler.maxFiles) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: `Maksimal ${fileHandler.maxFiles} gambar yang diizinkan (termasuk yang sudah ada)`,
                    confirmButtonColor: '#ec4899'
                });
                return;
            }

            const groupId = `input-${Date.now()}`;

            const inputGroup = document.createElement('div');
            inputGroup.className = 'flex items-center gap-3 file-input-group p-3 rounded-lg border-2 border-dashed border-pink-200 hover:border-pink-400 transition-all duration-300 animate-slide-up';
            inputGroup.setAttribute('data-group-id', groupId);
            
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'gambar[]';
            input.accept = fileHandler.validTypes.join(',');
            input.className = 'input-modern block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-pink-500 file:to-pink-600 file:text-white hover:file:from-pink-600 hover:file:to-pink-700 file:transition-all file:duration-300 file:cursor-pointer';
            
            input.onchange = () => {
                this.handleFileChange(input, `preview-container-${type}`);
            };

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition-all duration-300 icon-bounce';
            removeBtn.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
            removeBtn.onclick = () => {
                inputGroup.remove();
                
                const previewElement = document.getElementById(`preview-${groupId}`);
                if (previewElement) {
                    previewElement.remove();
                }

                this.updateFileInputs(type); 
            };

            inputGroup.appendChild(input);
            inputGroup.appendChild(removeBtn);
            container.appendChild(inputGroup);
            
            this.updateFileInputs(type);
        },

        updateFileInputs: function(type) {
            const container = document.getElementById(`upload-container-${type}`);
            
            let existingImagesCount = 0;
            if (type === 'edit') {
                 existingImagesCount = document.querySelectorAll('#preview-container-edit .existing-image').length;
            }
            const newImagePreviewsCount = document.querySelectorAll(`#preview-container-${type} .preview-item`).length;
            const currentNewInputs = container.querySelectorAll('.file-input-group').length;
            
            const totalImages = existingImagesCount + newImagePreviewsCount;
            
            const addButton = document.querySelector(`button[onclick*="productHandler.addFileInput('${type}')"]`);
            
            if (addButton) {
                if (totalImages >= fileHandler.maxFiles) {
                    addButton.disabled = true;
                    addButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    addButton.disabled = false;
                    addButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
            
             if (type === 'add' && currentNewInputs === 0) {
                 this.addFileInput('add');
             }
        }
    };

    window.onclick = function(event) {
        const addModal = document.getElementById('addModal');
        const editModal = document.getElementById('editModal');
        if (event.target === addModal) {
            productHandler.closeAddModal();
        }
        if (event.target === editModal) {
            productHandler.closeEditModal();
        }
    };
    
    productHandler.addFileInput('add');
});
</script>

<!-- Header dengan Gradient Background -->
<div class="gradient-bg py-16 px-6 mb-8 rounded-3xl shadow-2xl animate-slide-up">
    <div class="container mx-auto text-center">
        <h1 class="text-5xl font-bold text-white mb-4 floating">🎨 Manajemen Produk</h1>
        <p class="text-white text-lg opacity-90">Kelola produk Anda dengan mudah dan elegan</p>
    </div>
</div>

<div class="container mx-auto px-6 pb-12">
    <!-- Card Container dengan Glass Effect -->
    <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden animate-scale-in">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-pink-50 to-purple-50 p-6 border-b-4 border-pink-300">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold gradient-text mb-2">📦 Daftar Produk</h2>
                    <p class="text-gray-600">Total: <span class="font-semibold text-pink-600">{{ count($produk) }}</span> produk</p>
                </div>
                <button onclick="productHandler.showAddModal()" class="btn-gradient text-white px-8 py-4 rounded-2xl text-base font-semibold shadow-lg flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Produk
                </button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-pink-100 to-purple-100">
                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-700 uppercase tracking-wider rounded-tl-2xl">No</th>
                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Harga</th>
                            <th class="px-8 py-5 text-center text-sm font-bold text-gray-700 uppercase tracking-wider rounded-tr-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y-2 divide-gray-100">
                        @forelse($produk as $index => $item)
                        <tr class="table-row-hover">
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-pink-400 to-purple-400 text-white font-bold shadow-md">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center text-2xl">
                                        🏷️
                                    </div>
                                    <span class="text-base font-semibold text-gray-800">{{ $item->nama }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="status-badge bg-gradient-to-r from-pink-400 to-purple-400 text-white shadow-md">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-lg font-bold text-pink-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center gap-3">
                                    <button type="button" 
                                            onclick="productHandler.showEditModal('{{ $item->id }}', '{{ $item->nama }}', '{{ $item->kategori }}', '{{ $item->harga }}', '{{ $item->deskripsi }}')" 
                                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl icon-bounce" 
                                            title="Edit Produk">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button type="button" 
                                            onclick="productHandler.confirmDelete('{{ $item->id }}')" 
                                            class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white p-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl icon-bounce" 
                                            title="Hapus Produk">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-24 h-24 bg-gradient-to-br from-pink-100 to-purple-100 rounded-full flex items-center justify-center text-5xl">
                                        📦
                                    </div>
                                    <p class="text-xl font-semibold text-gray-600">Belum ada produk</p>
                                    <p class="text-gray-500">Tambahkan produk pertama Anda!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH PRODUK -->
<div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center px-4 py-8">
        <div class="modal-backdrop fixed inset-0 bg-gradient-to-br from-pink-900/50 to-purple-900/50" aria-hidden="true"></div>
        
        <div class="modal-content relative transform overflow-hidden rounded-3xl bg-white shadow-2xl transition-all w-full max-w-4xl">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-pink-500 to-purple-500 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-3xl">
                        ➕
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-white">Tambah Produk Baru</h3>
                        <p class="text-pink-100 mt-1">Isi informasi produk dengan lengkap</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-8 py-6 max-h-[70vh] overflow-y-auto">
                <form id="addForm" action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Preview Gambar Section -->
                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-2xl p-6 border-2 border-pink-200">
                        <label class="block text-gray-800 font-bold mb-4 flex items-center gap-2 text-lg">
                            <span class="text-2xl">🖼️</span>
                            Preview Gambar
                        </label>
                        <div id="preview-container-add" class="preview-grid mb-6">
                            <!-- New image previews will appear here -->
                        </div>
                        
                        <label class="block text-gray-700 font-semibold mb-3">Upload Gambar (Maksimal 4)</label>
                        <div id="upload-container-add" class="space-y-3 mb-4">
                            <!-- File inputs will be added here -->
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="button" onclick="productHandler.addFileInput('add')" class="bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Gambar
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-3 flex items-center gap-2">
                            <span>ℹ️</span>
                            Format: JPG, JPEG, PNG, GIF, BMP, WEBP, SVG (Maks. 2MB per file)
                        </p>
                    </div>

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Produk -->
                        <div class="md:col-span-2">
                            <label for="add_nama" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-xl">📝</span>
                                Nama Produk
                            </label>
                            <input type="text" 
                                   name="nama" 
                                   id="add_nama" 
                                   class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:ring-4 focus:ring-pink-200 px-4 py-3 transition-all duration-300" 
                                   placeholder="Masukkan nama produk..."
                                   required>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="add_kategori" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-xl">📂</span>
                                Kategori
                            </label>
                            <select name="kategori" 
                                    id="add_kategori" 
                                    class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:ring-4 focus:ring-pink-200 px-4 py-3 transition-all duration-300" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                <option value="Percetakan">🖨️ Percetakan</option>
                                <option value="Konveksi">👕 Konveksi</option>
                                <option value="Kebutuhan Sekolah & Perusahaan">🏢 Kebutuhan Sekolah & Perusahaan</option>
                                <option value="Fasilitas">🏭 Fasilitas</option>
                            </select>
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="add_harga" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-xl">💰</span>
                                Harga
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <span class="text-gray-500 font-semibold">Rp</span>
                                </div>
                                <input type="number" 
                                       name="harga" 
                                       id="add_harga" 
                                       class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:ring-4 focus:ring-pink-200 pl-12 pr-4 py-3 transition-all duration-300" 
                                       placeholder="0"
                                       required>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label for="add_deskripsi" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-xl">📄</span>
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" 
                                      id="add_deskripsi" 
                                      rows="4" 
                                      class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:ring-4 focus:ring-pink-200 px-4 py-3 transition-all duration-300" 
                                      placeholder="Deskripsikan produk Anda..."
                                      required></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-8 py-6 flex justify-end gap-3 border-t-2 border-gray-100">
                <button type="button" 
                        onclick="productHandler.closeAddModal()" 
                        class="px-8 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg">
                    Batal
                </button>
                <button type="button" 
                        onclick="productHandler.submitAdd()" 
                        class="btn-gradient text-white px-8 py-3 rounded-xl font-semibold shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tambah Produk
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT PRODUK -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center px-4 py-8">
        <div class="modal-backdrop fixed inset-0 bg-gradient-to-br from-blue-900/50 to-purple-900/50" aria-hidden="true"></div>
        
        <div class="modal-content relative transform overflow-hidden rounded-3xl bg-white shadow-2xl transition-all w-full max-w-4xl">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-3xl">
                        ✏️
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-white">Edit Produk</h3>
                        <p class="text-blue-100 mt-1">Perbarui informasi produk Anda</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-8 py-6 max-h-[70vh] overflow-y-auto">
                <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Gambar Section -->
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-6 border-2 border-blue-200">
                        <label class="block text-gray-800 font-bold mb-4 flex items-center gap-2 text-lg">
                            <span class="text-2xl">🖼️</span>
                            Gambar Produk Saat Ini
                        </label>
                        <div id="preview-container-edit" class="preview-grid mb-6">
                            <!-- Existing images will be loaded here -->
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-gray-700 font-semibold mb-3">Upload Gambar Baru (Maksimal 4 total)</label>
                            <div id="upload-container-edit" class="space-y-3 mb-4">
                                <!-- File inputs will be added here -->
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="button" onclick="productHandler.addFileInput('edit')" class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Gambar Baru
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-3 flex items-center gap-2">
                                <span>ℹ️</span>
                                Format: JPG, JPEG, PNG, GIF, BMP, WEBP, SVG (Maks. 2MB per file)
                            </p>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Produk -->
                        <div class="md:col-span-2">
                            <label for="edit_nama" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-xl">📝</span>
                                Nama Produk
                            </label>
                            <input type="text" 
                                   name="nama" 
                                   id="edit_nama" 
                                   class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 px-4 py-3 transition-all duration-300" 
                                   required>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="edit_kategori" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-xl">📂</span>
                                Kategori
                            </label>
                            <select name="kategori" 
                                    id="edit_kategori" 
                                    class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 px-4 py-3 transition-all duration-300" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                <option value="Percetakan">🖨️ Percetakan</option>
                                <option value="Konveksi">👕 Konveksi</option>
                                <option value="Kebutuhan Sekolah & Perusahaan">🏢 Kebutuhan Sekolah & Perusahaan</option>
                                <option value="Fasilitas">🏭 Fasilitas</option>
                            </select>
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="edit_harga" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-xl">💰</span>
                                Harga
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <span class="text-gray-500 font-semibold">Rp</span>
                                </div>
                                <input type="number" 
                                       name="harga" 
                                       id="edit_harga" 
                                       class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 pl-12 pr-4 py-3 transition-all duration-300" 
                                       required>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label for="edit_deskripsi" class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-xl">📄</span>
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" 
                                      id="edit_deskripsi" 
                                      rows="4" 
                                      class="input-modern w-full rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 px-4 py-3 transition-all duration-300" 
                                      required></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-8 py-6 flex justify-end gap-3 border-t-2 border-gray-100">
                <button type="button" 
                        onclick="productHandler.closeEditModal()" 
                        class="px-8 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition-all duration-300 shadow-md hover:shadow-lg">
                    Batal
                </button>
                <button type="button" 
                        onclick="productHandler.submitEdit()" 
                        class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection