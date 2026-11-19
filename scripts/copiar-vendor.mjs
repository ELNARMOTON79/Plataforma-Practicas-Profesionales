// Copia a public/vendor las librerías que las vistas cargan con <script>,
// para que el sistema funcione sin internet. Uso: npm run vendor
import { copyFileSync, mkdirSync } from 'node:fs';

const archivos = {
    'node_modules/htmx.org/dist/htmx.min.js': 'public/vendor/htmx.min.js',
    'node_modules/jquery/dist/jquery.min.js': 'public/vendor/jquery.min.js',
    'node_modules/datatables.net/js/jquery.dataTables.min.js': 'public/vendor/jquery.dataTables.min.js',
    'node_modules/sweetalert2/dist/sweetalert2.all.min.js': 'public/vendor/sweetalert2.all.min.js',
};

mkdirSync('public/vendor', { recursive: true });
for (const [origen, destino] of Object.entries(archivos)) {
    copyFileSync(origen, destino);
    console.log(`${origen} -> ${destino}`);
}
