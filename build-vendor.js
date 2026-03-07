/**
 * build-vendor.js
 * Copia las dependencias de node_modules → public/vendor
 * Se ejecuta con: npm run build:vendor
 * También se ejecuta automáticamente después de npm install (postinstall)
 */

const fs = require('fs');
const path = require('path');

const VENDOR_DIR = path.join(__dirname, 'public', 'vendor');

// Mapa: destino → archivos fuente
const files = {
    'bootstrap/css': [
        'node_modules/bootstrap/dist/css/bootstrap.min.css',
        'node_modules/bootstrap/dist/css/bootstrap.min.css.map',
    ],
    'bootstrap/js': [
        'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js.map',
    ],
    'bootstrap-icons': [
        'node_modules/bootstrap-icons/font/bootstrap-icons.min.css',
    ],
    'bootstrap-icons/fonts': [
        'node_modules/bootstrap-icons/font/fonts/bootstrap-icons.woff',
        'node_modules/bootstrap-icons/font/fonts/bootstrap-icons.woff2',
    ],
    'chartjs': [
        'node_modules/chart.js/dist/chart.umd.js',
    ],
    'flag-icons/css': [
        'node_modules/flag-icons/css/flag-icons.min.css',
    ],
    'alpinejs': [
        'node_modules/alpinejs/dist/cdn.min.js',
    ],
};

// Mapa: destino → directorio fuente (copia recursiva)
const dirs = {
    'flag-icons/flags': 'node_modules/flag-icons/flags',
};

// Crear directorios y copiar
let copied = 0;
let errors = 0;

for (const [destDir, sources] of Object.entries(files)) {
    const fullDestDir = path.join(VENDOR_DIR, destDir);
    fs.mkdirSync(fullDestDir, { recursive: true });

    for (const src of sources) {
        const srcPath = path.join(__dirname, src);
        const destPath = path.join(fullDestDir, path.basename(src));

        try {
            if (fs.existsSync(srcPath)) {
                fs.copyFileSync(srcPath, destPath);
                copied++;
            }
        } catch (err) {
            console.error(`  ✗ Error copiando ${src}: ${err.message}`);
            errors++;
        }
    }
}

for (const [destDir, srcDir] of Object.entries(dirs)) {
    const srcPath = path.join(__dirname, srcDir);
    const destPath = path.join(VENDOR_DIR, destDir);

    try {
        if (fs.existsSync(srcPath)) {
            fs.cpSync(srcPath, destPath, { recursive: true });
            copied++;
        }
    } catch (err) {
        console.error(`  ✗ Error copiando directorio ${srcDir}: ${err.message}`);
        errors++;
    }
}

console.log(`\n  ✓ Vendor build completado: ${copied} archivos copiados a public/vendor/`);
if (errors > 0) console.log(`  ✗ ${errors} errores`);
console.log('');
