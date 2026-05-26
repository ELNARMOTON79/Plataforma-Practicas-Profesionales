<script>
    function toggleDynamicFields(value) {
        const dynamicFields = document.getElementById('dynamic-fields-modal');
        const alumnoFields = document.querySelectorAll('.alumno-field-modal');
        const empresaFields = document.querySelectorAll('.empresa-field-modal');

        // Ocultar todos
        dynamicFields.classList.add('hidden');
        alumnoFields.forEach(el => el.classList.add('hidden'));
        empresaFields.forEach(el => el.classList.add('hidden'));

        // Mostrar según selección
        if (value === '3') { // Alumno
            dynamicFields.classList.remove('hidden');
            alumnoFields.forEach(el => el.classList.remove('hidden'));
        } else if (value === '4') { // Empresa
            dynamicFields.classList.remove('hidden');
            empresaFields.forEach(el => el.classList.remove('hidden'));
        }
    }

    // Funciones para el modal de edición
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-ocultar alerta de éxito a los 5 segundos
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }, 5000);
        }

        // Auto-ocultar alerta de error a los 5 segundos
        const errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {
            setTimeout(function() {
                errorAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(function() {
                    errorAlert.remove();
                }, 500);
            }, 5000);
        }

        const editButtons = document.querySelectorAll('.btn-edit-user');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const correo = this.getAttribute('data-correo');
                const rolId = this.getAttribute('data-rol-id');
                const nombre = this.getAttribute('data-nombre');

                // Llenar campos básicos
                document.getElementById('edit_user_id').value = id;
                document.getElementById('edit_name').value = nombre;
                document.getElementById('edit_email').value = correo;
                document.getElementById('edit_role').value = rolId;
                document.getElementById('edit_role_hidden').value = rolId;
                document.getElementById('editUserForm').action = "{{ url('admin/usuarios') }}/" + id;


                // Manejo de campos dinámicos
                const dynamicSection = document.getElementById('edit-dynamic-fields');
                const alumnoFields = document.querySelectorAll('.edit-alumno-field');
                const empresaFields = document.querySelectorAll('.edit-empresa-field');

                // Ocultar sección dinámica y limpiar sus clases hidden
                dynamicSection.classList.add('hidden');
                alumnoFields.forEach(el => el.classList.add('hidden'));
                empresaFields.forEach(el => el.classList.add('hidden'));

                if (rolId === '3') { // Alumno
                    dynamicSection.classList.remove('hidden');
                    alumnoFields.forEach(el => el.classList.remove('hidden'));

                    document.getElementById('edit_matricula').value = this.getAttribute('data-matricula') || '';
                    document.getElementById('edit_carrera').value = this.getAttribute('data-carrera') || '';
                    document.getElementById('edit_semestre').value = this.getAttribute('data-semestre') || '';
                    document.getElementById('edit_grupo').value = this.getAttribute('data-grupo') || '';
                } else if (rolId === '4') { // Empresa
                    dynamicSection.classList.remove('hidden');
                    empresaFields.forEach(el => el.classList.remove('hidden'));

                    document.getElementById('edit_direccion').value = this.getAttribute('data-direccion') || '';
                    document.getElementById('edit_tipo_persona').value = this.getAttribute('data-tipo-persona') || 'Moral';
                }

                // Mostrar modal de edición
                document.getElementById('editUserModal').classList.remove('hidden');
            });
        });
    });

    function closeEditModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }

    // Auto-reabrir modal de edición con errores de validación si corresponde
    @if($errors->any() && old('id') && old('_method') == 'PUT')
    document.addEventListener('DOMContentLoaded', function() {
        const id = "{{ old('id') }}";
        const rolId = "{{ old('role') }}";
        
        // Asignar acción al formulario
        document.getElementById('editUserForm').action = "{{ url('admin/usuarios') }}/" + id;

        // Manejo de campos dinámicos
        const dynamicSection = document.getElementById('edit-dynamic-fields');
        const alumnoFields = document.querySelectorAll('.edit-alumno-field');
        const empresaFields = document.querySelectorAll('.edit-empresa-field');

        dynamicSection.classList.add('hidden');
        alumnoFields.forEach(el => el.classList.add('hidden'));
        empresaFields.forEach(el => el.classList.add('hidden'));

        if (rolId === '3') { // Alumno
            dynamicSection.classList.remove('hidden');
            alumnoFields.forEach(el => el.classList.remove('hidden'));
        } else if (rolId === '4') { // Empresa
            dynamicSection.classList.remove('hidden');
            empresaFields.forEach(el => el.classList.remove('hidden'));
        }

        // Mostrar modal de edición
        document.getElementById('editUserModal').classList.remove('hidden');
    });
    @endif

    // Auto-reabrir modal de registro con errores de validación si corresponde
    @if($errors->any() && (!old('id') || old('_method') != 'PUT'))
    document.addEventListener('DOMContentLoaded', function() {
        toggleDynamicFields("{{ old('role') }}");
        document.getElementById('registerUserModal').classList.remove('hidden');
    });
    @endif

    // Funciones para el modal de confirmación personalizado
    function openConfirmEditModal() {
        document.getElementById('confirmEditModal').classList.remove('hidden');
    }

    function closeConfirmEditModal() {
        document.getElementById('confirmEditModal').classList.add('hidden');
    }

    function submitEditUserForm() {
        document.getElementById('editUserForm').submit();
    }

    // Funciones para suspender/reactivar usuarios
    let userIdToToggle = null;

    function confirmDeactivate(id, name) {
        userIdToToggle = id;
        document.getElementById('deactivate_user_name').textContent = name;
        document.getElementById('confirmDeactivateModal').classList.remove('hidden');
    }

    function closeConfirmDeactivateModal() {
        document.getElementById('confirmDeactivateModal').classList.add('hidden');
        userIdToToggle = null;
    }

    function toggleUserStatus(id) {
        const form = document.getElementById('toggleStatusForm');
        form.action = "{{ url('admin/usuarios') }}/" + id + "/toggle-status";
        form.submit();
    }

    function submitDeactivateUser() {
        if (userIdToToggle) {
            toggleUserStatus(userIdToToggle);
        }
    }
</script>
