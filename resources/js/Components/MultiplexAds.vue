<template>
    <section>
        <ins class="adsbygoogle"
        style="display:block"
        data-ad-format="autorelaxed"
        data-ad-client="ca-pub-1280955201562800"
        data-ad-slot="5617282123"></ins>
    </section>
</template>

<script setup>
    import { ref, onMounted } from 'vue';

    onMounted(() => {
        const script = document.createElement('script');
        script.async = true;
        script.src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1280955201562800";
        script.crossOrigin = "anonymous";
        document.body.appendChild(script);

        script.onload = () => {
            (adsbygoogle = window.adsbygoogle || []).push({});
        };
    });
</script>