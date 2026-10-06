<?php $v = fn ($k, $d = '') => e($n[$k] ?? $d); $ck = fn ($k) => !empty($n[$k]) ? 'checked' : ''; ?>
<form method="post" action="<?= base_url('yonetim/bildirim') ?>">
    <?= csrf_field() ?>
    <p class="help">WhatsApp/SMS/E-posta/Telegram kimlik bilgileri girilmezse sistem bozulmaz; ilgili bildirimler <strong>skipped_missing_credentials</strong> olarak loglanır.</p>

    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('users', 18) ?> Site Sahibi</h2></div>
        <div class="a-row--3" style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
            <div class="a-field"><label>Ad</label><input type="text" name="owner_name" value="<?= $v('owner_name') ?>"></div>
            <div class="a-field"><label>Telefon</label><input type="text" name="owner_phone" value="<?= $v('owner_phone') ?>"></div>
            <div class="a-field"><label>E-posta</label><input type="email" name="owner_email" value="<?= $v('owner_email') ?>"></div>
        </div>
    </div>

    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('check-circle', 18) ?> Bildirim Tetikleyicileri</h2></div>
        <div class="a-grid a-grid--2">
            <label class="a-check"><input type="checkbox" name="notify_on_new_lead" <?= $ck('notify_on_new_lead') ?>> Yeni teklif geldiğinde</label>
            <label class="a-check"><input type="checkbox" name="notify_on_contact_form" <?= $ck('notify_on_contact_form') ?>> İletişim formu geldiğinde</label>
            <label class="a-check"><input type="checkbox" name="notify_on_whatsapp_click" <?= $ck('notify_on_whatsapp_click') ?>> WhatsApp butonuna tıklandığında</label>
            <label class="a-check"><input type="checkbox" name="notify_on_popup_click" <?= $ck('notify_on_popup_click') ?>> Popup butonuna tıklandığında</label>
            <label class="a-check"><input type="checkbox" name="notify_on_admin_login" <?= $ck('notify_on_admin_login') ?>> Admin girişi yapıldığında</label>
            <label class="a-check"><input type="checkbox" name="notify_on_new_visitor" <?= $ck('notify_on_new_visitor') ?>> Yeni ziyaretçi girdiğinde (varsayılan kapalı)</label>
        </div>
        <div class="a-field" style="margin-top:14px;max-width:280px"><label>Ziyaretçi bildirimi throttle (dk)</label><input type="number" name="visitor_notification_throttle_minutes" value="<?= (int) ($n['visitor_notification_throttle_minutes'] ?? 30) ?>"></div>
    </div>

    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('whatsapp', 18) ?> WhatsApp Cloud API</h2><label class="a-check"><input type="checkbox" name="whatsapp_api_enabled" <?= $ck('whatsapp_api_enabled') ?>> Aktif</label></div>
        <div class="a-row">
            <div class="a-field"><label>Sağlayıcı</label><input type="text" name="whatsapp_provider" value="<?= $v('whatsapp_provider') ?>" placeholder="cloud_api / twilio"></div>
            <div class="a-field"><label>Phone Number ID</label><input type="text" name="whatsapp_phone_number_id" value="<?= $v('whatsapp_phone_number_id') ?>"></div>
        </div>
        <div class="a-field"><label>API Token</label><input type="text" name="whatsapp_api_token" value="<?= $v('whatsapp_api_token') ?>"></div>
        <div class="a-row">
            <div class="a-field"><label>Template Adı</label><input type="text" name="whatsapp_template_name" value="<?= $v('whatsapp_template_name') ?>"></div>
            <div class="a-field"><label>Custom Webhook URL</label><input type="url" name="custom_webhook_url" value="<?= $v('custom_webhook_url') ?>"></div>
        </div>
    </div>

    <div class="a-grid a-grid--2">
        <div class="a-card">
            <div class="a-card__head"><h2><?= icon('message-circle', 18) ?> Telegram</h2><label class="a-check"><input type="checkbox" name="telegram_enabled" <?= $ck('telegram_enabled') ?>> Aktif</label></div>
            <div class="a-field"><label>Bot Token</label><input type="text" name="telegram_bot_token" value="<?= $v('telegram_bot_token') ?>"></div>
            <div class="a-field"><label>Chat ID</label><input type="text" name="telegram_chat_id" value="<?= $v('telegram_chat_id') ?>"></div>
        </div>
        <div class="a-card">
            <div class="a-card__head"><h2><?= icon('phone', 18) ?> SMS</h2><label class="a-check"><input type="checkbox" name="sms_enabled" <?= $ck('sms_enabled') ?>> Aktif</label></div>
            <div class="a-field"><label>Sağlayıcı</label><input type="text" name="sms_provider" value="<?= $v('sms_provider') ?>"></div>
            <div class="a-field"><label>API Key</label><input type="text" name="sms_api_key" value="<?= $v('sms_api_key') ?>"></div>
        </div>
    </div>

    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('mail', 18) ?> E-posta (SMTP)</h2><label class="a-check"><input type="checkbox" name="email_enabled" <?= $ck('email_enabled') ?>> Aktif</label></div>
        <div class="a-row">
            <div class="a-field"><label>SMTP Host</label><input type="text" name="smtp_host" value="<?= $v('smtp_host') ?>"></div>
            <div class="a-field"><label>SMTP Port</label><input type="text" name="smtp_port" value="<?= $v('smtp_port') ?>"></div>
        </div>
        <div class="a-row">
            <div class="a-field"><label>SMTP Kullanıcı</label><input type="text" name="smtp_user" value="<?= $v('smtp_user') ?>"></div>
            <div class="a-field"><label>SMTP Şifre</label><input type="password" name="smtp_password" value="<?= $v('smtp_password') ?>"></div>
        </div>
    </div>

    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Bildirim Ayarlarını Kaydet</button>
</form>

<div class="a-card" style="margin-top:22px">
    <div class="a-card__head"><h2>Son Bildirim Logları</h2></div>
    <?php if (!$logs): ?><div class="empty">Henüz log yok.</div><?php else: ?>
    <table class="a-table">
        <thead><tr><th>Olay</th><th>Kanal</th><th>Durum</th><th>Alıcı</th><th>Tarih</th></tr></thead>
        <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= e($log['event_type']) ?></td>
                <td><?= e($log['channel']) ?></td>
                <td><span class="tag <?= str_contains((string) $log['status'], 'sent') ? 'tag--ok' : 'tag--warn' ?>"><?= e($log['status']) ?></span></td>
                <td><small><?= e($log['recipient'] ?: '-') ?></small></td>
                <td><small><?= e(date('d.m H:i', strtotime($log['created_at'] ?? 'now'))) ?></small></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
