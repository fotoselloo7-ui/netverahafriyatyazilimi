<?php
/**
 * Ana sayfa şantiye animasyonu (saf SVG + CSS).
 * Senaryo: kamyon sağdan gelir → kepçenin kovasının altında durur →
 * kepçe yükleme yapar, kasa dolar → kamyon sola çıkar → yenisi gelir.
 * Bölüm "Ana Sayfa Bölümleri > machine_anim" üzerinden yönetilir.
 *
 * Katman sırası önemli: zemin → yığın → ekskavatör → düşen toprak → kamyon.
 * Kamyon en önde olduğu için kova/toprak, kasa duvarının arkasında kaybolur
 * ve "kasaya doluyor" hissi doğru şekilde oluşur.
 */
$maSec = $sections['machine_anim'] ?? null;
$maTitle = $maSec['title'] ?? 'Sahada Güç, İşte Verim';
$maText  = $maSec['subtitle'] ?? 'Kepçe, kamyon ve deneyimli ekibimizle hafriyat işleriniz planlı, hızlı ve güvenli şekilde ilerler.';
$maCtaText = trim((string) ($maSec['cta_text'] ?? ''));
$maCtaUrl  = trim((string) ($maSec['cta_url'] ?? ''));
?>
<section class="section machine-anim">
    <div class="container machine-anim__grid">
        <div class="machine-anim__text">
            <span class="eyebrow">Şantiyede <?= e(site_name()) ?></span>
            <h2><?= e($maTitle) ?></h2>
            <p><?= e($maText) ?></p>
            <div class="machine-anim__stats">
                <div><b><?= e(setting('about_counter_projects', '1000+')) ?></b><span>Tamamlanan Proje</span></div>
                <div><b><?= e(setting('about_counter_experience', '10+')) ?></b><span>Yıllık Deneyim</span></div>
                <div><b><?= e(setting('about_counter_support', '7/24')) ?></b><span>Destek</span></div>
            </div>
            <?php if ($maCtaText !== ''): ?>
                <a href="<?= e(build_link('internal', $maCtaUrl ?: '/iletisim')) ?>" class="btn btn--primary"><?= e($maCtaText) ?></a>
            <?php else: ?>
                <a href="<?= e(whatsapp_link('Merhaba, hafriyat/kepçe hizmeti için teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--primary"><?= icon('whatsapp', 18) ?> Hemen Teklif Al</a>
            <?php endif; ?>
        </div>

        <div class="machine-scene" role="img" aria-label="Ekskavatör, sırayla yanaşan kamyonlara toprak yüklüyor; dolan kamyon sahneden ayrılıyor.">
            <svg viewBox="0 0 900 340" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
                <!-- Zemin / sahne -->
                <rect class="ma-ground" x="0" y="292" width="900" height="48"/>
                <path class="ma-hill" d="M0 296 Q 200 258 430 288 T 900 280 V296 Z"/>
                <!-- Kazı yığını: ekskavatörün önünde -->
                <path class="ma-pile" d="M300 292 Q 360 236 430 292 Z"/>
                <path class="ma-pile ma-pile--2" d="M345 292 Q 388 256 435 292 Z"/>

                <!-- Ekskavatör (solda, sağa bakar) -->
                <g class="ma-exc">
                    <rect class="ma-track" x="96" y="268" width="196" height="38" rx="19"/>
                    <circle class="ma-hub" cx="122" cy="287" r="10"/>
                    <circle class="ma-hub" cx="194" cy="287" r="10"/>
                    <circle class="ma-hub" cx="266" cy="287" r="10"/>
                    <rect class="ma-base" x="120" y="252" width="150" height="18" rx="6"/>
                    <rect class="ma-house" x="118" y="198" width="112" height="58" rx="10"/>
                    <rect class="ma-counter" x="106" y="210" width="24" height="40" rx="5"/>
                    <path class="ma-cab" d="M196 188 Q196 178 206 178 H244 Q252 178 252 186 V254 H196 Z"/>
                    <rect class="ma-exc-window" x="204" y="186" width="34" height="30" rx="4"/>
                    <!-- bom (omuz pivotu 252,232) -->
                    <g class="ma-boom">
                        <path class="ma-arm" d="M252 232 L398 148" stroke-linecap="round"/>
                        <g class="ma-arm2">
                            <path class="ma-arm ma-arm--thin" d="M398 148 L452 208" stroke-linecap="round"/>
                            <g class="ma-bucket">
                                <path class="ma-bucket-shape" d="M436 204 L472 200 L478 234 Q458 250 440 236 Z"/>
                            </g>
                        </g>
                    </g>
                </g>

                <!-- Düşen toprak: kamyonun ARKASINDA çizilir, kasa duvarında kaybolur -->
                <g class="ma-dirt">
                    <circle cx="452" cy="200" r="6"/>
                    <circle cx="466" cy="196" r="4.5"/>
                    <circle cx="442" cy="204" r="4"/>
                </g>

                <!-- Kamyon: sağdan gelir, kova altında durur, dolunca sola çıkar (en ön katman) -->
                <g class="ma-truck">
                    <!-- yerel koordinat 0..246, sola bakar (kabin solda, gidiş yönü sol) -->
                    <path class="ma-truck-cab" d="M8 224 Q8 212 20 212 H58 Q66 212 66 220 V268 H8 Z"/>
                    <rect class="ma-truck-window" x="16" y="220" width="30" height="20" rx="3"/>
                    <rect class="ma-truck-grill" x="4" y="248" width="10" height="16" rx="2"/>
                    <rect class="ma-truck-chassis" x="4" y="268" width="238" height="10" rx="3"/>
                    <!-- kasa yükü: kasanın arkasında, üstten görünür -->
                    <clipPath id="maBedClip"><rect x="76" y="192" width="164" height="70" rx="4"/></clipPath>
                    <g clip-path="url(#maBedClip)">
                        <path class="ma-load" d="M76 262 H240 V232 Q216 216 196 228 T156 226 T116 230 T76 232 Z"/>
                    </g>
                    <!-- damper kasa (ön duvar) -->
                    <path class="ma-truck-bed" d="M74 216 H236 Q244 216 244 224 V266 H74 Q70 266 70 260 V222 Q70 216 74 216 Z"/>
                    <rect class="ma-truck-bedline" x="80" y="238" width="158" height="4" rx="2"/>
                    <g class="ma-wheelset">
                        <circle cx="36" cy="284" r="17" class="ma-wheel"/><circle cx="36" cy="284" r="7" class="ma-hub"/>
                        <circle cx="150" cy="284" r="17" class="ma-wheel"/><circle cx="150" cy="284" r="7" class="ma-hub"/>
                        <circle cx="196" cy="284" r="17" class="ma-wheel"/><circle cx="196" cy="284" r="7" class="ma-hub"/>
                    </g>
                </g>
            </svg>
        </div>
    </div>
</section>
