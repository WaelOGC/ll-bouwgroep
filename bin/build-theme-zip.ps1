<#
.SYNOPSIS
	Builds a distributable theme zip containing the theme folder only.

.DESCRIPTION
	Windows equivalent of bin/build-theme-zip.
	Output: dist/ll-bouwgroep-<version>.zip

.EXAMPLE
	powershell -ExecutionPolicy Bypass -File bin\build-theme-zip.ps1
#>

$ErrorActionPreference = 'Stop'

$RepoRoot  = Split-Path -Parent $PSScriptRoot
$ThemeSlug = 'll-bouwgroep'
$ThemeDir  = Join-Path $RepoRoot "app\public\wp-content\themes\$ThemeSlug"
$DistDir   = Join-Path $RepoRoot 'dist'

if (-not (Test-Path (Join-Path $ThemeDir 'style.css'))) {
	throw "Theme not found at $ThemeDir"
}

$VersionLine = Select-String -Path (Join-Path $ThemeDir 'style.css') -Pattern '^\s*Version:\s*(.+)$' | Select-Object -First 1
if (-not $VersionLine) {
	throw 'Could not read Version from style.css'
}
$Version = $VersionLine.Matches[0].Groups[1].Value.Trim()

$ZipFile = Join-Path $DistDir "$ThemeSlug-$Version.zip"
$Staging = Join-Path ([System.IO.Path]::GetTempPath()) ("llb-build-" + [System.Guid]::NewGuid().ToString('N'))
$Target  = Join-Path $Staging $ThemeSlug

New-Item -ItemType Directory -Path $Target -Force | Out-Null
New-Item -ItemType Directory -Path $DistDir -Force | Out-Null

$ExcludeDirs  = @('.git', '.github', 'node_modules', 'bin', 'docs', 'tests')
$ExcludeFiles = @('*.map', '*.log', '*.zip', '.DS_Store', 'Thumbs.db', '.editorconfig', 'phpcs.xml*', 'package*.json')

Get-ChildItem -Path $ThemeDir -Recurse -File | ForEach-Object {
	$relative = $_.FullName.Substring($ThemeDir.Length).TrimStart('\')
	$segments = $relative -split '\\'

	foreach ($dir in $ExcludeDirs) {
		if ($segments -contains $dir) { return }
	}
	foreach ($pattern in $ExcludeFiles) {
		if ($_.Name -like $pattern) { return }
	}

	$destination = Join-Path $Target $relative
	$parent      = Split-Path -Parent $destination
	if (-not (Test-Path $parent)) {
		New-Item -ItemType Directory -Path $parent -Force | Out-Null
	}
	Copy-Item -Path $_.FullName -Destination $destination
}

if (Test-Path $ZipFile) {
	Remove-Item $ZipFile -Force
}

Compress-Archive -Path $Target -DestinationPath $ZipFile -CompressionLevel Optimal
Remove-Item $Staging -Recurse -Force

Write-Output "Built $ZipFile"
