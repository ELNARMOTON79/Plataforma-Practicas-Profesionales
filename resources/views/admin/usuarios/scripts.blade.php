<script>
    function toggleDynamicFields(value) {
        const dynamicFields = document.getElementById('dynamic-fields-modal');
        const alumnoFields = document.querySelectorAll('.alumno-field-modal');
        const empresaFields = document.querySelectorAll('.empresa-field-modal');

        // Inputs
        const inputMatricula = document.getElementById('matricula');
        const inputCarrera = document.getElementById('carrera');
        const inputSemestre = document.getElementById('semestre');
        const inputGrupo = document.getElementById('grupo');
        const inputNombreEmpresa = document.getElementById('nombre_empresa');
        const inputTipoPersona = document.getElementById('tipo_persona');
        const inputDireccion = document.getElementById('direccion');

        // Ocultar todos y quitar required
        dynamicFields.classList.add('hidden');
        alumnoFields.forEach(el => el.classList.add('hidden'));
        empresaFields.forEach(el => el.classList.add('hidden'));

        inputMatricula.required = false;
        inputCarrera.required = false;
        inputSemestre.required = false;
        inputGrupo.required = false;
        inputNombreEmpresa.required = false;
        inputTipoPersona.required = false;
        inputDireccion.required = false;

        // Mostrar según selección y poner required
        if (value === '3') { // Alumno
            dynamicFields.classList.remove('hidden');
            alumnoFields.forEach(el => el.classList.remove('hidden'));
            inputMatricula.required = true;
            inputCarrera.required = true;
            inputSemestre.required = true;
            inputGrupo.required = true;
        } else if (value === '4') { // Empresa
            dynamicFields.classList.remove('hidden');
            empresaFields.forEach(el => el.classList.remove('hidden'));
            inputNombreEmpresa.required = true;
            inputTipoPersona.required = true;
            inputDireccion.required = true;
        }
    }

    // Funciones para el modal de edición
    {
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
                
                // Configurar validaciones específicas según el rol
                const editNameInput = document.getElementById('edit_name');
                editNameInput.value = nombre;
                if (rolId === '4') { // Empresa
                    editNameInput.setAttribute('pattern', '^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\\s.,&-]+$');
                    editNameInput.setAttribute('title', 'El nombre de la empresa solo debe contener letras, números, espacios y los siguientes caracteres permitidos: .,&-');
                    editNameInput.classList.remove('restrict-letters');
                    editNameInput.classList.add('restrict-company-name');
                } else { // Personas (Admin, Coordinador, Alumno)
                    editNameInput.setAttribute('pattern', '^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\\s]+$');
                    editNameInput.setAttribute('title', 'El nombre completo solo debe contener letras y espacios.');
                    editNameInput.classList.remove('restrict-company-name');
                    editNameInput.classList.add('restrict-letters');
                }

                document.getElementById('edit_email').value = correo;
                document.getElementById('edit_role').value = rolId;
                document.getElementById('edit_role_hidden').value = rolId;
                document.getElementById('editUserForm').action = "{{ url('admin/usuarios') }}/" + id;
                document.getElementById('resendCredentialsForm').action = "{{ url('admin/usuarios') }}/" + id + "/resend-credentials";


                // Manejo de campos dinámicos
                const dynamicSection = document.getElementById('edit-dynamic-fields');
                const alumnoFields = document.querySelectorAll('.edit-alumno-field');
                const empresaFields = document.querySelectorAll('.edit-empresa-field');

                const editMatricula = document.getElementById('edit_matricula');
                const editCarrera = document.getElementById('edit_carrera');
                const editSemestre = document.getElementById('edit_semestre');
                const editGrupo = document.getElementById('edit_grupo');
                const editDireccion = document.getElementById('edit_direccion');
                const editTipoPersona = document.getElementById('edit_tipo_persona');

                // Ocultar sección dinámica y limpiar sus clases hidden e inputs required
                dynamicSection.classList.add('hidden');
                alumnoFields.forEach(el => el.classList.add('hidden'));
                empresaFields.forEach(el => el.classList.add('hidden'));

                editMatricula.required = false;
                editCarrera.required = false;
                editSemestre.required = false;
                editGrupo.required = false;
                editDireccion.required = false;
                editTipoPersona.required = false;

                if (rolId === '3') { // Alumno
                    dynamicSection.classList.remove('hidden');
                    alumnoFields.forEach(el => el.classList.remove('hidden'));

                    editMatricula.required = true;
                    editCarrera.required = true;
                    editSemestre.required = true;
                    editGrupo.required = true;

                    editMatricula.value = this.getAttribute('data-matricula') || '';
                    editCarrera.value = this.getAttribute('data-carrera') || '';
                    editSemestre.value = this.getAttribute('data-semestre') || '';
                    editGrupo.value = this.getAttribute('data-grupo') || '';
                } else if (rolId === '4') { // Empresa
                    dynamicSection.classList.remove('hidden');
                    empresaFields.forEach(el => el.classList.remove('hidden'));

                    editDireccion.required = true;
                    editTipoPersona.required = true;

                    editDireccion.value = this.getAttribute('data-direccion') || '';
                    editTipoPersona.value = this.getAttribute('data-tipo-persona') || 'Moral';
                }

                // Mostrar modal de edición
                document.getElementById('editUserModal').classList.remove('hidden');
            });
        });
    }

    function closeEditModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }

    // Auto-reabrir modal de edición con errores de validación si corresponde
    @if($errors->any() && old('id') && old('_method') == 'PUT')
    {
        const id = "{{ old('id') }}";
        const rolId = "{{ old('role') }}";
        
        // Asignar acción al formulario
        document.getElementById('editUserForm').action = "{{ url('admin/usuarios') }}/" + id;
        document.getElementById('resendCredentialsForm').action = "{{ url('admin/usuarios') }}/" + id + "/resend-credentials";

        // Configurar validaciones específicas según el rol al recargar con errores
        const editNameInput = document.getElementById('edit_name');
        if (rolId === '4') { // Empresa
            editNameInput.setAttribute('pattern', '^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\\s.,&-]+$');
            editNameInput.setAttribute('title', 'El nombre de la empresa solo debe contener letras, números, espacios y los siguientes caracteres permitidos: .,&-');
            editNameInput.classList.remove('restrict-letters');
            editNameInput.classList.add('restrict-company-name');
        } else { // Personas (Admin, Coordinador, Alumno)
            editNameInput.setAttribute('pattern', '^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\\s]+$');
            editNameInput.setAttribute('title', 'El nombre completo solo debe contener letras y espacios.');
            editNameInput.classList.remove('restrict-company-name');
            editNameInput.classList.add('restrict-letters');
        }

        // Manejo de campos dinámicos
        const dynamicSection = document.getElementById('edit-dynamic-fields');
        const alumnoFields = document.querySelectorAll('.edit-alumno-field');
        const empresaFields = document.querySelectorAll('.edit-empresa-field');

        const editMatricula = document.getElementById('edit_matricula');
        const editCarrera = document.getElementById('edit_carrera');
        const editSemestre = document.getElementById('edit_semestre');
        const editGrupo = document.getElementById('edit_grupo');
        const editDireccion = document.getElementById('edit_direccion');
        const editTipoPersona = document.getElementById('edit_tipo_persona');

        dynamicSection.classList.add('hidden');
        alumnoFields.forEach(el => el.classList.add('hidden'));
        empresaFields.forEach(el => el.classList.add('hidden'));

        editMatricula.required = false;
        editCarrera.required = false;
        editSemestre.required = false;
        editGrupo.required = false;
        editDireccion.required = false;
        editTipoPersona.required = false;

        if (rolId === '3') { // Alumno
            dynamicSection.classList.remove('hidden');
            alumnoFields.forEach(el => el.classList.remove('hidden'));
            editMatricula.required = true;
            editCarrera.required = true;
            editSemestre.required = true;
            editGrupo.required = true;
        } else if (rolId === '4') { // Empresa
            dynamicSection.classList.remove('hidden');
            empresaFields.forEach(el => el.classList.remove('hidden'));
            editDireccion.required = true;
            editTipoPersona.required = true;
        }

        // Mostrar modal de edición
        document.getElementById('editUserModal').classList.remove('hidden');
    }
    @endif

    // Auto-reabrir modal de registro con errores de validación si corresponde
    @if($errors->any() && (!old('id') || old('_method') != 'PUT'))
    toggleDynamicFields("{{ old('role') }}");
    document.getElementById('registerUserModal').classList.remove('hidden');
    @endif

    // Funciones para el modal de confirmación personalizado
    function openConfirmEditModal() {
        const form = document.getElementById('editUserForm');
        // Validar que el formulario sea válido antes de abrir confirmación
        if (form.checkValidity()) {
            document.getElementById('confirmEditModal').classList.remove('hidden');
        } else {
            // Mostrar los errores nativos del navegador
            form.reportValidity();
        }
    }

    function closeConfirmEditModal() {
        document.getElementById('confirmEditModal').classList.add('hidden');
    }

    // Asegurarnos de que el formulario solo se envíe si es válido
    function submitEditUserForm() {
        const form = document.getElementById('editUserForm');
        if (form.checkValidity()) {
            form.submit();
        } else {
            closeConfirmEditModal();
            form.reportValidity();
        }
    }

    // Funciones para suspender/reactivar usuarios
    var userIdToToggle = null;

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

    function confirmResendCredentials() {
        const userName = document.getElementById('edit_name').value;
        const userEmail = document.getElementById('edit_email').value;
        if (confirm(`¿Estás seguro de que deseas restablecer la contraseña y reenviar las credenciales a ${userName} (${userEmail})?\n\nEsta acción invalidará su contraseña actual y le enviará un correo con la nueva contraseña generada.`)) {
            document.getElementById('resendCredentialsForm').submit();
        }
    }

    // Filtros de caracteres en tiempo real (Keypress e Input event delegation)
    document.addEventListener('keypress', function(e) {
        const target = e.target;
        if (!target || !target.classList) return;
        
        let regex = null;
        if (target.classList.contains('restrict-letters')) {
            regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]$/;
        } else if (target.classList.contains('restrict-alphanumeric')) {
            regex = /^[a-zA-Z0-9]$/;
        } else if (target.classList.contains('restrict-company-name')) {
            regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,&-]$/;
        } else if (target.classList.contains('restrict-address')) {
            regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,#\/\s-]$/;
        } else if (target.classList.contains('restrict-search')) {
            regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]$/;
        } else if (target.classList.contains('restrict-email')) {
            regex = /^[a-zA-Z0-9@._+-]$/;
        } else if (target.classList.contains('restrict-numbers')) {
            regex = /^[0-9]$/;
        } else if (target.classList.contains('restrict-letters-only')) {
            regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]$/;
        }
        
        if (regex) {
            // Permitir teclas de navegación y control
            if (e.key === 'Backspace' || e.key === 'Enter' || e.key === 'Tab' || e.key === 'Delete' || e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                return;
            }
            if (!regex.test(e.key)) {
                e.preventDefault();
            }
        }
    });

    document.addEventListener('input', function(e) {
        const target = e.target;
        if (!target || !target.classList) return;
        
        let regex = null;
        if (target.classList.contains('restrict-letters')) {
            regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]$/;
        } else if (target.classList.contains('restrict-alphanumeric')) {
            regex = /^[a-zA-Z0-9]$/;
        } else if (target.classList.contains('restrict-company-name')) {
            regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,&-]$/;
        } else if (target.classList.contains('restrict-address')) {
            regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,#\/\s-]$/;
        } else if (target.classList.contains('restrict-search')) {
            regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]$/;
        } else if (target.classList.contains('restrict-email')) {
            regex = /^[a-zA-Z0-9@._+-]$/;
        } else if (target.classList.contains('restrict-numbers')) {
            regex = /^[0-9]$/;
        } else if (target.classList.contains('restrict-letters-only')) {
            regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]$/;
        }
        
        if (regex) {
            let newValue = '';
            for (let char of target.value) {
                if (regex.test(char)) {
                    newValue += char;
                }
            }
            if (target.value !== newValue) {
                target.value = newValue;
            }
        }
    });
</script>
