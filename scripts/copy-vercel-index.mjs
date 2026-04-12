import { copyFileSync, existsSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const outDir = join(root, 'public', 'build');
const src = join(root, 'deployment', 'vercel-index.html');
const dest = join(outDir, 'index.html');

if (!existsSync(outDir)) {
    console.error('copy-vercel-index: public/build not found. Run vite build first.');
    process.exit(1);
}

copyFileSync(src, dest);
console.log('copy-vercel-index: wrote public/build/index.html');
