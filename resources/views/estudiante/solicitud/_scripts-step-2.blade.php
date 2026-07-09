<script>
    function calcularFechaFin() {
        const elInicio = document.getElementById('fecha_inicio');
        const elFin = document.getElementById('fecha_fin');
        const elHoras = document.getElementById('horas_previstas');
        const elResumen = document.getElementById('resumen-calculo-dias');

        if (!elInicio || !elFin || !elHoras) return;

        const valInicio = elInicio.value;
        const valHoras = parseInt(elHoras.value, 10);

        if (!valInicio || isNaN(valHoras) || valHoras <= 0) {
            if (elResumen) elResumen.classList.add('hidden');
            elFin.value = '';
            return;
        }

        const parts = valInicio.split('-');
        if (parts.length !== 3) return;
        const fecha = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));

        if (isNaN(fecha.getTime())) {
            if (elResumen) elResumen.classList.add('hidden');
            return;
        }

        // Validar que no sea una fecha pasada (anterior a hoy en hora local)
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        if (fecha < hoy) {
            alert('Por favor selecciona una fecha de inicio a partir del día de hoy. No es posible iniciar prácticas en fechas pasadas.');
            elInicio.value = '';
            elFin.value = '';
            if (elResumen) elResumen.classList.add('hidden');
            return;
        }

        // Días hábiles necesarios (6 horas diarias, lunes a viernes)
        const diasNecesarios = Math.ceil(valHoras / 6);
        let diasContados = 0;
        let diaActual = new Date(fecha.getTime());

        // Feriados fijos oficiales en México y Colima (LFT / UdeC) en formato MM-DD
        const feriadosFijos = [
            '01-01', // Año Nuevo
            '05-01', // Día del Trabajo
            '05-05', // Batalla de Puebla
            '05-10', // Día de las Madres (tradición en Colima / escolar)
            '05-15', // Día del Maestro
            '09-16', // Día de la Independencia
            '10-12', // Día de la Raza / Hispanidad
            '11-01', // Todos los Santos
            '11-02', // Día de Muertos
            '12-12', // Virgen de Guadalupe / Día Empleado Universitario
            '12-24', // Nochebuena
            '12-25', // Navidad
            '12-31'  // Fin de Año
        ];

        // Feriados móviles (Lunes festivos LFT y Semana Santa para 2025, 2026 y 2027) en formato YYYY-MM-DD
        const feriadosMoviles = [
            // 2025
            '2025-02-03', '2025-03-17', '2025-04-17', '2025-04-18', '2025-11-17',
            // 2026
            '2026-02-02', '2026-03-16', '2026-04-02', '2026-04-03', '2026-11-16',
            // 2027
            '2027-02-01', '2027-03-15', '2027-03-25', '2027-03-26', '2027-11-15'
        ];

        function esInhabil(d) {
            const diaSemana = d.getDay();
            if (diaSemana === 0 || diaSemana === 6) return true; // 0=Domingo, 6=Sábado

            const yyyy = d.getFullYear();
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            const mdStr = `${mm}-${dd}`;
            const ymdStr = `${yyyy}-${mm}-${dd}`;

            return feriadosFijos.includes(mdStr) || feriadosMoviles.includes(ymdStr);
        }

        // Conteo de días hábiles desde la fecha de inicio
        while (diasContados < diasNecesarios) {
            if (!esInhabil(diaActual)) {
                diasContados++;
            }
            if (diasContados < diasNecesarios) {
                diaActual.setDate(diaActual.getDate() + 1);
            }
        }

        const yRes = diaActual.getFullYear();
        const mRes = String(diaActual.getMonth() + 1).padStart(2, '0');
        const dRes = String(diaActual.getDate()).padStart(2, '0');

        elFin.value = `${yRes}-${mRes}-${dRes}`;

        if (elResumen) {
            document.getElementById('resumen-dias-habiles').textContent = `${diasNecesarios} días hábiles`;
            document.getElementById('resumen-horas-diarias').textContent = `6 hrs/día`;
            document.getElementById('resumen-fecha-fin-texto').textContent = `${dRes}/${mRes}/${yRes}`;
            elResumen.classList.remove('hidden');
        }
    }

    // Calcular si la fecha y horas tienen valores al cargar y fijar min actual en cliente
    document.addEventListener('DOMContentLoaded', () => {
        const elInicio = document.getElementById('fecha_inicio');
        if (elInicio) {
            const hoyIso = new Date().toISOString().split('T')[0];
            elInicio.setAttribute('min', hoyIso);
        }
        calcularFechaFin();
    });
</script>
