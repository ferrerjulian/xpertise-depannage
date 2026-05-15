# ============================================================
#  XPERTISE DÉPANNAGE — Script de publication vers GitHub
#  Double-cliquez sur ce fichier pour synchroniser et publier
# ============================================================

$source = "$env:USERPROFILE\OneDrive\Documents\Claude\Projects\Création site internet\xpertise-depannage"
$destination = "C:\GitHub\xpertise-depannage"

Write-Host ""
Write-Host "  XPERTISE DÉPANNAGE — Synchronisation" -ForegroundColor Cyan
Write-Host "  ======================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "  Source      : $source" -ForegroundColor Gray
Write-Host "  Destination : $destination" -ForegroundColor Gray
Write-Host ""

# Copier tous les fichiers sauf .git et ce script lui-même
$excludes = @(".git", "publier-sur-github.ps1")

Get-ChildItem -Path $source -Recurse | Where-Object {
    $item = $_
    $relative = $item.FullName.Substring($source.Length + 1)
    $firstFolder = $relative.Split('\')[0]
    $excludes -notcontains $firstFolder -and $excludes -notcontains $item.Name
} | ForEach-Object {
    $relative = $_.FullName.Substring($source.Length + 1)
    $dest = Join-Path $destination $relative

    if ($_.PSIsContainer) {
        if (!(Test-Path $dest)) {
            New-Item -ItemType Directory -Path $dest -Force | Out-Null
        }
    } else {
        $destDir = Split-Path $dest
        if (!(Test-Path $destDir)) {
            New-Item -ItemType Directory -Path $destDir -Force | Out-Null
        }
        Copy-Item -Path $_.FullName -Destination $dest -Force
    }
}

Write-Host "  Fichiers copiés avec succès !" -ForegroundColor Green
Write-Host ""
Write-Host "  Prochaine étape : ouvrez GitHub Desktop," -ForegroundColor Yellow
Write-Host "  ajoutez un message de commit et cliquez Push." -ForegroundColor Yellow
Write-Host ""

# Ouvrir GitHub Desktop automatiquement
$githubDesktop = "$env:LOCALAPPDATA\GitHubDesktop\GitHubDesktop.exe"
if (Test-Path $githubDesktop) {
    Write-Host "  Ouverture de GitHub Desktop..." -ForegroundColor Cyan
    Start-Process $githubDesktop
} else {
    Write-Host "  Ouvrez GitHub Desktop manuellement." -ForegroundColor Gray
}

Write-Host ""
Write-Host "  Appuyez sur une touche pour fermer..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
