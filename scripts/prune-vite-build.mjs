import { promises as fs } from 'node:fs';
import path from 'node:path';

const buildDir = path.resolve('public/build');
const manifestPath = path.join(buildDir, 'manifest.json');
const dryRun = process.argv.includes('--dry-run');

async function exists(targetPath) {
	try {
		await fs.access(targetPath);
		return true;
	} catch {
		return false;
	}
}

function normalize(relativePath) {
	return relativePath.split(path.sep).join('/');
}

async function walkFiles(dir) {
	const entries = await fs.readdir(dir, { withFileTypes: true });
	const files = [];

	for (const entry of entries) {
		const fullPath = path.join(dir, entry.name);

		if (entry.isDirectory()) {
			files.push(...await walkFiles(fullPath));
		} else if (entry.isFile()) {
			files.push(fullPath);
		}
	}

	return files;
}

async function removeEmptyDirs(dir, rootDir) {
	const entries = await fs.readdir(dir, { withFileTypes: true });

	for (const entry of entries) {
		if (!entry.isDirectory()) {
			continue;
		}

		const childPath = path.join(dir, entry.name);
		await removeEmptyDirs(childPath, rootDir);
	}

	if (dir === rootDir) {
		return;
	}

	const remaining = await fs.readdir(dir);
	if (remaining.length === 0) {
		await fs.rmdir(dir);
	}
}

function collectManifestFiles(manifest) {
	const keep = new Set(['manifest.json']);
	const visited = new Set();

	const addBuiltPath = (builtPath) => {
		if (typeof builtPath === 'string' && builtPath.length > 0) {
			keep.add(normalize(builtPath));
		}
	};

	const addEntry = (entryKey) => {
		if (visited.has(entryKey)) {
			return;
		}

		visited.add(entryKey);

		const entry = manifest[entryKey];
		if (!entry || typeof entry !== 'object') {
			return;
		}

		addBuiltPath(entry.file);

		if (Array.isArray(entry.css)) {
			entry.css.forEach(addBuiltPath);
		}

		if (Array.isArray(entry.assets)) {
			entry.assets.forEach(addBuiltPath);
		}

		if (Array.isArray(entry.imports)) {
			entry.imports.forEach(addEntry);
		}

		if (Array.isArray(entry.dynamicImports)) {
			entry.dynamicImports.forEach(addEntry);
		}
	};

	Object.keys(manifest).forEach(addEntry);

	return keep;
}

async function run() {
	if (!(await exists(buildDir))) {
		console.log('No public/build directory found. Nothing to prune.');
		return;
	}

	if (!(await exists(manifestPath))) {
		console.log('No Vite manifest found. Skipping prune to avoid accidental deletions.');
		return;
	}

	const rawManifest = await fs.readFile(manifestPath, 'utf8');
	const manifest = JSON.parse(rawManifest);
	const keep = collectManifestFiles(manifest);

	const buildFiles = await walkFiles(buildDir);
	const staleFiles = buildFiles.filter((fullPath) => {
		const relativePath = normalize(path.relative(buildDir, fullPath));
		return !keep.has(relativePath);
	});

	if (staleFiles.length === 0) {
		console.log('No stale Vite assets to prune.');
		return;
	}

	for (const staleFile of staleFiles) {
		const relativePath = normalize(path.relative(buildDir, staleFile));

		if (dryRun) {
			console.log(`[dry-run] remove ${relativePath}`);
		} else {
			await fs.unlink(staleFile);
		}
	}

	if (!dryRun) {
		await removeEmptyDirs(buildDir, buildDir);
	}

	console.log(`${dryRun ? 'Would remove' : 'Removed'} ${staleFiles.length} stale Vite asset file(s).`);
}

run().catch((error) => {
	console.error('Failed to prune Vite assets:', error);
	process.exitCode = 1;
});
