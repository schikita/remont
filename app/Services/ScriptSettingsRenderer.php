<?php

namespace App\Services;

use App\Models\ScriptSetting;

class ScriptSettingsRenderer
{
    public function head(): string
    {
        $s = ScriptSetting::current();

        return $this->wrap($s->head_scripts)
            .$this->googleAnalytics($s->google_analytics_id)
            .$this->googleTagManagerHead($s->google_tag_manager_id)
            .$this->yandexMetrika($s->yandex_metrika_id);
    }

    public function bodyStart(): string
    {
        $s = ScriptSetting::current();

        return $this->wrap($s->body_start_scripts)
            .$this->googleTagManagerNoscript($s->google_tag_manager_id);
    }

    public function bodyEnd(): string
    {
        $s = ScriptSetting::current();

        return $this->wrap($s->body_end_scripts);
    }

    private function wrap(?string $html): string
    {
        return $html ? $html."\n" : '';
    }

    private function googleAnalytics(?string $id): string
    {
        if (! $id) {
            return '';
        }

        return <<<HTML
<script async src="https://www.googletagmanager.com/gtag/js?id={$id}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{$id}');
</script>

HTML;
    }

    private function googleTagManagerHead(?string $id): string
    {
        if (! $id) {
            return '';
        }

        return <<<HTML
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{$id}');</script>

HTML;
    }

    private function googleTagManagerNoscript(?string $id): string
    {
        if (! $id) {
            return '';
        }

        return <<<HTML
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$id}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

HTML;
    }

    private function yandexMetrika(?string $id): string
    {
        if (! $id) {
            return '';
        }

        return <<<HTML
<script type="text/javascript">
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
   ym({$id}, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/{$id}" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

HTML;
    }
}
