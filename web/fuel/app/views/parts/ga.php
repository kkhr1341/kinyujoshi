<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-72608536-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-72608536-2', {
      'custom_map': {
          'dimension1': 'clientId'
      }
  });
  gtag('set', {'user_id': <?php echo $userid ?>});
</script>
