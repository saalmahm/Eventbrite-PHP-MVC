const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('toggleSidebar');
        const toggleIcon = toggleButton.querySelector('i');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');

        function toggleSidebar() {
            sidebar.classList.toggle('sidebar-collapsed');
            sidebar.classList.toggle('sidebar-expanded');
            toggleIcon.classList.toggle('ri-arrow-left-s-line');
            toggleIcon.classList.toggle('ri-arrow-right-s-line');
        }

        toggleButton.addEventListener('click', toggleSidebar);
        mobileMenuBtn.addEventListener('click', toggleSidebar);

        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                sidebar.classList.add('sidebar-collapsed');
                sidebar.classList.remove('sidebar-expanded');
            }
        });

        function handleResize() {
            const isMobile = window.innerWidth <= 768;
            if (isMobile) {
                sidebar.classList.add('sidebar-collapsed');
                sidebar.classList.remove('sidebar-expanded');
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize();

        const fileInput = document.getElementById('image');
        const fileContainer = fileInput.closest('.border-dashed');

        function resetUploadBox() {
            fileContainer.innerHTML = `
        <label class="custom-file-upload flex justify-center items-center rounded-md">
            <input type="file" id="image" name="image" class="hidden">
            <div class="text-center py-8">
                <i class="ri-upload-cloud-line text-4xl text-orange-400 mb-2"></i>
                <p class="text-sm text-gray-600">Cliquez pour télécharger ou glissez-déposez</p>
                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF jusqu'à 10MB</p>
            </div>
        </label>
    `;

            const newFileInput = document.getElementById('image');
            newFileInput.addEventListener('change', handleFileUpload);
        }

        function handleFileUpload(e) {
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    fileContainer.innerHTML = `
                <div class="relative text-center py-4">
                    <!-- Aperçu de l'image -->
                    <img src="${e.target.result}" alt="Aperçu" class="mx-auto h-32 object-cover rounded-md">
                    
                    <!-- Nom du fichier -->
                    <p class="text-sm text-gray-600 mt-2">${file.name}</p>

                    <!-- Icône de suppression -->
                    <button id="removeFile" class="w-8 h-8 flex justify-center items-center absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full shadow-md hover:bg-red-600 transition duration-200">
                        <i class="ri-close-line text-lg"></i> 
                    </button>
                </div>
            `;

                    document.getElementById('removeFile').addEventListener('click', resetUploadBox);
                };
                reader.readAsDataURL(file);
            }
        }

        fileInput.addEventListener('change', handleFileUpload);