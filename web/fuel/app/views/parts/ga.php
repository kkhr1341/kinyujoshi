<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-72608536-11"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-72608536-11', {
      'custom_map': {
          'dimension1': 'clientId',
          'dimension2': 'secretBlog',
      }
  });
  gtag('set', {'user_id': <?php echo $userid ?>});
</script>
